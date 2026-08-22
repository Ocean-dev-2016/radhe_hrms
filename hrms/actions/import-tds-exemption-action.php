<?php
require_once('../root/config.php');
global $ai_db;
global $ai_conn;
global $ai_core;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
if ($company_id <= 0) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'No active company session. Please select a company first.']);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$username = isset($_SESSION['username']) ? mysqli_real_escape_string($ai_conn, $_SESSION['username']) : 'System';

// Determine Current Financial Year (e.g., Apr 2025 - Mar 2026 is 2025-2026)
$current_month = intval(date('n'));
$current_year = intval(date('Y'));
if ($current_month >= 4) {
    $default_fy = $current_year . '-' . ($current_year + 1);
} else {
    $default_fy = ($current_year - 1) . '-' . $current_year;
}

// Standard columns for TDS Exemption Upload Format
$columns = [
    'EMP CODE',
    'NAME',
    'FINANCIAL YEAR',
    'REGIME',
    'SECTION CODE',
    'SECTION NAME',
    'DECLARED AMOUNT',
    'VERIFIED AMOUNT',
    'REMARKS'
];

if ($action === 'format_file') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $sample_rows = [
        [
            '10001',
            'Rahul Sharma',
            $default_fy,
            'OLD',
            '80C',
            'Life Insurance, PPF, ELSS, Tuition Fees',
            '150000.00',
            '150000.00',
            'LIC Policy + PPF Receipt'
        ],
        [
            '10001',
            'Rahul Sharma',
            $default_fy,
            'OLD',
            '80D',
            'Medical Insurance Premium',
            '25000.00',
            '25000.00',
            'Self & Family Mediclaim'
        ],
        [
            '10001',
            'Rahul Sharma',
            $default_fy,
            'OLD',
            '80CCD(1B)',
            'Additional NPS Contribution',
            '50000.00',
            '50000.00',
            'NPS Tier-I Statement'
        ],
        [
            '10002',
            'Pooja Patel',
            $default_fy,
            'OLD',
            '80C',
            'EPF and Home Loan Principal',
            '120000.00',
            '120000.00',
            'Bank Home Loan Certificate'
        ],
        [
            '10002',
            'Pooja Patel',
            $default_fy,
            'OLD',
            '24(B)',
            'Interest on Home Loan (Self Occupied)',
            '180000.00',
            '180000.00',
            'Provisional Interest Certificate'
        ]
    ];

    $required_map = [
        'emp code' => true,
        'financial year' => true,
        'section code' => true,
        'declared amount' => true
    ];

    download_sample_xlsx('TDS_EXEMPTION_IMPORT_FORMAT.xlsx', $columns, $sample_rows, $required_map);
    exit;

} else if ($action === 'download_current') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $fy_filter = isset($_GET['fy']) && !empty($_GET['fy']) ? mysqli_real_escape_string($ai_conn, trim($_GET['fy'])) : '';

    $where_fy = $fy_filter ? "AND t.financial_year = '$fy_filter'" : "";

    $query = "SELECT e.emp_code, e.emp_name, 
                     COALESCE(t.financial_year, '$default_fy') AS financial_year,
                     COALESCE(t.regime, 'OLD') AS regime,
                     COALESCE(t.section_code, '80C') AS section_code,
                     COALESCE(t.section_name, 'Life Insurance, PPF, ELSS') AS section_name,
                     COALESCE(t.declared_amount, 0.00) AS declared_amount,
                     COALESCE(t.verified_amount, 0.00) AS verified_amount,
                     COALESCE(t.remarks, '') AS remarks
              FROM hrms_employeemaster e
              LEFT JOIN hrms_tds_exemptions t ON e.id = t.employee_id AND t.company_id = $company_id $where_fy
              WHERE e.company_id = $company_id AND e.status = 'active'
              ORDER BY e.emp_code ASC, t.section_code ASC";

    $records = $ai_db->aiGetQuery($query);
    $rows = [];

    if (!empty($records)) {
        foreach ($records as $rec) {
            $rows[] = [
                $rec['emp_code'],
                $rec['emp_name'],
                $rec['financial_year'],
                $rec['regime'] ?: 'OLD',
                $rec['section_code'] ?: '80C',
                $rec['section_name'] ?: '',
                number_format((float) $rec['declared_amount'], 2, '.', ''),
                number_format((float) $rec['verified_amount'], 2, '.', ''),
                $rec['remarks'] ?: ''
            ];
        }
    }

    $filename = 'CURRENT_TDS_EXEMPTIONS_' . ($fy_filter ?: 'ALL') . '.xlsx';
    download_sample_xlsx($filename, $columns, $rows);
    exit;

} else if ($action === 'load_excel') {
    header('Content-Type: application/json');
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded or file upload error.']);
        exit;
    }

    $file = $_FILES['file']['tmp_name'];
    $filename = $_FILES['file']['name'];
    $rows = $ai_core->aiParseImportFile($file, $filename);

    if ($rows !== false && count($rows) > 0) {
        $headers = array_shift($rows); // Read header row

        // Normalize headers
        $header_map = [];
        foreach ($headers as $idx => $header_name) {
            $cleaned_key = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string) $header_name));
            $header_map[$cleaned_key] = $idx;
        }

        $getVal = function ($data_row, $possible_names, $default_idx = -1) use ($header_map) {
            foreach ($possible_names as $name) {
                $cleaned = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string) $name));
                if (isset($header_map[$cleaned])) {
                    $idx = $header_map[$cleaned];
                    return trim((string) ($data_row[$idx] ?? ''));
                }
            }
            if ($default_idx >= 0) {
                return trim((string) ($data_row[$default_idx] ?? ''));
            }
            return '';
        };

        // Cache all existing active employees in the company for fast lookup
        $emp_lookup = [];
        $emp_list = $ai_db->aiGetQuery("SELECT id, emp_code, emp_name FROM hrms_employeemaster WHERE company_id = $company_id AND status = 'active'");
        foreach ($emp_list as $emp) {
            $code_key = strtoupper(trim($emp['emp_code']));
            $emp_lookup[$code_key] = [
                'id' => intval($emp['id']),
                'name' => $emp['emp_name']
            ];
        }

        // Cache TDS section names
        $sec_lookup = [];
        $sec_list = $ai_db->aiGetQuery("SELECT section_code, section_name, max_limit, regime FROM hrms_tds_codes WHERE company_id IN (0, $company_id)");
        foreach ($sec_list as $sec) {
            $s_code = strtoupper(trim($sec['section_code']));
            $sec_lookup[$s_code] = $sec['section_name'];
        }

        $preview_data = [];
        $valid_count = 0;
        $invalid_count = 0;
        $total_declared = 0.00;

        foreach ($rows as $row_idx => $data_row) {
            if (empty($data_row)) continue;

            $emp_code = $getVal($data_row, ['emp code', 'empcode', 'code', 'employee code'], 0);
            $emp_name = $getVal($data_row, ['name', 'emp name', 'employeename', 'employee name'], 1);
            $fy = $getVal($data_row, ['financial year', 'financialyear', 'fy', 'year'], 2);
            $regime = strtoupper($getVal($data_row, ['regime', 'tax regime', 'taxregime'], 3));
            $section_code = strtoupper($getVal($data_row, ['section code', 'sectioncode', 'section', 'sec code'], 4));
            $section_name = $getVal($data_row, ['section name', 'sectionname', 'description', 'particulars'], 5);
            $declared_amt_raw = $getVal($data_row, ['declared amount', 'declaredamt', 'declared', 'declaration', 'amount'], 6);
            $verified_amt_raw = $getVal($data_row, ['verified amount', 'verifiedamt', 'verified', 'proof amount', 'proofamt'], 7);
            $remarks = $getVal($data_row, ['remarks', 'remark', 'notes', 'note'], 8);

            if (empty($emp_code) && empty($emp_name) && empty($section_code)) {
                continue; // Empty row
            }

            if (empty($fy)) {
                $fy = $default_fy;
            }

            if (empty($regime) || !in_array($regime, ['OLD', 'NEW'])) {
                $regime = 'OLD';
            }

            $emp_code_upper = strtoupper(trim($emp_code));
            $emp_found = isset($emp_lookup[$emp_code_upper]);
            $resolved_name = $emp_name;

            if ($emp_found) {
                if (empty($resolved_name)) {
                    $resolved_name = $emp_lookup[$emp_code_upper]['name'];
                }
            }

            if (empty($section_code)) {
                $section_code = '80C';
            }

            if (empty($section_name) && isset($sec_lookup[$section_code])) {
                $section_name = $sec_lookup[$section_code];
            }

            $declared_amt = floatval(preg_replace('/[^0-9.]/', '', $declared_amt_raw));
            $verified_amt = floatval(preg_replace('/[^0-9.]/', '', $verified_amt_raw));

            // If verified amount is not specified, default to declared amount
            if (empty($verified_amt_raw) && $declared_amt > 0) {
                $verified_amt = $declared_amt;
            }

            $status_msg = 'Valid';
            $is_valid = true;

            if (empty($emp_code)) {
                $status_msg = 'Missing Emp Code';
                $is_valid = false;
            } else if (!$emp_found) {
                $status_msg = 'Employee Not Found';
                $is_valid = false;
            } else if ($declared_amt < 0) {
                $status_msg = 'Invalid Declared Amount';
                $is_valid = false;
            }

            if ($is_valid) {
                $valid_count++;
                $total_declared += $declared_amt;
            } else {
                $invalid_count++;
            }

            $preview_data[] = [
                'row_no' => $row_idx + 2,
                'emp_code' => $emp_code,
                'emp_name' => $resolved_name,
                'financial_year' => $fy,
                'regime' => $regime,
                'section_code' => $section_code,
                'section_name' => $section_name,
                'declared_amount' => $declared_amt,
                'verified_amount' => $verified_amt,
                'remarks' => $remarks,
                'is_valid' => $is_valid,
                'status_msg' => $status_msg
            ];
        }

        echo json_encode([
            'status' => 'success',
            'data' => $preview_data,
            'summary' => [
                'total_rows' => count($preview_data),
                'valid_rows' => $valid_count,
                'invalid_rows' => $invalid_count,
                'total_declared' => $total_declared
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or empty Excel/CSV file.']);
    }
    exit;

} else if ($action === 'upload_data') {
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }

    $input_data = isset($_POST['data']) ? json_decode($_POST['data'], true) : [];
    if (empty($input_data)) {
        echo json_encode(['status' => 'error', 'message' => 'No data received to upload.']);
        exit;
    }

    $success_count = 0;
    $error_count = 0;
    $updated_count = 0;
    $inserted_count = 0;
    $errors = [];

    // Cache employee ids
    $emp_lookup = [];
    $emp_list = $ai_db->aiGetQuery("SELECT id, emp_code FROM hrms_employeemaster WHERE company_id = $company_id AND status = 'active'");
    foreach ($emp_list as $emp) {
        $code_key = strtoupper(trim($emp['emp_code']));
        $emp_lookup[$code_key] = intval($emp['id']);
    }

    foreach ($input_data as $index => $row) {
        $emp_code = trim($row['emp_code'] ?? '');
        $emp_code_upper = strtoupper($emp_code);

        if (empty($emp_code) || !isset($emp_lookup[$emp_code_upper])) {
            $error_count++;
            $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Employee code '$emp_code' not found.";
            continue;
        }

        $employee_id = $emp_lookup[$emp_code_upper];
        $fy = mysqli_real_escape_string($ai_conn, trim($row['financial_year'] ?? $default_fy));
        $regime = mysqli_real_escape_string($ai_conn, trim($row['regime'] ?? 'OLD'));
        $section_code = mysqli_real_escape_string($ai_conn, strtoupper(trim($row['section_code'] ?? '80C')));
        $section_name = mysqli_real_escape_string($ai_conn, trim($row['section_name'] ?? ''));
        $declared_amt = floatval($row['declared_amount'] ?? 0.00);
        $verified_amt = floatval($row['verified_amount'] ?? 0.00);
        $remarks = mysqli_real_escape_string($ai_conn, trim($row['remarks'] ?? ''));

        // Check if record exists for this employee, FY, and section code
        $check_existing = $ai_db->aiGetQuery("SELECT id FROM hrms_tds_exemptions 
                                              WHERE company_id = $company_id 
                                                AND employee_id = $employee_id 
                                                AND financial_year = '$fy' 
                                                AND section_code = '$section_code' LIMIT 1");

        if (!empty($check_existing)) {
            $existing_id = intval($check_existing[0]['id']);
            $update_sql = "UPDATE hrms_tds_exemptions 
                           SET regime = '$regime',
                               section_name = '$section_name',
                               declared_amount = $declared_amt,
                               verified_amount = $verified_amt,
                               remarks = '$remarks',
                               updated_by = '$username',
                               updated_at = CURRENT_TIMESTAMP
                           WHERE id = $existing_id";
            if ($ai_db->aiQuery($update_sql)) {
                $success_count++;
                $updated_count++;
            } else {
                $error_count++;
                $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Failed to update database.";
            }
        } else {
            $insert_sql = "INSERT INTO hrms_tds_exemptions 
                           (company_id, employee_id, financial_year, regime, section_code, section_name, declared_amount, verified_amount, remarks, created_by, updated_by)
                           VALUES 
                           ($company_id, $employee_id, '$fy', '$regime', '$section_code', '$section_name', $declared_amt, $verified_amt, '$remarks', '$username', '$username')";
            if ($ai_db->aiQuery($insert_sql)) {
                $success_count++;
                $inserted_count++;
            } else {
                $error_count++;
                $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Failed to insert into database.";
            }
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => "Process completed! Total Processed: $success_count (Inserted: $inserted_count, Updated: $updated_count). Failed: $error_count.",
        'success_count' => $success_count,
        'inserted_count' => $inserted_count,
        'updated_count' => $updated_count,
        'error_count' => $error_count,
        'errors' => $errors
    ]);
    exit;

} else {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid action requested.']);
    exit;
}
