<?php
include 'root/config.php';
$ai_core->aiCheckLogin();

$mode = $_REQUEST['mode'] ?? 'list';

// ---- EARLY AJAX INTERCEPT (must be before header.php) ----
if ($mode === 'list' && isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
    // This block handles AJAX filter/pagination requests.
    // It must run before header.php to avoid HTML contaminating the JSON response.

    $table = "tbl_insurance";
    $page_req = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $limit = 10;
    $offset = ($page_req - 1) * $limit;

    $where = " WHERE 1=1";
    $search = $_REQUEST['search'] ?? '';
    if (!empty($search)) {
        $where .= " AND (t.policy_no LIKE '%$search%' OR t.email LIKE '%$search%' OR t.mobile LIKE '%$search%' OR t.gst_no LIKE '%$search%' OR c.name LIKE '%$search%' OR cons.name LIKE '%$search%')";
    }
    if (!empty($_REQUEST['insurance_type'])) {
        $where .= " AND t.insurance_type LIKE '" . addslashes($_REQUEST['insurance_type']) . "'";
    }
    if (!empty($_REQUEST['business_type'])) {
        $where .= " AND t.business_type LIKE '" . addslashes($_REQUEST['business_type']) . "'";
    }
    if (!empty($_REQUEST['customer_type'])) {
        $where .= " AND t.customer_type LIKE '" . addslashes($_REQUEST['customer_type']) . "'";
    }
    if (!empty($_REQUEST['medical_cover'])) {
        $where .= " AND t.medical_cover = '" . intval($_REQUEST['medical_cover']) . "'";
    }
    if (!empty($_REQUEST['insurance_company'])) {
        $where .= " AND t.insurance_company = '" . intval($_REQUEST['insurance_company']) . "'";
    }
    if (!empty($_REQUEST['from_date'])) {
        $where .= " AND t.start_date >= '" . addslashes($_REQUEST['from_date']) . "'";
    }
    if (!empty($_REQUEST['to_date'])) {
        $where .= " AND t.start_date <= '" . addslashes($_REQUEST['to_date']) . "'";
    }
    if (!empty($_REQUEST['policy_status'])) {
        $ps = $_REQUEST['policy_status'];
        if ($ps === 'Running') {
            $where .= " AND CURDATE() BETWEEN t.start_date AND t.end_date";
        } elseif ($ps === 'Close') {
            $where .= " AND CURDATE() > t.end_date";
        } elseif ($ps === 'Pending') {
            $where .= " AND CURDATE() < t.start_date";
        }
    }

    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table t
            LEFT JOIN tbl_vendors_companies c ON t.company_id = c.id
            LEFT JOIN tbl_vendors_consumers cons ON t.consumer_id = cons.id $where");
    $total_records = $total_res[0]->total ?? 0;
    $total_pages = $total_records > 0 ? ceil($total_records / $limit) : 1;
    $page = $page_req;

    $sql = "SELECT t.*,
                   CONCAT(IFNULL(c.name, ''), IF(c.name IS NOT NULL AND cons.name IS NOT NULL, ' / ', ''), IFNULL(cons.name, '')) as client_name,
                   mc.name as mc_name, ic.name as ic_name
            FROM $table t
            LEFT JOIN tbl_vendors_companies c ON t.company_id = c.id
            LEFT JOIN tbl_vendors_consumers cons ON t.consumer_id = cons.id
            LEFT JOIN tbl_medical_covers mc ON t.medical_cover = mc.id
            LEFT JOIN tbl_insurance_companies ic ON t.insurance_company = ic.id
            $where ORDER BY t.id DESC LIMIT $limit OFFSET $offset";
    $list_data = $ai_db->aiGetQueryObj($sql);
    if (!is_array($list_data)) $list_data = [];

    ob_start();
    $type_colors = [
        'life'    => ['bg' => '#e8f5e9', 'color' => '#2e7d32', 'label' => 'Life'],
        'health'  => ['bg' => '#e3f2fd', 'color' => '#1565c0', 'label' => 'Health'],
        'vehicle' => ['bg' => '#fff3e0', 'color' => '#e65100', 'label' => 'Vehicle'],
        'fire'    => ['bg' => '#fce4ec', 'color' => '#c62828', 'label' => 'Fire'],
        'ecp'     => ['bg' => '#f3e5f5', 'color' => '#6a1b9a', 'label' => 'ECP'],
    ];
    $redirection_url_ajax = 'insurance.php';
    $today = date('Y-m-d');
    $sr_no = ($page - 1) * $limit + 1;
    ?>
        <table class="table table-hover align-middle mb-0" style="font-size:12.2px;">
            <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                <tr>
                    <th class="ps-4 py-3 text-muted fw-bold" style="width:40px;">Sr</th>
                    <th class="py-3 text-muted fw-bold">Insurance Type</th>
                    <th class="py-3 text-muted fw-bold">Vendor Detail</th>
                    <th class="py-3 text-muted fw-bold">Type Details</th>
                    <th class="py-3 text-muted fw-bold">Policy Detail</th>
                    <th class="py-3 text-muted fw-bold">Insurance/Medical</th>
                    <th class="py-3 text-muted fw-bold">Gross Premium</th>
                    <th class="py-3 text-muted fw-bold">Status</th>
                    <th class="py-3 text-muted fw-bold">Document</th>
                    <th class="py-3 text-muted fw-bold text-end pe-4">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($list_data)): ?>
                    <tr>
                        <td colspan="10" class="text-center py-5 text-muted">
                            <i class="ti ti-file-off fs-40 mb-2 d-block"></i>
                            No policies found.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($list_data as $row):
                        $t = strtolower($row->insurance_type ?? '');
                        $tc = $type_colors[$t] ?? ['bg' => '#f5f5f5', 'color' => '#555', 'label' => ucfirst($t)];

                        $ps_label = '—';
                        $ps_class = 'bg-light text-muted';
                        if (!empty($row->start_date) && !empty($row->end_date)) {
                            if ($today < $row->start_date) {
                                $ps_label = 'Pending';
                                $ps_class = 'bg-soft-info text-info';
                            } elseif ($today >= $row->start_date && $today <= $row->end_date) {
                                $ps_label = 'Running';
                                $ps_class = 'bg-soft-success text-success';
                            } else {
                                $ps_label = 'Close';
                                $ps_class = 'bg-soft-danger text-danger';
                            }
                        }
                        $start_disp = (!empty($row->start_date) && $row->start_date != '0000-00-00') ? date('d M, Y', strtotime($row->start_date)) : '—';
                        $end_disp   = (!empty($row->end_date) && $row->end_date != '0000-00-00') ? date('d M, Y', strtotime($row->end_date)) : '—';
                        $can_edit   = $ai_core->aiCheckPermission('insurance', 'edit');
                        $can_delete = $ai_core->aiCheckPermission('insurance', 'delete');
                    ?>
                        <tr>
                            <td class="ps-4 py-3 text-muted fw-bold"><?php echo $sr_no++; ?></td>
                            <td>
                                <span class="badge fw-bold px-2 py-1 rounded" style="background:<?php echo $tc['bg']; ?>;color:<?php echo $tc['color']; ?>;font-size:11px;">
                                    <?php echo htmlspecialchars($tc['label']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($row->client_name ?: '—'); ?></div>
                                <?php if (!empty($row->email)): ?>
                                    <div class="text-muted small"><i class="ti ti-mail me-1"></i><?php echo htmlspecialchars($row->email); ?></div>
                                <?php endif; ?>
                                <?php if (!empty($row->mobile)): ?>
                                    <div class="text-muted small"><i class="ti ti-phone me-1"></i><?php echo htmlspecialchars($row->mobile); ?></div>
                                <?php endif; ?>
                                <?php if (!empty($row->gst_no)): ?>
                                    <div class="text-muted small"><i class="ti ti-file-invoice me-1"></i><?php echo htmlspecialchars($row->gst_no); ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-semibold small"><?php echo htmlspecialchars($row->business_type ?: '—'); ?></div>
                                <div class="text-muted small"><?php echo htmlspecialchars($row->customer_type ?: '—'); ?></div>
                            </td>
                            <td>
                                <?php if (!empty($row->policy_no)): ?>
                                    <div class="fw-bold text-dark mb-1">
                                        <i class="ti ti-hash me-1 text-muted"></i><?php echo htmlspecialchars($row->policy_no); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="text-muted small"><i class="ti ti-calendar me-1"></i><?php echo $start_disp; ?></div>
                                <div class="text-muted small"><i class="ti ti-calendar me-1"></i><?php echo $end_disp; ?></div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-1">
                                    <?php echo htmlspecialchars($row->ic_name ?? ($row->insurance_company ?: '—')); ?>
                                </div>
                                <?php if ($row->mc_name): ?>
                                    <div class="badge bg-soft-primary text-primary border-0 fw-normal"
                                        style="font-size:10px;"><?php echo htmlspecialchars($row->mc_name); ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="fw-bold text-dark" style="font-size:14px;">₹<?php echo number_format($row->gross_premium, 2); ?></span>
                            </td>
                            <td>
                                <span class="badge rounded-pill <?php echo $ps_class; ?> px-3 py-2 fw-bold"
                                    style="font-size:10px; letter-spacing:0.5px;">
                                    <?php echo strtoupper($ps_label); ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($row->policy_doc)): ?>
                                    <a href="uploads/insurance/<?php echo htmlspecialchars($row->policy_doc); ?>" target="_blank"
                                        class="btn btn-soft-primary btn-sm rounded-circle shadow-none" title="View Document">
                                        <i class="ti ti-file-text fs-18"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <?php if ($can_edit): ?>
                                        <a href="insurance.php?mode=edit&id=<?php echo $row->id; ?>" class="btn btn-soft-primary btn-sm rounded-circle shadow-none" title="Edit">
                                            <i class="ti ti-edit fs-16"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($can_delete): ?>
                                        <a href="insurance.php?mode=delete&id=<?php echo $row->id; ?>" onclick="return confirm('Delete this policy?')" class="btn btn-soft-danger btn-sm rounded-circle shadow-none" title="Delete">
                                            <i class="ti ti-trash fs-16"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if ($total_records > $limit): ?>
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top bg-light">
                <small class="text-muted"><?php echo $total_records; ?> records found</small>
                <nav>
                    <ul class="pagination pagination-sm justify-content-end mb-0">
                        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link ajax-page" href="#" data-page="<?php echo $page - 1; ?>">Previous</a>
                        </li>
                        <?php
                        if ($total_pages <= 10) {
                            for ($i = 1; $i <= $total_pages; $i++) {
                                $active = ($i == $page) ? 'active' : '';
                                echo "<li class='page-item $active'><a class='page-link ajax-page' href='#' data-page='$i'>$i</a></li>";
                            }
                        } else {
                            if ($page < 4) {
                                for ($i = 1; $i <= 4; $i++) {
                                    $active = ($i == $page) ? 'active' : '';
                                    echo "<li class='page-item $active'><a class='page-link ajax-page' href='#' data-page='$i'>$i</a></li>";
                                }
                                echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                echo "<li class='page-item'><a class='page-link ajax-page' href='#' data-page='$total_pages'>$total_pages</a></li>";
                            } elseif ($page >= 4 && $page < $total_pages - 3) {
                                echo "<li class='page-item'><a class='page-link ajax-page' href='#' data-page='1'>1</a></li>";
                                echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                for ($i = $page; $i <= $page + 3; $i++) {
                                    $active = ($i == $page) ? 'active' : '';
                                    echo "<li class='page-item $active'><a class='page-link ajax-page' href='#' data-page='$i'>$i</a></li>";
                                }
                                echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                echo "<li class='page-item'><a class='page-link ajax-page' href='#' data-page='$total_pages'>$total_pages</a></li>";
                            } else {
                                echo "<li class='page-item'><a class='page-link ajax-page' href='#' data-page='1'>1</a></li>";
                                echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                for ($i = $total_pages - 4; $i <= $total_pages; $i++) {
                                    $active = ($i == $page) ? 'active' : '';
                                    echo "<li class='page-item $active'><a class='page-link ajax-page' href='#' data-page='$i'>$i</a></li>";
                                }
                            }
                        }
                        ?>
                        <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link ajax-page" href="#" data-page="<?php echo $page + 1; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    <?php
    $html = ob_get_clean();
    header('Content-Type: application/json');
    echo json_encode(['html' => $html]);
    exit;
}

// Check Permissions
if ($mode == 'list' && !$ai_core->aiCheckPermission('insurance', 'view')) {
    $_SESSION['error'] = "You do not have permission to view insurance records.";
    $ai_core->aiGoPage("dashboard.php");
}
if ($mode == 'add' && !$ai_core->aiCheckPermission('insurance', 'add')) {
    $_SESSION['error'] = "You do not have permission to add insurance records.";
    $ai_core->aiGoPage("insurance.php");
}
if ($mode == 'edit' && !$ai_core->aiCheckPermission('insurance', 'edit')) {
    $_SESSION['error'] = "You do not have permission to edit insurance records.";
    $ai_core->aiGoPage("insurance.php");
}
if ($mode == 'delete' && !$ai_core->aiCheckPermission('insurance', 'delete')) {
    $_SESSION['error'] = "You do not have permission to delete insurance records.";
    $ai_core->aiGoPage("insurance.php");
}
// --- CONFIGURATION ---
$type_param = $_GET['type'] ?? '';
$page_nm = $type_param ? "Insurance " . strtoupper($type_param) : "Insurance Management";
$table = "tbl_insurance";
$redirection_url = "insurance.php";
$docUrl = "assets/docs/policies/";

if (!is_dir($docUrl)) {
    mkdir($docUrl, 0777, true);
}

$mode = $_REQUEST['mode'] ?? 'list';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$data = null;

if (!function_exists('normalizeInsuranceDateValue')) {
    function normalizeInsuranceDateValue($value, $default = '')
    {
        $value = trim((string) $value);
        if ($value === '') {
            return $default;
        }

        if (is_numeric($value)) {
            $excelSerial = floatval($value);
            if ($excelSerial > 20000 && $excelSerial < 80000) {
                $unix = (intval($excelSerial) - 25569) * 86400;
                return gmdate('Y-m-d', $unix);
            }
        }

        $formats = ['Y-m-d', 'd-m-Y', 'd-m-y', 'Y/m/d', 'd/m/Y', 'd/m/y', 'd.m.Y', 'd.m.y', 'm/d/Y', 'm/d/y'];
        foreach ($formats as $format) {
            $dt = DateTime::createFromFormat($format, $value);
            if ($dt instanceof DateTime) {
                return $dt->format('Y-m-d');
            }
        }

        $timestamp = strtotime($value);
        if ($timestamp !== false) {
            return date('Y-m-d', $timestamp);
        }

        return $default;
    }
}

if (!function_exists('insuranceDateForInput')) {
    function insuranceDateForInput($value)
    {
        return normalizeInsuranceDateValue($value, '');
    }
}

if (!function_exists('normalizeInsuranceChoice')) {
    function normalizeInsuranceChoice($value, $allowed)
    {
        $raw = trim((string) $value);
        if ($raw === '') {
            return '';
        }
        foreach ((array) $allowed as $option) {
            if (strcasecmp($raw, (string) $option) === 0) {
                return (string) $option;
            }
        }
        return '';
    }
}

// --- HANDLE CSV IMPORT ---
if (isset($_POST['btn_import'])) {
    if (!$ai_core->aiCheckPermission('insurance', 'add')) {
        $_SESSION['error'] = "You do not have permission to import data.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    $file = $_FILES['import_file']['tmp_name'] ?? '';
    $import_type_input = strtoupper(trim((string) ($_POST['import_insurance_type'] ?? 'ECP')));
    $allowed_import_types = ['ECP', 'LIFE', 'FIRE', 'VEHICLE', 'HEALTH'];
    $import_type_default = in_array($import_type_input, $allowed_import_types, true) ? $import_type_input : 'ECP';
    if (!empty($file)) {
        $filename = $_FILES['import_file']['name'] ?? '';
        $rows = $ai_core->aiParseImportFile($file, $filename);
        if ($rows !== false && count($rows) > 0) {
            $header = array_shift($rows);
            $header_map = [];
            $normalize_col = function ($value) {
                $value = strtolower(trim((string) $value));
                $value = str_replace([' ', '-'], '_', $value);
                return preg_replace('/[^a-z0-9_]/', '', $value);
            };
            if (is_array($header)) {
                foreach ($header as $index => $column) {
                    $column_key = $normalize_col($column);
                    $header_map[$column_key] = $index;
                }
            }
        $has_client_combined_column = isset($header_map[$normalize_col('Company / Consumer')]) || isset($header_map[$normalize_col('Company/Consumer')]);
        $has_company_column = isset($header_map[$normalize_col('Company')]) || isset($header_map[$normalize_col('Company Name')]);
        $has_company_id_column = isset($header_map[$normalize_col('company_id')]) || isset($header_map[$normalize_col('Company ID')]);
        $has_consumer_id_column = isset($header_map[$normalize_col('consumer_id')]) || isset($header_map[$normalize_col('Consumer ID')]);

        $count = 0;
        $import_aliases = [
            'insurance_type' => ['Insurance Type'],
            'client_combined' => ['Company / Consumer', 'Company/Consumer'],
            'company_only' => ['Company', 'Company Name'],
            'business_type' => ['Business Type'],
            'customer_type' => ['Customer Type'],
            'policy_no' => ['Policy Number'],
            'proposer_name' => ['Proposer Name'],
            'email' => ['Email Address'],
            'mobile' => ['Mobile Number'],
            'start_date' => ['Policy Start Date'],
            'end_date' => ['Policy End Date'],
            'plan_name' => ['Plan Name'],
            'medical_cover' => ['Medical Cover'],
            'total_sum_insured' => ['Total Sum Insured'],
            'gst_no' => ['GST Number'],
            'pan_no' => ['PAN Number'],
            'net_premium' => ['Net Premium'],
            'gross_premium' => ['Gross Premium (inc. 18% GST)', 'Gross Premium'],
            'insurance_company' => ['Insurance Company'],
            'policy_doc' => ['Policy Document'],
            'remarks' => ['Remarks'],
            'status' => ['Status'],
            'organisation_name' => ['Organisation / Policy Holder Name', 'Organisation/Policy Holder Name'],
            'subproduct_id' => ['Sub product'],
            'segment_id' => ['Segment'],
            'vehicle_no' => ['Vehicle Number'],
            'mfg_company' => ['Manufacturer Company Name'],
            'model_name' => ['Model Name'],
            'mfg_year' => ['Manufacturer Year'],
            'idv' => ['IDV'],
            'issue_date' => ['Issue Date'],
            'dob' => ['DOB'],
            'premium_term' => ['Premium Terms'],
            'payment_term' => ['Premium Payment Terms'],
            'payment_mode' => ['Payment Mode']
        ];

        $get_col = function ($row, $key, $default = '') use ($header_map, $normalize_col, $import_aliases) {
            $alias_keys = $import_aliases[$key] ?? [];
            // For import fields users usually provide by label, prefer label columns first.
            if (in_array($key, ['company_only', 'client_combined', 'insurance_company', 'subproduct_id', 'segment_id', 'medical_cover'], true)) {
                $try_keys = array_merge($alias_keys, [$key]);
            } else {
                $try_keys = array_merge([$key], $alias_keys);
            }
            foreach ($try_keys as $k) {
                $normalized_key = $normalize_col($k);
                if (!isset($header_map[$normalized_key])) {
                    continue;
                }
                $value = trim((string) ($row[$header_map[$normalized_key]] ?? ''));
                if ($value !== '') {
                    return $value;
                }
            }
            return $default;
        };

        $to_key = function ($v) {
            return strtolower(trim((string) $v));
        };

        $companies = $ai_db->aiGetQueryObj("SELECT id, name, company_name FROM tbl_vendors_companies");
        $consumers = $ai_db->aiGetQueryObj("SELECT id, name FROM tbl_vendors_consumers");
        $medical_covers = $ai_db->aiGetQueryObj("SELECT id, name FROM tbl_medical_covers");
        $insurance_companies = $ai_db->aiGetQueryObj("SELECT id, name FROM tbl_insurance_companies");
        $subproducts = $ai_db->aiGetQueryObj("SELECT id, name FROM tbl_subproducts");
        $segments = $ai_db->aiGetQueryObj("SELECT id, name FROM tbl_segments");

        $build_index = function ($rows) use ($to_key) {
            $by_id = [];
            $by_name = [];
            if (!is_array($rows)) {
                return [$by_id, $by_name];
            }
            foreach ($rows as $r) {
                $id = intval($r->id ?? 0);
                $name = trim((string) ($r->name ?? ''));
                $alt_name = trim((string) ($r->company_name ?? ''));
                if ($id > 0) {
                    $by_id[$id] = true;
                }
                if ($name !== '') {
                    $by_name[$to_key($name)] = $id;
                }
                if ($alt_name !== '') {
                    $by_name[$to_key($alt_name)] = $id;
                }
            }
            return [$by_id, $by_name];
        };

        [$company_ids, $company_names] = $build_index($companies);
        [$consumer_ids, $consumer_names] = $build_index($consumers);
        [$medical_ids, $medical_names] = $build_index($medical_covers);
        [$ins_company_ids, $ins_company_names] = $build_index($insurance_companies);
        [$subproduct_ids, $subproduct_names] = $build_index($subproducts);
        [$segment_ids, $segment_names] = $build_index($segments);

        $resolve_lookup_id = function ($raw_value, $id_index, $name_index, $field_label, &$row_errors) use ($to_key) {
            $value = trim((string) $raw_value);
            if ($value === '') {
                return 0;
            }

            if (ctype_digit($value)) {
                $id = intval($value);
                return ($id > 0 && isset($id_index[$id])) ? $id : 0;
            }

            $name_key = $to_key($value);
            if (isset($name_index[$name_key]) && intval($name_index[$name_key]) > 0) {
                return intval($name_index[$name_key]);
            }

            return 0;
        };
        $resolve_lookup_id_or_create = function ($raw_value, &$id_index, &$name_index, $field_label, $table_name, &$row_errors) use ($to_key, $ai_db) {
            $value = trim((string) $raw_value);
            if ($value === '') {
                return 0;
            }

            if (ctype_digit($value)) {
                $id = intval($value);
                return ($id > 0 && isset($id_index[$id])) ? $id : 0;
            }

            $name_key = $to_key($value);
            if (isset($name_index[$name_key]) && intval($name_index[$name_key]) > 0) {
                return intval($name_index[$name_key]);
            }
            return 0;
        };
        $resolve_company_lookup_id = function ($raw_value, $field_label, &$row_errors) use ($to_key, $ai_db, &$company_ids, &$company_names) {
            $value = trim((string) $raw_value);
            if ($value === '') {
                return 0;
            }

            if (ctype_digit($value)) {
                $id = intval($value);
                return ($id > 0 && isset($company_ids[$id])) ? $id : 0;
            }

            $name_key = $to_key($value);
            if (isset($company_names[$name_key]) && intval($company_names[$name_key]) > 0) {
                return intval($company_names[$name_key]);
            }

            return 0;
        };

        $errors = [];
        $row_no = 1;
        foreach ($rows as $data_row) {
            $row_no++;
            if (empty(array_filter($data_row, fn($v) => trim((string) $v) !== ''))) {
                continue;
            }

            $row_errors = [];
            $row_type_raw = strtoupper(trim((string) $get_col($data_row, 'insurance_type', '')));
            if ($row_type_raw === '') {
                $row_type_raw = $import_type_default;
            }
            if (!in_array($row_type_raw, $allowed_import_types, true)) {
                $row_errors[] = "Insurance Type: invalid value '$row_type_raw'";
            }
            if ($row_type_raw !== $import_type_default) {
                $row_errors[] = "Insurance Type mismatch: selected '$import_type_default' but row has '$row_type_raw'";
            }
            $insurance_type = addslashes($row_type_raw);

            $company_type = strtolower(trim($get_col($data_row, 'company_type', 'company')));
            if (!in_array($company_type, ['company', 'consumer'])) {
                $company_type = 'company';
            }
            // Resolve raw ID fields only if no form-style client fields are provided.
            // This avoids false validation errors when CSV has extra legacy columns.
            $company_id_raw = trim((string) $get_col($data_row, 'company_id', ''));
            $consumer_id_raw = trim((string) $get_col($data_row, 'consumer_id', ''));
            $company_id = 0;
            $consumer_id = 0;

            // Support form-style import fields
            $client_combined = trim((string) $get_col($data_row, 'client_combined', ''));
            if ($client_combined !== '') {
                if (strpos($client_combined, '|') !== false) {
                    $parts = explode('|', $client_combined, 2);
                    $cc_type = strtolower(trim((string) ($parts[0] ?? '')));
                    $cc_value = trim((string) ($parts[1] ?? ''));
                    if (in_array($cc_type, ['company', 'consumer'])) {
                        if ($cc_type === 'company') {
                            $company_type = 'company';
                            $company_id = $resolve_company_lookup_id($cc_value, 'Company / Consumer', $row_errors);
                            $consumer_id = 0;
                        } else {
                            $company_type = 'consumer';
                            $consumer_id = $resolve_lookup_id($cc_value, $consumer_ids, $consumer_names, 'Company / Consumer', $row_errors);
                            $company_id = 0;
                        }
                    } else {
                        $company_id = 0;
                        $consumer_id = 0;
                    }
                } else {
                    // Name only: infer type from master tables
                    $key = $to_key($client_combined);
                    $match_company = $company_names[$key] ?? 0;
                    $match_consumer = $consumer_names[$key] ?? 0;
                    if ($match_company && $match_consumer) {
                        $company_type = 'company';
                        $company_id = intval($match_company);
                        $consumer_id = 0;
                    } elseif ($match_company) {
                        $company_type = 'company';
                        $company_id = intval($match_company);
                        $consumer_id = 0;
                    } elseif ($match_consumer) {
                        $company_type = 'consumer';
                        $consumer_id = intval($match_consumer);
                        $company_id = 0;
                    } else {
                        $company_id = 0;
                        $consumer_id = 0;
                    }
                }
            }

            $company_only_raw = trim((string) $get_col($data_row, 'company_only', ''));
            $company_only = $resolve_company_lookup_id($company_only_raw, 'Company', $row_errors);
            if ($company_only > 0) {
                $company_type = 'company';
                $company_id = $company_only;
                $consumer_id = 0;
            }
            if (
                $company_id <= 0
                && $consumer_id <= 0
                && !$has_client_combined_column
                && !$has_company_column
                && ($has_company_id_column || $has_consumer_id_column)
            ) {
                $company_id = $resolve_company_lookup_id($company_id_raw, 'Company', $row_errors);
                $consumer_id = $resolve_lookup_id($consumer_id_raw, $consumer_ids, $consumer_names, 'Consumer', $row_errors);
            }
            $business_type = addslashes(normalizeInsuranceChoice($get_col($data_row, 'business_type', ''), ['Fresh/New', 'Renewal/Rollover', 'Endorsement']));
            $customer_type = addslashes(normalizeInsuranceChoice($get_col($data_row, 'customer_type', ''), ['Individual', 'Organisation']));
            $subproduct_id = $resolve_lookup_id_or_create($get_col($data_row, 'subproduct_id', ''), $subproduct_ids, $subproduct_names, 'Sub product', 'tbl_subproducts', $row_errors);
            $segment_id = $resolve_lookup_id_or_create($get_col($data_row, 'segment_id', ''), $segment_ids, $segment_names, 'Segment', 'tbl_segments', $row_errors);
            $proposer_name = addslashes($get_col($data_row, 'proposer_name', ''));
            $plan_name = addslashes($get_col($data_row, 'plan_name', ''));
            $organisation_name = addslashes($get_col($data_row, 'organisation_name', ''));
            $issue_date = addslashes(normalizeInsuranceDateValue($get_col($data_row, 'issue_date', ''), ''));
            $dob = addslashes(normalizeInsuranceDateValue($get_col($data_row, 'dob', ''), ''));
            $premium_term = addslashes($get_col($data_row, 'premium_term', ''));
            $payment_term = addslashes($get_col($data_row, 'payment_term', ''));
            $payment_mode = addslashes(normalizeInsuranceChoice($get_col($data_row, 'payment_mode', ''), ['Monthly', 'Quarterly', 'Half Yearly', 'Yearly']));
            $vehicle_name = addslashes($get_col($data_row, 'vehicle_name', ''));
            $vehicle_no = addslashes($get_col($data_row, 'vehicle_no', ''));
            $mfg_company = addslashes($get_col($data_row, 'mfg_company', ''));
            $model_name = addslashes($get_col($data_row, 'model_name', ''));
            $mfg_year = addslashes($get_col($data_row, 'mfg_year', ''));
            $idv = floatval($get_col($data_row, 'idv', 0));
            $policy_no = addslashes($get_col($data_row, 'policy_no', ''));
            $email = addslashes($get_col($data_row, 'email', ''));
            $mobile = addslashes($get_col($data_row, 'mobile', ''));
            $start_date = addslashes(normalizeInsuranceDateValue($get_col($data_row, 'start_date', date('Y-m-d')), date('Y-m-d')));
            $end_date = addslashes(normalizeInsuranceDateValue($get_col($data_row, 'end_date', date('Y-m-d', strtotime('+1 year'))), date('Y-m-d', strtotime('+1 year'))));
            $medical_cover = $resolve_lookup_id($get_col($data_row, 'medical_cover', ''), $medical_ids, $medical_names, 'Medical Cover', $row_errors);
            $total_sum_insured = floatval($get_col($data_row, 'total_sum_insured', 0));
            $gst_no = addslashes($get_col($data_row, 'gst_no', ''));
            $pan_no = addslashes($get_col($data_row, 'pan_no', ''));
            $net_premium = floatval($get_col($data_row, 'net_premium', 0));
            $gst_amount = floatval($get_col($data_row, 'gst_amount', ($net_premium * 0.18)));
            $gross_premium = floatval($get_col($data_row, 'gross_premium', ($net_premium + $gst_amount)));
            $insurance_company = $resolve_lookup_id_or_create($get_col($data_row, 'insurance_company', ''), $ins_company_ids, $ins_company_names, 'Insurance Company', 'tbl_insurance_companies', $row_errors);
            $policy_doc = addslashes($get_col($data_row, 'policy_doc', ''));
            $remarks = addslashes($get_col($data_row, 'remarks', ''));
            $status = strtolower(addslashes(normalizeInsuranceChoice($get_col($data_row, 'status', ''), ['active', 'inactive', 'expired', 'pending'])));
            if ($status === '') {
                $status = 'active';
            }

            if (!empty($row_errors)) {
                $errors[] = "Row $row_no: " . implode('; ', array_unique($row_errors));
                continue;
            }

            $sql = "INSERT INTO $table SET insurance_type='$insurance_type', company_type='$company_type', company_id='$company_id', consumer_id='$consumer_id', business_type='$business_type', customer_type='$customer_type', subproduct_id='$subproduct_id', segment_id='$segment_id', proposer_name='$proposer_name', plan_name='$plan_name', organisation_name='$organisation_name', issue_date='$issue_date', dob='$dob', premium_term='$premium_term', payment_term='$payment_term', payment_mode='$payment_mode', vehicle_name='$vehicle_name', vehicle_no='$vehicle_no', mfg_company='$mfg_company', model_name='$model_name', mfg_year='$mfg_year', idv='$idv', policy_no='$policy_no', email='$email', mobile='$mobile', start_date='$start_date', end_date='$end_date', medical_cover='$medical_cover', total_sum_insured='$total_sum_insured', gst_no='$gst_no', pan_no='$pan_no', net_premium='$net_premium', gst_amount='$gst_amount', gross_premium='$gross_premium', insurance_company='$insurance_company', policy_doc='$policy_doc', remarks='$remarks', status='$status'";
            if ($ai_db->aiQuery($sql)) {
                $count++;
            }
        }
        if (!empty($errors)) {
            $preview = implode(' | ', array_slice($errors, 0, 3));
            $remaining = count($errors) > 3 ? ' | +' . (count($errors) - 3) . ' more errors' : '';
            $_SESSION['error'] = "Import validation failed. $count rows imported, " . count($errors) . " rows failed. $preview$remaining";
        } else {
            $_SESSION['success'] = "$count policies imported successfully!";
        }
        } else {
            $_SESSION['error'] = "Invalid or empty import file!";
        }
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
}

if (!function_exists('getInsuranceSampleConfig')) {
    function getInsuranceSampleConfig($sample_type)
    {
        $sample_type = strtoupper(trim((string) $sample_type));
        $base_defaults = [
            'insurance_type' => $sample_type,
            'business_type' => 'Fresh/New',
            'customer_type' => 'Organisation',
            'policy_no' => 'POL12345',
            'email' => 'client@example.com',
            'mobile' => '9876543210',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime('+1 year')),
            'net_premium' => '10000',
            'gross_premium' => '11800',
            'insurance_company' => 'Insurance Company Name',
            'policy_doc' => '',
            'remarks' => 'Sample import row',
            'status' => 'active'
        ];

        switch ($sample_type) {
            case 'HEALTH':
                $columns = [
                    'insurance_type',
                    'client_combined',
                    'business_type',
                    'customer_type',
                    'policy_no',
                    'proposer_name',
                    'email',
                    'mobile',
                    'start_date',
                    'end_date',
                    'plan_name',
                    'medical_cover',
                    'net_premium',
                    'gross_premium',
                    'insurance_company',
                    'policy_doc',
                    'remarks',
                    'status'
                ];
                $defaults = array_merge($base_defaults, [
                    'client_combined' => 'company|Company Name',
                    'proposer_name' => 'Radhe Client',
                    'plan_name' => 'Health Plan A',
                    'medical_cover' => 'Medical Cover Name'
                ]);
                break;

            case 'FIRE':
                $columns = [
                    'insurance_type',
                    'client_combined',
                    'business_type',
                    'customer_type',
                    'policy_no',
                    'proposer_name',
                    'email',
                    'mobile',
                    'start_date',
                    'end_date',
                    'total_sum_insured',
                    'gst_no',
                    'pan_no',
                    'net_premium',
                    'gross_premium',
                    'insurance_company',
                    'policy_doc',
                    'remarks',
                    'status'
                ];
                $defaults = array_merge($base_defaults, [
                    'client_combined' => 'company|Company Name',
                    'proposer_name' => 'Radhe Client',
                    'total_sum_insured' => '100000',
                    'gst_no' => '24ABCDE1234F1Z5',
                    'pan_no' => 'ABCDE1234F'
                ]);
                break;

            case 'VEHICLE':
                $columns = [
                    'insurance_type',
                    'client_combined',
                    'organisation_name',
                    'business_type',
                    'customer_type',
                    'policy_no',
                    'email',
                    'mobile',
                    'start_date',
                    'end_date',
                    'subproduct_id',
                    'segment_id',
                    'vehicle_no',
                    'mfg_company',
                    'model_name',
                    'mfg_year',
                    'idv',
                    'net_premium',
                    'gross_premium',
                    'insurance_company',
                    'policy_doc',
                    'remarks',
                    'status'
                ];
                $defaults = array_merge($base_defaults, [
                    'client_combined' => 'company|Company Name',
                    'organisation_name' => 'Radhe Industries',
                    'subproduct_id' => 'Sub Product Name',
                    'segment_id' => 'Segment Name',
                    'vehicle_no' => 'GJ05AB1234',
                    'mfg_company' => 'Tata',
                    'model_name' => 'Nexon',
                    'mfg_year' => '2023',
                    'idv' => '450000'
                ]);
                break;

            case 'LIFE':
                $columns = [
                    'insurance_type',
                    'client_combined',
                    'organisation_name',
                    'business_type',
                    'customer_type',
                    'policy_no',
                    'email',
                    'mobile',
                    'start_date',
                    'issue_date',
                    'end_date',
                    'subproduct_id',
                    'plan_name',
                    'dob',
                    'premium_term',
                    'payment_term',
                    'payment_mode',
                    'net_premium',
                    'gross_premium',
                    'insurance_company',
                    'policy_doc',
                    'remarks',
                    'status'
                ];
                $defaults = array_merge($base_defaults, [
                    'client_combined' => 'company|Company Name',
                    'organisation_name' => 'Radhe Industries',
                    'issue_date' => date('Y-m-d'),
                    'subproduct_id' => 'Sub Product Name',
                    'plan_name' => 'Life Secure',
                    'dob' => '1990-01-01',
                    'premium_term' => '10',
                    'payment_term' => '10',
                    'payment_mode' => 'Yearly'
                ]);
                break;

            case 'ECP':
            default:
                $columns = [
                    'insurance_type',
                    'company_only',
                    'business_type',
                    'customer_type',
                    'policy_no',
                    'email',
                    'mobile',
                    'start_date',
                    'end_date',
                    'medical_cover',
                    'gst_no',
                    'pan_no',
                    'net_premium',
                    'gross_premium',
                    'insurance_company',
                    'policy_doc',
                    'remarks',
                    'status'
                ];
                $defaults = array_merge($base_defaults, [
                    'company_only' => 'Company Name',
                    'medical_cover' => 'Medical Cover Name',
                    'gst_no' => '24ABCDE1234F1Z5',
                    'pan_no' => 'ABCDE1234F'
                ]);
                break;
        }

        return [$columns, $defaults];
    }
}

if (!function_exists('getInsuranceSampleFieldLabel')) {
    function getInsuranceSampleFieldLabel($field)
    {
        $labels = [
            'insurance_type' => 'Insurance Type',
            'client_combined' => 'Company / Consumer',
            'company_only' => 'Company',
            'business_type' => 'Business Type',
            'customer_type' => 'Customer Type',
            'policy_no' => 'Policy Number',
            'proposer_name' => 'Proposer Name',
            'email' => 'Email Address',
            'mobile' => 'Mobile Number',
            'start_date' => 'Policy Start Date',
            'end_date' => 'Policy End Date',
            'plan_name' => 'Plan Name',
            'medical_cover' => 'Medical Cover',
            'total_sum_insured' => 'Total Sum Insured',
            'gst_no' => 'GST Number',
            'pan_no' => 'PAN Number',
            'net_premium' => 'Net Premium',
            'gross_premium' => 'Gross Premium (inc. 18% GST)',
            'insurance_company' => 'Insurance Company',
            'policy_doc' => 'Policy Document',
            'remarks' => 'Remarks',
            'status' => 'Status',
            'organisation_name' => 'Organisation / Policy Holder Name',
            'subproduct_id' => 'Sub product',
            'segment_id' => 'Segment',
            'vehicle_no' => 'Vehicle Number',
            'mfg_company' => 'Manufacturer Company Name',
            'model_name' => 'Model Name',
            'mfg_year' => 'Manufacturer Year',
            'idv' => 'IDV',
            'issue_date' => 'Issue Date',
            'dob' => 'DOB',
            'premium_term' => 'Premium Terms',
            'payment_term' => 'Premium Payment Terms',
            'payment_mode' => 'Payment Mode'
        ];
        return $labels[$field] ?? ucwords(str_replace('_', ' ', $field));
    }
}

// --- HANDLE EXCEL EXPORT ---
if (isset($_GET['action']) && $_GET['action'] == 'export_excel') {
    if (!$ai_core->aiCheckPermission('insurance', 'view')) {
        $_SESSION['error'] = "You do not have permission to export insurance records.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';

    $where = " WHERE 1=1";
    $search = $_REQUEST['search'] ?? '';
    if (!empty($search)) {
        $where .= " AND (t.policy_no LIKE '%$search%' OR t.email LIKE '%$search%' OR t.mobile LIKE '%$search%' OR t.gst_no LIKE '%$search%' OR c.name LIKE '%$search%' OR cons.name LIKE '%$search%')";
    }

    if (!empty($_REQUEST['insurance_type'])) {
        $where .= " AND t.insurance_type LIKE '" . addslashes($_REQUEST['insurance_type']) . "'";
    }
    if (!empty($_REQUEST['business_type'])) {
        $where .= " AND t.business_type LIKE '" . addslashes($_REQUEST['business_type']) . "'";
    }
    if (!empty($_REQUEST['customer_type'])) {
        $where .= " AND t.customer_type LIKE '" . addslashes($_REQUEST['customer_type']) . "'";
    }
    if (!empty($_REQUEST['medical_cover'])) {
        $where .= " AND t.medical_cover = '" . intval($_REQUEST['medical_cover']) . "'";
    }
    if (!empty($_REQUEST['insurance_company'])) {
        $where .= " AND t.insurance_company = '" . intval($_REQUEST['insurance_company']) . "'";
    }
    if (!empty($_REQUEST['policy_status'])) {
        $ps = $_REQUEST['policy_status'];
        if ($ps === 'Running') {
            $where .= " AND CURDATE() BETWEEN t.start_date AND t.end_date";
        } elseif ($ps === 'Close') {
            $where .= " AND CURDATE() > t.end_date";
        } elseif ($ps === 'Pending') {
            $where .= " AND CURDATE() < t.start_date";
        }
    }

    $f_start = $_REQUEST['start_date'] ?? ($_REQUEST['from_date'] ?? '');
    $f_end = $_REQUEST['end_date'] ?? ($_REQUEST['to_date'] ?? '');
    if (!empty($f_start)) {
        $where .= " AND t.start_date >= '" . addslashes($f_start) . "'";
    }
    if (!empty($f_end)) {
        $where .= " AND t.start_date <= '" . addslashes($f_end) . "'";
    }

    $sql = "SELECT t.*, 
                   CONCAT(IFNULL(c.name, ''), IF(c.name IS NOT NULL AND cons.name IS NOT NULL, ' / ', ''), IFNULL(cons.name, '')) as client_name,
                   mc.name as mc_name, ic.name as ic_name 
            FROM $table t 
            LEFT JOIN tbl_vendors_companies c ON t.company_id = c.id
            LEFT JOIN tbl_vendors_consumers cons ON t.consumer_id = cons.id
            LEFT JOIN tbl_medical_covers mc ON t.medical_cover = mc.id
            LEFT JOIN tbl_insurance_companies ic ON t.insurance_company = ic.id
            $where ORDER BY t.id DESC";
    $policies = $ai_db->aiGetQueryObj($sql);
    if (!is_array($policies)) {
        $policies = [];
    }

    $columns = [
        'Sr No',
        'Insurance Type',
        'Vendor / Client Name',
        'Email Address',
        'Mobile Number',
        'GST Number',
        'Business Type',
        'Customer Type',
        'Policy Number',
        'Start Date',
        'End Date',
        'Insurance Company',
        'Medical Cover',
        'Gross Premium',
        'Status'
    ];

    $rows = [];
    $sr = 1;
    $today = date('Y-m-d');
    foreach ($policies as $row) {
        $start_d = (!empty($row->start_date) && $row->start_date != '0000-00-00') ? date('d-m-Y', strtotime($row->start_date)) : '';
        $end_d = (!empty($row->end_date) && $row->end_date != '0000-00-00') ? date('d-m-Y', strtotime($row->end_date)) : '';

        $ps_label = '—';
        if (!empty($row->start_date) && !empty($row->end_date)) {
            if ($today < $row->start_date) {
                $ps_label = 'Pending';
            } elseif ($today >= $row->start_date && $today <= $row->end_date) {
                $ps_label = 'Running';
            } else {
                $ps_label = 'Close';
            }
        }

        $rows[] = [
            $sr++,
            strtoupper($row->insurance_type ?? ''),
            $row->client_name ?: '—',
            $row->email ?: '',
            $row->mobile ?: '',
            $row->gst_no ?: '',
            $row->business_type ?: '',
            $row->customer_type ?: '',
            $row->policy_no ?: '',
            $start_d,
            $end_d,
            $row->ic_name ?? ($row->insurance_company ?: ''),
            $row->mc_name ?: '',
            $row->gross_premium ?? '0',
            $ps_label
        ];
    }

    $export_filename = 'Insurance_Policies_' . date('Ymd_His') . '.xlsx';
    download_sample_xlsx($export_filename, $columns, $rows);
    exit;
}

// --- HANDLE SAMPLE DOWNLOAD ---
if (isset($_GET['action']) && $_GET['action'] == 'download_sample') {
    if (!$ai_core->aiCheckPermission('insurance', 'add')) {
        $_SESSION['error'] = "You do not have permission to download sample.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    $sample_type_input = strtoupper(trim((string) ($_GET['sample_type'] ?? 'ECP')));
    $allowed_sample_types = ['ECP', 'LIFE', 'FIRE', 'VEHICLE', 'HEALTH'];
    $sample_type = in_array($sample_type_input, $allowed_sample_types, true) ? $sample_type_input : 'ECP';
    $sample_format = strtolower(trim((string) ($_GET['format'] ?? 'csv')));
    [$sample_columns, $sample_defaults] = getInsuranceSampleConfig($sample_type);
    $sample_headers = array_map('getInsuranceSampleFieldLabel', $sample_columns);
    $sample_row = [];
    foreach ($sample_columns as $col) {
        $sample_row[] = $sample_defaults[$col] ?? '';
    }

    if ($sample_format === 'xlsx') {
        require_once 'includes/xlsx_helper.php';
        download_sample_xlsx('sample_insurance_' . strtolower($sample_type) . '_import.xlsx', $sample_headers, [$sample_row]);
    }

    $filename = 'sample_insurance_' . strtolower($sample_type) . '_import.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Pragma: no-cache');
    header('Expires: 0');
    echo "\xEF\xBB\xBF"; // UTF-8 BOM for Excel compatibility
    $out = fopen('php://output', 'w');
    fputcsv($out, $sample_headers);
    fputcsv($out, $sample_row);
    fclose($out);
    exit;
}

include 'includes/header.php';
include 'includes/sidebar.php';


// --- HANDLE POST ACTIONS ---
if (isset($_POST['btn_submit'])) {
    $insurance_type = addslashes($_POST['insurance_type']);

    if (in_array($insurance_type, ['health', 'fire', 'vehicle', 'life'])) {
        $client_val = explode('|', $_POST['client_combined']);
        $company_type = $client_val[0] ?? 'company';
        $company_id = ($company_type == 'company') ? intval($client_val[1] ?? 0) : 0;
        $consumer_id = ($company_type == 'consumer') ? intval($client_val[1] ?? 0) : 0;
    } else {
        $company_id = intval($_POST['company_only'] ?? 0);
        $consumer_id = intval($_POST['consumer_id'] ?? 0);
        $company_type = 'company';
    }

    $business_type = addslashes($_POST['business_type']);
    $customer_type = addslashes($_POST['customer_type']);
    $subproduct_id = intval($_POST['subproduct_id'] ?? 0);
    $segment_id = intval($_POST['segment_id'] ?? 0);
    $proposer_name = addslashes($_POST['proposer_name']);
    $plan_name = addslashes($_POST['plan_name']);
    $policy_no = addslashes($_POST['policy_no']);
    $email = addslashes($_POST['email']);
    $mobile = addslashes($_POST['mobile']);
    $start_date = normalizeInsuranceDateValue($_POST['start_date'] ?? '', '');
    $end_date = normalizeInsuranceDateValue($_POST['end_date'] ?? '', '');

    // Life specific
    $issue_date = normalizeInsuranceDateValue($_POST['issue_date'] ?? '', '');
    $dob = normalizeInsuranceDateValue($_POST['dob'] ?? '', '');
    $premium_term = addslashes($_POST['premium_term'] ?? '');
    $payment_term = addslashes($_POST['payment_term'] ?? '');
    $payment_mode = addslashes($_POST['payment_mode'] ?? '');

    $medical_cover = addslashes($_POST['medical_cover']);
    $total_sum_insured = floatval($_POST['total_sum_insured'] ?? 0);

    $organisation_name = addslashes($_POST['organisation_name'] ?? '');
    $vehicle_name = addslashes($_POST['vehicle_name'] ?? '');
    $vehicle_no = addslashes($_POST['vehicle_no'] ?? '');
    $mfg_company = addslashes($_POST['mfg_company'] ?? '');
    $model_name = addslashes($_POST['model_name'] ?? '');
    $mfg_year = addslashes($_POST['mfg_year'] ?? '');
    $idv = floatval($_POST['idv'] ?? 0);

    $gst_no = addslashes($_POST['gst_no']);
    $pan_no = addslashes($_POST['pan_no']);
    $net_premium = floatval($_POST['net_premium']);
    $gst_amount = floatval($_POST['gst_amount']);
    $gross_premium = floatval($_POST['gross_premium']);
    $insurance_company = addslashes($_POST['insurance_company']);
    $remarks = addslashes($_POST['remarks']);
    $status = $_POST['status'] ?? 'active';

    // Handle Document Upload
    $old_doc = $_POST['old_doc'] ?? '';
    if (!empty($_FILES['policy_doc']['name'])) {
        $policy_doc = $ai_core->aiUpload($_FILES['policy_doc'], $docUrl, 'policy', $old_doc);
    } else {
        $policy_doc = $old_doc;
    }

    $set_sql = "insurance_type='$insurance_type', 
                company_type='$company_type', 
                company_id='$company_id', 
                consumer_id='$consumer_id',
                business_type='$business_type', 
                customer_type='$customer_type', 
                subproduct_id='$subproduct_id',
                segment_id='$segment_id',
                proposer_name='$proposer_name',
                plan_name='$plan_name',
                organisation_name='$organisation_name',
                issue_date='$issue_date',
                dob='$dob',
                premium_term='$premium_term',
                payment_term='$payment_term',
                payment_mode='$payment_mode',
                vehicle_name='$vehicle_name',
                vehicle_no='$vehicle_no',
                mfg_company='$mfg_company',
                model_name='$model_name',
                mfg_year='$mfg_year',
                idv='$idv',
                policy_no='$policy_no', 
                email='$email', 
                mobile='$mobile', 
                start_date='$start_date', 
                end_date='$end_date', 
                medical_cover='$medical_cover', 
                total_sum_insured='$total_sum_insured',
                gst_no='$gst_no', 
                pan_no='$pan_no', 
                net_premium='$net_premium', 
                gst_amount='$gst_amount', 
                gross_premium='$gross_premium', 
                insurance_company='$insurance_company', 
                policy_doc='$policy_doc', 
                remarks='$remarks', 
                status='$status'";

    if ($mode === "add") {
        $sql = "INSERT INTO $table SET $set_sql";
        $msg = 1;
    } else {
        $sql = "UPDATE $table SET $set_sql WHERE id='$id'";
        $msg = 2;
    }

    $ai_db->aiQuery($sql);
    $ai_core->aiGoPage($redirection_url . "?msg=$msg");
}

// --- HANDLE DELETE ---
if ($mode === "delete" && $id) {
    $result = $ai_db->aiGetQueryObj("SELECT policy_doc FROM $table WHERE id='$id' LIMIT 1");
    if (!empty($result[0]->policy_doc)) {
        @unlink($docUrl . $result[0]->policy_doc);
    }
    $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=3");
}

// --- FETCH LIST DATA WITH FILTERS ---
$list_data = [];
$total_records = 0;
$total_pages = 0;
$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

if ($mode === 'list') {
    if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
        ob_start();
    }

    $where = " WHERE 1=1";
    $search = $_REQUEST['search'] ?? '';
    if (!empty($search)) {
        $where .= " AND (t.policy_no LIKE '%$search%' OR t.email LIKE '%$search%' OR t.mobile LIKE '%$search%' OR t.gst_no LIKE '%$search%' OR c.name LIKE '%$search%' OR cons.name LIKE '%$search%')";
    }

    if (!empty($_REQUEST['insurance_type'])) {
        $where .= " AND t.insurance_type LIKE '" . addslashes($_REQUEST['insurance_type']) . "'";
    }
    if (!empty($_REQUEST['business_type'])) {
        $where .= " AND t.business_type LIKE '" . addslashes($_REQUEST['business_type']) . "'";
    }
    if (!empty($_REQUEST['customer_type'])) {
        $where .= " AND t.customer_type LIKE '" . addslashes($_REQUEST['customer_type']) . "'";
    }
    if (!empty($_REQUEST['medical_cover'])) {
        $where .= " AND t.medical_cover = '" . intval($_REQUEST['medical_cover']) . "'";
    }
    if (!empty($_REQUEST['insurance_company'])) {
        $where .= " AND t.insurance_company = '" . intval($_REQUEST['insurance_company']) . "'";
    }
    if (!empty($_REQUEST['policy_status'])) {
        $where .= " AND t.status LIKE '" . addslashes($_REQUEST['policy_status']) . "'";
    }

    // Date Range Filter
    if (!empty($_REQUEST['start_date'])) {
        $where .= " AND t.policy_start_date >= '" . $_REQUEST['start_date'] . "'";
    }
    if (!empty($_REQUEST['end_date'])) {
        $where .= " AND t.policy_start_date <= '" . $_REQUEST['end_date'] . "'";
    }

    if (!empty($_REQUEST['policy_status'])) {
        $ps = $_REQUEST['policy_status'];
        if ($ps === 'Running') {
            $where .= " AND CURDATE() BETWEEN t.start_date AND t.end_date";
        } elseif ($ps === 'Close') {
            $where .= " AND CURDATE() > t.end_date";
        } elseif ($ps === 'Pending') {
            $where .= " AND CURDATE() < t.start_date";
        }
    }

    // Count total records for pagination
    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table t 
            LEFT JOIN tbl_vendors_companies c ON t.company_id = c.id
            LEFT JOIN tbl_vendors_consumers cons ON t.consumer_id = cons.id $where");
    $total_records = $total_res[0]->total;
    $total_pages = ceil($total_records / $limit);

    $sql = "SELECT t.*, 
                   CONCAT(IFNULL(c.name, ''), IF(c.name IS NOT NULL AND cons.name IS NOT NULL, ' / ', ''), IFNULL(cons.name, '')) as client_name,
                   mc.name as mc_name, ic.name as ic_name 
            FROM $table t 
            LEFT JOIN tbl_vendors_companies c ON t.company_id = c.id
            LEFT JOIN tbl_vendors_consumers cons ON t.consumer_id = cons.id
            LEFT JOIN tbl_medical_covers mc ON t.medical_cover = mc.id
            LEFT JOIN tbl_insurance_companies ic ON t.insurance_company = ic.id
            $where ORDER BY t.id DESC LIMIT $limit OFFSET $offset";
    $list_data = $ai_db->aiGetQueryObj($sql);

    // --- AJAX RESPONSE HANDLER ---
    if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
        ob_start();
        ?>
        <table class="table table-hover align-middle mb-0" style="font-size:12.2px;">
            <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                <tr>
                    <th class="ps-4 py-3 text-muted fw-bold" style="width:40px;">Sr</th>
                    <th class="py-3 text-muted fw-bold">Insurance Type</th>
                    <th class="py-3 text-muted fw-bold">Vendor Detail</th>
                    <th class="py-3 text-muted fw-bold">Type Details</th>
                    <th class="py-3 text-muted fw-bold">Policy Detail</th>
                    <th class="py-3 text-muted fw-bold">Insurance/Medical</th>
                    <th class="py-3 text-muted fw-bold">Gross Premium</th>
                    <th class="py-3 text-muted fw-bold">Status</th>
                    <th class="py-3 text-muted fw-bold">Document</th>
                    <th class="py-3 text-muted fw-bold text-end pe-4">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($list_data)): ?>
                    <tr>
                        <td colspan="10" class="text-center py-5 text-muted">
                            <i class="ti ti-file-off fs-40 mb-2 d-block"></i>
                            No policies found.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php
                    $type_colors = [
                        'life' => ['bg' => '#e8f5e9', 'color' => '#2e7d32', 'label' => 'Life'],
                        'health' => ['bg' => '#e3f2fd', 'color' => '#1565c0', 'label' => 'Health'],
                        'vehicle' => ['bg' => '#fff3e0', 'color' => '#e65100', 'label' => 'Vehicle'],
                        'fire' => ['bg' => '#fce4ec', 'color' => '#c62828', 'label' => 'Fire'],
                        'ecp' => ['bg' => '#f3e5f5', 'color' => '#6a1b9a', 'label' => 'ECP'],
                    ];
                    $sr_no = ($page - 1) * $limit + 1;
                    $today = date('Y-m-d');
                    foreach ($list_data as $row):
                        $t = strtolower($row->insurance_type ?? '');
                        $tc = $type_colors[$t] ?? ['bg' => '#f5f5f5', 'color' => '#555', 'label' => ucfirst($t)];

                        $ps_label = '—';
                        $ps_class = 'bg-light text-muted';
                        if (!empty($row->start_date) && !empty($row->end_date)) {
                            if ($today < $row->start_date) {
                                $ps_label = 'Pending';
                                $ps_class = 'bg-soft-info text-info';
                            } elseif ($today >= $row->start_date && $today <= $row->end_date) {
                                $ps_label = 'Running';
                                $ps_class = 'bg-soft-success text-success';
                            } else {
                                $ps_label = 'Close';
                                $ps_class = 'bg-soft-danger text-danger';
                            }
                        }
                        ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?php echo $sr_no++; ?></td>
                            <td>
                                <span
                                    style="display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; background:<?php echo $tc['bg']; ?>; color:<?php echo $tc['color']; ?>; text-transform:uppercase;">
                                    <?php echo $tc['label']; ?>
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($row->client_name ?: '—'); ?></div>
                                <div class="text-muted small"><i
                                        class="ti ti-mail me-1"></i><?php echo htmlspecialchars($row->email ?: '—'); ?></div>
                                <div class="text-muted small"><i
                                        class="ti ti-phone me-1"></i><?php echo htmlspecialchars($row->mobile ?: '—'); ?></div>
                                <?php if ($row->gst_no): ?>
                                    <div class="text-muted small"><i class="ti ti-id me-1"></i>GST:
                                        <?php echo htmlspecialchars($row->gst_no); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($row->business_type ?: '—'); ?></div>
                                <div class="text-muted small"><?php echo htmlspecialchars($row->customer_type ?: '—'); ?></div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-1">#<?php echo htmlspecialchars($row->policy_no ?: '—'); ?></div>
                                <div class="text-success small"><i
                                        class="ti ti-calendar-event me-1"></i><?php echo !empty($row->start_date) ? date('d M Y', strtotime($row->start_date)) : '—'; ?>
                                </div>
                                <div class="text-danger small"><i
                                        class="ti ti-calendar-x me-1"></i><?php echo !empty($row->end_date) ? date('d M Y', strtotime($row->end_date)) : '—'; ?>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-1">
                                    <?php echo htmlspecialchars($row->ic_name ?? ($row->insurance_company ?: '—')); ?>
                                </div>
                                <?php if ($row->mc_name): ?>
                                    <div class="badge bg-soft-primary text-primary border-0 fw-normal" style="font-size:10px;">
                                        <?php echo htmlspecialchars($row->mc_name); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="fw-bold text-dark"
                                    style="font-size:14px;">₹<?php echo number_format($row->gross_premium, 2); ?></span>
                            </td>
                            <td>
                                <span class="badge rounded-pill <?php echo $ps_class; ?> px-3 py-2 fw-bold"
                                    style="font-size:10px; letter-spacing:0.5px;">
                                    <?php echo strtoupper($ps_label); ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($row->policy_doc)): ?>
                                    <a href="<?php echo $docUrl . $row->policy_doc; ?>" target="_blank"
                                        class="btn btn-soft-primary btn-sm rounded-circle shadow-none" title="View Document">
                                        <i class="ti ti-file-text fs-18"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="ti ti-dots-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <?php if ($ai_core->aiCheckPermission('insurance', 'edit')): ?>
                                        <a class="dropdown-item py-2"
                                            href="<?php echo $redirection_url; ?>?mode=edit&id=<?php echo $row->id; ?>">
                                            <i class="ti ti-edit me-2 text-info"></i>Edit
                                        </a>
                                        <?php endif; ?>
                                        <?php if ($ai_core->aiCheckPermission('insurance', 'delete')): ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item py-2 text-danger"
                                            href="<?php echo $redirection_url; ?>?mode=delete&id=<?php echo $row->id; ?>"
                                            onclick="return confirm('Delete this policy?')">
                                            <i class="ti ti-trash me-2"></i>Delete
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if ($total_pages > 1): ?>
            <div class="card-footer border-top-0 p-3">
                <nav>
                    <ul class="pagination pagination-sm justify-content-end mb-0">
                        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link ajax-page" href="#" data-page="<?php echo $page - 1; ?>">Previous</a>
                        </li>
                        <?php
                        if ($total_pages <= 10) {
                            for ($i = 1; $i <= $total_pages; $i++) {
                                $active = ($i == $page) ? 'active' : '';
                                echo "<li class='page-item $active'><a class='page-link ajax-page' href='#' data-page='$i'>$i</a></li>";
                            }
                        } else {
                            if ($page < 4) {
                                for ($i = 1; $i <= 4; $i++) {
                                    $active = ($i == $page) ? 'active' : '';
                                    echo "<li class='page-item $active'><a class='page-link ajax-page' href='#' data-page='$i'>$i</a></li>";
                                }
                                echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                echo "<li class='page-item'><a class='page-link ajax-page' href='#' data-page='$total_pages'>$total_pages</a></li>";
                            } elseif ($page >= 4 && $page < $total_pages - 3) {
                                echo "<li class='page-item'><a class='page-link ajax-page' href='#' data-page='1'>1</a></li>";
                                echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                for ($i = $page; $i <= $page + 3; $i++) {
                                    $active = ($i == $page) ? 'active' : '';
                                    echo "<li class='page-item $active'><a class='page-link ajax-page' href='#' data-page='$i'>$i</a></li>";
                                }
                                echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                echo "<li class='page-item'><a class='page-link ajax-page' href='#' data-page='$total_pages'>$total_pages</a></li>";
                            } else {
                                echo "<li class='page-item'><a class='page-link ajax-page' href='#' data-page='1'>1</a></li>";
                                echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                for ($i = $total_pages - 4; $i <= $total_pages; $i++) {
                                    $active = ($i == $page) ? 'active' : '';
                                    echo "<li class='page-item $active'><a class='page-link ajax-page' href='#' data-page='$i'>$i</a></li>";
                                }
                            }
                        }
                        ?>
                        <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link ajax-page" href="#" data-page="<?php echo $page + 1; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
        <?php
        $html = ob_get_clean();
        echo json_encode(['html' => $html]);
        exit;
    }
}

// --- FETCH DATA FOR EDIT ---
if (($mode === "edit") && $id && !isset($_POST['btn_submit'])) {
    $result = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1");
    $data = $result[0] ?? null;
}

// Fetch Masters
$companies = $ai_db->aiGetQueryObj("SELECT id, name, company_name, owner_name, email, phone, gst_no, pan_number FROM tbl_vendors_companies WHERE status='active' ORDER BY name ASC");
$consumers = $ai_db->aiGetQueryObj("SELECT id, name, email, phone FROM tbl_vendors_consumers WHERE status='active' ORDER BY name ASC");
$medical_covers = $ai_db->aiGetQueryObj("SELECT id, name, insurance_type FROM tbl_medical_covers WHERE status='active' ORDER BY name ASC");
$insurance_companies_master = $ai_db->aiGetQueryObj("SELECT id, name FROM tbl_insurance_companies WHERE status='active' ORDER BY name ASC");
$subproducts = $ai_db->aiGetQueryObj("SELECT id, name FROM tbl_subproducts WHERE status='active' ORDER BY name ASC");
$segments = $ai_db->aiGetQueryObj("SELECT id, name FROM tbl_segments WHERE status='active' ORDER BY name ASC");
?>

<div class="page-wrapper">
    <div class="content">

        <?php if ($mode == 'list'): ?>
            <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">
                        <?php echo $page_nm; ?>
                    </h3>
                </div>
                <div class="mb-2 d-flex gap-2">
                    <button class="btn btn-soft-secondary d-flex align-items-center shadow-sm" type="button"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false">
                        <i class="ti ti-filter me-2"></i>Filter
                    </button>
                    <a href="javascript:void(0)" onclick="exportInsuranceData()" class="btn btn-soft-success d-flex align-items-center px-3 shadow-sm" title="Export to Excel" style="text-transform: capitalize !important; font-weight: 600;">
                        <i class="ti ti-file-spreadsheet me-2"></i>Export
                    </a>
                    <?php if ($ai_core->aiCheckPermission('insurance', 'add')): ?>
                        <button class="btn btn-soft-primary d-flex align-items-center shadow-sm" type="button"
                            data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="ti ti-file-import me-2"></i>Import
                        </button>
                        <a href="<?php echo $redirection_url; ?>?mode=add" class="btn btn-primary shadow-sm"><i
                                class="ti ti-plus me-2"></i>Add New Policy</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Filters Section (Collapsible) -->
            <div class="collapse mb-4" id="filterCollapse">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form id="ajaxFilterForm" method="POST" action="javascript:void(0);" class="row g-3">
                            <input type="hidden" name="mode" value="list">
                            <input type="hidden" name="page" id="currentPage" value="1">

                            <div class="col-md-2">
                                <label class="form-label small fw-bold">Insurance Type</label>
                                <select name="insurance_type" class="form-select select2-no-search filter-input">
                                    <option value="">All Types</option>
                                    <option value="ECP">ECP</option>
                                    <option value="HEALTH">Health</option>
                                    <option value="FIRE">Fire</option>
                                    <option value="VEHICLE">Vehicle</option>
                                    <option value="LIFE">Life</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Vendor Detail</label>
                                <input type="text" name="search" class="form-control filter-input"
                                    placeholder="Name, Email, Mobile, GST...">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-bold">Business Type</label>
                                <select name="business_type" class="form-select select2-no-search filter-input">
                                    <option value="">All Business</option>
                                    <option value="Fresh/New">Fresh/New</option>
                                    <option value="Renewal/Rollover">Renewal/Rollover</option>
                                    <option value="Endorsement">Endorsement</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-bold">Customer Type</label>
                                <select name="customer_type" class="form-select select2-no-search filter-input">
                                    <option value="">All Customers</option>
                                    <option value="Organisation">Organisation</option>
                                    <option value="Individual">Individual</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Policy Start Date Range</label>
                                <div class="input-group">
                                    <input type="date" name="from_date" class="form-control filter-input">
                                    <span class="input-group-text bg-light border-start-0 border-end-0">to</span>
                                    <input type="date" name="to_date" class="form-control filter-input">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Medical Cover</label>
                                <select name="medical_cover" class="form-select select2 filter-input">
                                    <option value="">All Covers</option>
                                    <?php foreach ($medical_covers as $mc): ?>
                                        <option value="<?php echo $mc->id; ?>"><?php echo $mc->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Insurance Co.</label>
                                <select name="insurance_company" class="form-select select2 filter-input">
                                    <option value="">All Companies</option>
                                    <?php foreach ($insurance_companies_master as $ic): ?>
                                        <option value="<?php echo $ic->id; ?>"><?php echo $ic->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-bold">Policy Status</label>
                                <select name="policy_status" class="form-select select2-no-search filter-input">
                                    <option value="">All Status</option>
                                    <option value="Running">Running</option>
                                    <option value="Close">Close</option>
                                    <option value="Pending">Pending</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label d-block">&nbsp;</label>
                                <button type="submit" id="btnFilterSubmit" class="btn btn-filter-standard w-100">
                                    <i class="ti ti-search me-1"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label d-block">&nbsp;</label>
                                <button type="button" id="resetFilters" class="btn btn-premium-reset w-100">
                                    <i class="ti ti-refresh"></i> Reset Filters
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" id="ajaxTableContainer">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size:12.2px;">
                            <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                                <tr>
                                    <th class="ps-4 py-3 text-muted fw-bold" style="width:40px;">Sr</th>
                                    <th class="py-3 text-muted fw-bold">Insurance Type</th>
                                    <th class="py-3 text-muted fw-bold">Vendor Detail</th>
                                    <th class="py-3 text-muted fw-bold">Type Details</th>
                                    <th class="py-3 text-muted fw-bold">Policy Detail</th>
                                    <th class="py-3 text-muted fw-bold">Insurance/Medical</th>
                                    <th class="py-3 text-muted fw-bold">Gross Premium</th>
                                    <th class="py-3 text-muted fw-bold">Status</th>
                                    <th class="py-3 text-muted fw-bold">Document</th>
                                    <th class="py-3 text-muted fw-bold text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($list_data)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-5 text-muted">
                                            <i class="ti ti-file-off fs-40 mb-2 d-block"></i>
                                            No <?php echo $page_nm; ?> policies found.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php
                                    $type_colors = [
                                        'life' => ['bg' => '#e8f5e9', 'color' => '#2e7d32', 'label' => 'Life'],
                                        'health' => ['bg' => '#e3f2fd', 'color' => '#1565c0', 'label' => 'Health'],
                                        'vehicle' => ['bg' => '#fff3e0', 'color' => '#e65100', 'label' => 'Vehicle'],
                                        'fire' => ['bg' => '#fce4ec', 'color' => '#c62828', 'label' => 'Fire'],
                                        'ecp' => ['bg' => '#f3e5f5', 'color' => '#6a1b9a', 'label' => 'ECP'],
                                    ];
                                    ?>
                                    <?php
                                    $sr_no = ($page - 1) * $limit + 1;
                                    foreach ($list_data as $row):
                                        ?>
                                        <?php
                                        $t = strtolower($row->insurance_type ?? '');
                                        $tc = $type_colors[$t] ?? ['bg' => '#f5f5f5', 'color' => '#555', 'label' => ucfirst($t)];
                                        $today = date('Y-m-d');

                                        $ps_label = '—';
                                        $ps_class = 'bg-light text-muted';
                                        if (!empty($row->start_date) && !empty($row->end_date)) {
                                            if ($today < $row->start_date) {
                                                $ps_label = 'Pending';
                                                $ps_class = 'bg-soft-info text-info';
                                            } elseif ($today >= $row->start_date && $today <= $row->end_date) {
                                                $ps_label = 'Running';
                                                $ps_class = 'bg-soft-success text-success';
                                            } else {
                                                $ps_label = 'Close';
                                                $ps_class = 'bg-soft-danger text-danger';
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td class="ps-4 text-muted small"><?php echo $sr_no++; ?></td>
                                            <td>
                                                <span
                                                    style="display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; background:<?php echo $tc['bg']; ?>; color:<?php echo $tc['color']; ?>; text-transform:uppercase;">
                                                    <?php echo $tc['label']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark mb-1">
                                                    <?php echo htmlspecialchars($row->client_name ?: '—'); ?>
                                                </div>
                                                <div class="text-muted small"><i
                                                        class="ti ti-mail me-1"></i><?php echo htmlspecialchars($row->email ?: '—'); ?>
                                                </div>
                                                <div class="text-muted small"><i
                                                        class="ti ti-phone me-1"></i><?php echo htmlspecialchars($row->mobile ?: '—'); ?>
                                                </div>
                                                <?php if ($row->gst_no): ?>
                                                    <div class="text-muted small"><i class="ti ti-id me-1"></i>GST:
                                                        <?php echo htmlspecialchars($row->gst_no); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark mb-1">
                                                    <?php echo htmlspecialchars($row->business_type ?: '—'); ?>
                                                </div>
                                                <div class="text-muted small">
                                                    <?php echo htmlspecialchars($row->customer_type ?: '—'); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark mb-1">
                                                    #<?php echo htmlspecialchars($row->policy_no ?: '—'); ?></div>
                                                <div class="text-success small"><i
                                                        class="ti ti-calendar-event me-1"></i><?php echo !empty($row->start_date) ? date('d M Y', strtotime($row->start_date)) : '—'; ?>
                                                </div>
                                                <div class="text-danger small"><i
                                                        class="ti ti-calendar-x me-1"></i><?php echo !empty($row->end_date) ? date('d M Y', strtotime($row->end_date)) : '—'; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark mb-1">
                                                    <?php echo htmlspecialchars($row->ic_name ?? ($row->insurance_company ?: '—')); ?>
                                                </div>
                                                <?php if ($row->mc_name): ?>
                                                    <div class="badge bg-soft-primary text-primary border-0 fw-normal"
                                                        style="font-size:10px;"><?php echo htmlspecialchars($row->mc_name); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-dark"
                                                    style="font-size:14px;">₹<?php echo number_format($row->gross_premium, 2); ?></span>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill <?php echo $ps_class; ?> px-3 py-2 fw-bold"
                                                    style="font-size:10px; letter-spacing:0.5px;">
                                                    <?php echo strtoupper($ps_label); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (!empty($row->policy_doc)): ?>
                                                    <a href="<?php echo $docUrl . $row->policy_doc; ?>" target="_blank"
                                                        class="btn btn-soft-primary btn-sm rounded-circle shadow-none"
                                                        title="View Document">
                                                        <i class="ti ti-file-text fs-18"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                                        aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                                        <?php if ($ai_core->aiCheckPermission('insurance', 'edit')): ?>
                                                        <a class="dropdown-item py-2"
                                                            href="<?php echo $redirection_url; ?>?mode=edit&id=<?php echo $row->id; ?>">
                                                            <i class="ti ti-edit me-2 text-info"></i>Edit
                                                        </a>
                                                        <?php endif; ?>
                                                        <?php if ($ai_core->aiCheckPermission('insurance', 'delete')): ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item py-2 text-danger"
                                                            href="<?php echo $redirection_url; ?>?mode=delete&id=<?php echo $row->id; ?>"
                                                            onclick="return confirm('Delete this policy?')">
                                                            <i class="ti ti-trash me-2"></i>Delete
                                                        </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($total_pages > 1): ?>
                    <div class="card-footer border-top-0 p-3">
                        <nav>
                            <ul class="pagination pagination-sm justify-content-end mb-0">
                                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                        href="?mode=list&page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>">Previous</a>
                                </li>
                                <?php
                                if ($total_pages <= 10) {
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        $active = ($i == $page) ? 'active' : '';
                                        echo "<li class='page-item $active'><a class='page-link' href='?mode=list&page=$i&search=$search'>$i</a></li>";
                                    }
                                } else {
                                    if ($page < 4) {
                                        for ($i = 1; $i <= 4; $i++) {
                                            $active = ($i == $page) ? 'active' : '';
                                            echo "<li class='page-item $active'><a class='page-link' href='?mode=list&page=$i&search=$search'>$i</a></li>";
                                        }
                                        echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                        echo "<li class='page-item'><a class='page-link' href='?mode=list&page=$total_pages&search=$search'>$total_pages</a></li>";
                                    } elseif ($page >= 4 && $page < $total_pages - 3) {
                                        echo "<li class='page-item'><a class='page-link' href='?mode=list&page=1&search=$search'>1</a></li>";
                                        echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                        for ($i = $page; $i <= $page + 3; $i++) {
                                            $active = ($i == $page) ? 'active' : '';
                                            echo "<li class='page-item $active'><a class='page-link' href='?mode=list&page=$i&search=$search'>$i</a></li>";
                                        }
                                        echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                        echo "<li class='page-item'><a class='page-link' href='?mode=list&page=$total_pages&search=$search'>$total_pages</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a class='page-link' href='?mode=list&page=1&search=$search'>1</a></li>";
                                        echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                        for ($i = $total_pages - 4; $i <= $total_pages; $i++) {
                                            $active = ($i == $page) ? 'active' : '';
                                            echo "<li class='page-item $active'><a class='page-link' href='?mode=list&page=$i&search=$search'>$i</a></li>";
                                        }
                                    }
                                }
                                ?>
                                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                        href="?mode=list&page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif ($mode == 'add' || $mode == 'edit'): ?>
            <div class="form-header-bar">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="insurance.php">Insurance</a></li>
                        <li class="breadcrumb-item active"><?php echo $mode == 'add' ? 'Add Policy' : 'Edit Policy'; ?>
                        </li>
                    </ol>
                </nav>
                <a href="insurance.php" class="btn-back-standard">
                    <i class="ti ti-chevrons-left"></i> Back
                </a>
            </div>

            <form action="insurance.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="old_doc" value="<?php echo $data->policy_doc ?? ''; ?>">

                <div class="form-card-standard">
                    <div class="row g-4">
                        <!-- Insurance Details -->
                        <div class="col-md-3">
                            <label class="form-label">Insurance Type <span class="text-danger">*</span></label>
                            <?php if ($mode === 'edit'): ?>
                                <?php $current_type = strtolower($data->insurance_type ?? ''); ?>
                                <!-- Disabled in edit mode so user cannot change type -->
                                <select id="insurance_type" class="form-select select2-no-search" disabled>
                                    <option value="ecp" <?php echo $current_type == 'ecp' ? 'selected' : ''; ?>>ECP</option>
                                    <option value="health" <?php echo $current_type == 'health' ? 'selected' : ''; ?>>Health
                                    </option>
                                    <option value="fire" <?php echo $current_type == 'fire' ? 'selected' : ''; ?>>Fire
                                    </option>
                                    <option value="vehicle" <?php echo $current_type == 'vehicle' ? 'selected' : ''; ?>>
                                        Vehicle</option>
                                    <option value="life" <?php echo $current_type == 'life' ? 'selected' : ''; ?>>Life
                                    </option>
                                </select>
                                <!-- Hidden input sends value to DB since disabled selects are not submitted -->
                                <input type="hidden" name="insurance_type"
                                    value="<?php echo htmlspecialchars($current_type); ?>">
                            <?php else: ?>
                                <select name="insurance_type" id="insurance_type" class="form-select select2-no-search"
                                    required>
                                    <option value="">Select Type</option>
                                    <option value="ecp">ECP</option>
                                    <option value="health">Health</option>
                                    <option value="fire">Fire</option>
                                    <option value="vehicle">Vehicle</option>
                                    <option value="life">Life</option>
                                </select>
                            <?php endif; ?>
                            <div class="invalid-feedback">Please select insurance type.</div>
                        </div>
                        <div class="col-md-3 fld-client-combined">
                            <label class="form-label">Company / Consumer <span class="text-danger">*</span></label>
                            <select name="client_combined" id="client_combined" class="form-select select2">
                                <option value="">Select Option</option>
                                <optgroup label="Companies">
                                    <?php foreach ($companies as $c): ?>
                                        <option value="company|<?php echo $c->id; ?>"
                                            data-proposer="<?php echo htmlspecialchars($c->owner_name ?: $c->name); ?>"
                                            data-organisation="<?php echo htmlspecialchars($c->company_name ?: $c->name); ?>"
                                            data-email="<?php echo htmlspecialchars($c->email ?? ''); ?>"
                                            data-mobile="<?php echo htmlspecialchars($c->phone ?? ''); ?>"
                                            data-gst="<?php echo htmlspecialchars($c->gst_no ?? ''); ?>"
                                            data-pan="<?php echo htmlspecialchars($c->pan_number ?? ''); ?>"
                                            <?php echo ($data && $data->company_id == $c->id && $data->company_type == 'company') ? 'selected' : ''; ?>>
                                            <?php echo $c->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="Consumers">
                                    <?php foreach ($consumers as $c): ?>
                                        <option value="consumer|<?php echo $c->id; ?>"
                                            data-proposer="<?php echo htmlspecialchars($c->name ?? ''); ?>"
                                            data-organisation="<?php echo htmlspecialchars($c->name ?? ''); ?>"
                                            data-email="<?php echo htmlspecialchars($c->email ?? ''); ?>"
                                            data-mobile="<?php echo htmlspecialchars($c->phone ?? ''); ?>"
                                            data-gst=""
                                            data-pan=""
                                            <?php echo ($data && $data->consumer_id == $c->id && $data->company_type == 'consumer') ? 'selected' : ''; ?>>
                                            <?php echo $c->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                            <div class="invalid-feedback">Please select a company or consumer.</div>
                        </div>

                        <div class="col-md-3 fld-company-only">
                            <label class="form-label">Company <span class="text-danger">*</span></label>
                            <select name="company_only" id="company_only" class="form-select select2">
                                <option value="">Select Company</option>
                                <?php foreach ($companies as $c): ?>
                                    <option value="<?php echo $c->id; ?>"
                                        data-proposer="<?php echo htmlspecialchars($c->owner_name ?: $c->name); ?>"
                                        data-organisation="<?php echo htmlspecialchars($c->company_name ?: $c->name); ?>"
                                        data-email="<?php echo htmlspecialchars($c->email ?? ''); ?>"
                                        data-mobile="<?php echo htmlspecialchars($c->phone ?? ''); ?>"
                                        data-gst="<?php echo htmlspecialchars($c->gst_no ?? ''); ?>"
                                        data-pan="<?php echo htmlspecialchars($c->pan_number ?? ''); ?>"
                                        <?php echo ($data && $data->company_id == $c->id) ? 'selected' : ''; ?>>
                                        <?php echo $c->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a company.</div>
                        </div>

                        <div class="col-md-3 fld-consumer-secondary">
                            <label class="form-label">Consumer</label>
                            <select name="consumer_id" id="consumer_id" class="form-select select2">
                                <option value="">Select Consumer</option>
                                <?php foreach ($consumers as $c): ?>
                                    <option value="<?php echo $c->id; ?>"
                                        data-proposer="<?php echo htmlspecialchars($c->name ?? ''); ?>"
                                        data-organisation="<?php echo htmlspecialchars($c->name ?? ''); ?>"
                                        data-email="<?php echo htmlspecialchars($c->email ?? ''); ?>"
                                        data-mobile="<?php echo htmlspecialchars($c->phone ?? ''); ?>"
                                        data-gst=""
                                        data-pan=""
                                        <?php echo ($data && $data->consumer_id == $c->id) ? 'selected' : ''; ?>>
                                        <?php echo $c->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="col-md-3 fld-organisation">
                            <label class="form-label">Organisation / Policy Holder Name</label>
                            <input type="text" name="organisation_name" class="form-control"
                                value="<?php echo $data->organisation_name ?? ''; ?>" placeholder="Enter Name">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Business Type <span class="text-danger">*</span></label>
                            <select name="business_type" class="form-select select2-no-search" required>
                                <option value="">Select Business Type</option>
                                <option value="Fresh/New" <?php echo ($data && $data->business_type == 'Fresh/New') ? 'selected' : ''; ?>>Fresh/New</option>
                                <option value="Renewal/Rollover" <?php echo ($data && $data->business_type == 'Renewal/Rollover') ? 'selected' : ''; ?>>Renewal/Rollover
                                </option>
                                <option value="Endorsement" <?php echo ($data && $data->business_type == 'Endorsement') ? 'selected' : ''; ?>>Endorsement</option>
                            </select>
                            <div class="invalid-feedback">Please select business type.</div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Customer Type <span class="text-danger">*</span></label>
                            <select name="customer_type" class="form-select select2-no-search" required>
                                <option value="">Select Customer Type</option>
                                <option value="Individual" <?php echo ($data && $data->customer_type == 'Individual') ? 'selected' : ''; ?>>Individual</option>
                                <option value="Organisation" <?php echo ($data && $data->customer_type == 'Organisation') ? 'selected' : ''; ?>>Organisation</option>
                            </select>
                            <div class="invalid-feedback">Please select customer type.</div>
                        </div>


                        <div class="col-md-3">
                            <label class="form-label">Policy Number</label>
                            <input type="text" name="policy_no" class="form-control"
                                value="<?php echo $data->policy_no ?? ''; ?>" placeholder="Policy Number">
                        </div>

                        <div class="col-md-3 fld-proposer">
                            <label class="form-label">Proposer Name</label>
                            <input type="text" name="proposer_name" class="form-control"
                                value="<?php echo $data->proposer_name ?? ''; ?>" placeholder="Enter Proposer Name">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $data->email ?? ''; ?>"
                                placeholder="client@example.com">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" maxlength="10" minlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                value="<?php echo $data->mobile ?? ''; ?>" placeholder="10 Digit Mobile">
                        </div>




                        <div class="col-md-3">
                            <label class="form-label"> Policy Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" id="policy_start_date" class="form-control"
                                value="<?php echo insuranceDateForInput($data->start_date ?? ''); ?>" required>
                            <div class="invalid-feedback">Policy start date is required.</div>
                        </div>

                        <div class="col-md-3 fld-life-details">
                            <label class="form-label">Issue Date</label>
                            <input type="date" name="issue_date" class="form-control"
                                value="<?php echo insuranceDateForInput($data->issue_date ?? ''); ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Policy End Date <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" id="policy_end_date" class="form-control"
                                value="<?php echo insuranceDateForInput($data->end_date ?? ''); ?>" required>
                            <div class="invalid-feedback">Policy end date is required.</div>
                        </div>

                        <div class="col-md-3 fld-subproduct">
                            <label class="form-label">Sub product</label>
                            <select name="subproduct_id" class="form-select select2">
                                <option value="">Select Subproduct</option>
                                <?php foreach ($subproducts as $sp): ?>
                                    <option value="<?php echo $sp->id; ?>" <?php echo ($data && $data->subproduct_id == $sp->id) ? 'selected' : ''; ?>>
                                        <?php echo $sp->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3 fld-segment">
                            <label class="form-label">Segment</label>
                            <select name="segment_id" class="form-select select2">
                                <option value="">Select Segment</option>
                                <?php foreach ($segments as $s): ?>
                                    <option value="<?php echo $s->id; ?>" <?php echo ($data && $data->segment_id == $s->id) ? 'selected' : ''; ?>>
                                        <?php echo $s->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <!-- 
                        <div class="col-md-3 fld-vehicle-details">
                            <label class="form-label">Vehicle Name</label>
                            <input type="text" name="vehicle_name" class="form-control"
                                value="<?php echo $data->vehicle_name ?? ''; ?>" placeholder="Enter Vehicle Name">
                        </div> -->

                        <div class="col-md-3 fld-vehicle-details">
                            <label class="form-label">Vehicle Number</label>
                            <input type="text" name="vehicle_no" class="form-control"
                                value="<?php echo $data->vehicle_no ?? ''; ?>" placeholder="Enter Vehicle Number">
                        </div>

                        <div class="col-md-3 fld-plan">
                            <label class="form-label">Plan Name</label>
                            <input type="text" name="plan_name" class="form-control"
                                value="<?php echo $data->plan_name ?? ''; ?>" placeholder="Enter Plan Name">
                        </div>






                        <div class="col-md-3 fld-life-details">
                            <label class="form-label">DOB</label>
                            <input type="date" name="dob" class="form-control"
                                value="<?php echo insuranceDateForInput($data->dob ?? ''); ?>">
                        </div>

                        <div class="col-md-3 fld-life-details">
                            <label class="form-label">Premium Terms</label>
                            <input type="text" name="premium_term" class="form-control"
                                value="<?php echo $data->premium_term ?? ''; ?>" placeholder="Premium Terms">
                        </div>

                        <div class="col-md-3 fld-life-details">
                            <label class="form-label">Premium Payment Terms</label>
                            <input type="text" name="payment_term" class="form-control"
                                value="<?php echo $data->payment_term ?? ''; ?>" placeholder="Payment Terms">
                        </div>

                        <div class="col-md-3 fld-life-details">
                            <label class="form-label">Payment Mode</label>
                            <select name="payment_mode" class="form-select select2-no-search">
                                <option value="">Select Mode</option>
                                <option value="Monthly" <?php echo ($data && $data->payment_mode == 'Monthly') ? 'selected' : ''; ?>>Monthly</option>
                                <option value="Quarterly" <?php echo ($data && $data->payment_mode == 'Quarterly') ? 'selected' : ''; ?>>Quarterly (every 3 months)</option>
                                <option value="Half Yearly" <?php echo ($data && $data->payment_mode == 'Half Yearly') ? 'selected' : ''; ?>>Half Yearly (every 6 months)</option>
                                <option value="Yearly" <?php echo ($data && $data->payment_mode == 'Yearly') ? 'selected' : ''; ?>>Yearly</option>
                            </select>
                        </div>

                        <div class="col-md-3 fld-vehicle-details">
                            <label class="form-label">Manufacturer Company Name</label>
                            <input type="text" name="mfg_company" class="form-control"
                                value="<?php echo $data->mfg_company ?? ''; ?>" placeholder="Manufacturer Company">
                        </div>

                        <div class="col-md-3 fld-vehicle-details">
                            <label class="form-label">Model Name</label>
                            <input type="text" name="model_name" class="form-control"
                                value="<?php echo $data->model_name ?? ''; ?>" placeholder="Model Name">
                        </div>

                        <div class="col-md-3 fld-vehicle-details">
                            <label class="form-label">Manufacturer Year</label>
                            <input type="text" name="mfg_year" class="form-control"
                                value="<?php echo $data->mfg_year ?? ''; ?>" placeholder="Year">
                        </div>

                        <div class="col-md-3 fld-vehicle-details">
                            <label class="form-label">IDV</label>
                            <input type="number" step="0.01" name="idv" class="form-control"
                                value="<?php echo $data->idv ?? '0'; ?>" placeholder="IDV">
                        </div>

                        <div class="col-md-3 fld-medical-cover">
                            <label class="form-label">Medical Cover</label>
                            <select name="medical_cover" id="medical_cover" class="form-select select2">
                                <option value="">Select Medical Cover</option>
                                <?php foreach ($medical_covers as $mc): ?>
                                    <option value="<?php echo $mc->id; ?>" data-type="<?php echo $mc->insurance_type; ?>" <?php echo ($data && $data->medical_cover == $mc->id) ? 'selected' : ''; ?>>
                                        <?php echo $mc->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3 fld-sum-insured">
                            <label class="form-label">Total Sum Insured</label>
                            <input type="number" step="0.01" name="total_sum_insured" class="form-control"
                                value="<?php echo $data->total_sum_insured ?? '0'; ?>" placeholder="Total Sum Insured">
                        </div>


                        <div class="col-md-3 fld-gst">
                            <label class="form-label">GST Number</label>
                            <input type="text" id="gst_no" name="gst_no" class="form-control" maxlength="15" minlength="15"
                                oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, ''); if(this.value.length >= 12) { document.getElementById('pan_no').value = this.value.substring(2, 12); }"
                                value="<?php echo $data->gst_no ?? ''; ?>" placeholder="15 Digit GSTIN">
                        </div>
                        <div class="col-md-3 fld-pan">
                            <label class="form-label">PAN Number</label>
                            <input type="text" id="pan_no" name="pan_no" class="form-control" maxlength="10"
                                oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');"
                                value="<?php echo $data->pan_no ?? ''; ?>" placeholder="10 Digit PAN">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Net Premium</label>
                            <input type="number" step="0.01" id="net_premium" name="net_premium" class="form-control"
                                value="<?php echo $data->net_premium ?? '0'; ?>" oninput="calculatePremium()">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Gross Premium (inc. 18% GST)</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" step="0.01" id="gross_premium" name="gross_premium"
                                    class="form-control bg-light" value="<?php echo $data->gross_premium ?? '0'; ?>"
                                    readonly>
                                <input type="hidden" id="gst_amount" name="gst_amount"
                                    value="<?php echo $data->gst_amount ?? '0'; ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Insurance Company</label>
                            <select name="insurance_company" class="form-select select2">
                                <option value="">Select Insurance Company</option>
                                <?php foreach ($insurance_companies_master as $ic): ?>
                                    <option value="<?php echo $ic->id; ?>" <?php echo ($data && $data->insurance_company == $ic->id) ? 'selected' : ''; ?>>
                                        <?php echo $ic->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Policy Document</label>
                            <div class="input-group">
                                <input type="file" name="policy_doc" class="form-control">
                                <?php if ($data && $data->policy_doc): ?>
                                    <a href="<?php echo $docUrl . $data->policy_doc; ?>" target="_blank"
                                        class="input-group-text bg-soft-info text-info"><i class="ti ti-eye me-1"></i>View</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Remarks</label>
                            <input type="text" name="remarks" class="form-control"
                                value="<?php echo $data->remarks ?? ''; ?>" placeholder="Additional notes">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select select2-no-search">
                                <option value="active" <?php echo ($data && $data->status == 'active') ? 'selected' : ''; ?>>
                                    Active</option>
                                <option value="inactive" <?php echo ($data && $data->status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-action-btns">
                        <button type="submit" name="btn_submit" class="btn-submit-standard">
                            <i class="ti ti-device-floppy me-1"></i> Submit
                        </button>
                        <a href="insurance.php" class="btn-cancel-standard">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>

        <?php endif; ?>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-soft-success py-3">
                <h5 class="modal-title d-flex align-items-center text-success">
                    <i class="ti ti-file-import me-2 fs-20"></i>Import <?php echo $page_nm; ?> from CSV
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo $redirection_url; ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Insurance Type</label>
                        <select name="import_insurance_type" id="import_insurance_type"
                            class="form-select select2-no-search">
                            <option value="ECP">ECP</option>
                            <option value="LIFE">LIFE</option>
                            <option value="FIRE">FIRE</option>
                            <option value="VEHICLE">VEHICLE</option>
                            <option value="HEALTH">HEALTH</option>
                        </select>
                        <div class="form-text mt-1 small text-muted">
                            <i class="ti ti-info-circle me-1"></i>Sample file and default import type will follow this
                            selection.
                        </div>
                    </div>
                    <div class="mb-4 text-center">
                        <div class="bg-light p-3 rounded-3 mb-3 border-dashed">
                            <i class="ti ti-download fs-32 text-muted mb-2"></i>
                            <p class="mb-2 small">First, download the template to ensure correct format.</p>
                            <a href="<?php echo $redirection_url; ?>?action=download_sample&sample_type=ECP&format=csv"
                                id="downloadSampleLink" class="btn btn-sm btn-white border">
                                <i class="ti ti-download me-1"></i>Download Sample CSV
                            </a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Excel File (CSV)</label>
                        <input type="file" name="import_file" class="form-control" accept=".csv" required>
                        <div class="form-text mt-2 small text-muted">
                            <i class="ti ti-info-circle me-1"></i>Make sure columns match the sample file.
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-white border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="btn_import" class="btn btn-success px-4">
                        <i class="ti ti-check me-1"></i>Start Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-soft-success {
        background-color: rgba(40, 199, 111, 0.1);
    }

    .text-success {
        color: #28c76f !important;
    }

    .border-dashed {
        border: 2px dashed #dee2e6 !important;
    }
</style>


</div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
    (function () {
        const typeSelect = document.getElementById('import_insurance_type');
        const sampleLink = document.getElementById('downloadSampleLink');
        if (!typeSelect || !sampleLink) return;

        const updateSampleLink = () => {
            const selectedType = typeSelect.value || 'ECP';
            sampleLink.href = '<?php echo $redirection_url; ?>?action=download_sample&format=csv&sample_type=' + encodeURIComponent(selectedType);
        };

        typeSelect.addEventListener('change', updateSampleLink);
        if (window.jQuery) {
            window.jQuery(typeSelect).on('select2:select change', updateSampleLink);
        }
        updateSampleLink();
    })();
</script>

<?php if ($mode == 'add' || $mode == 'edit'): ?>
    <script>
        // jQuery is now fully loaded (footer.php loads it)
        function toggleFields() {
            var type = $('#insurance_type').val();

            // Hide all conditional fields first
            $('.fld-proposer, .fld-plan, .fld-sum-insured, .fld-vehicle-details, .fld-subproduct, .fld-segment, .fld-life-details, .fld-organisation').hide();

            // Default visible
            $('.fld-gst, .fld-pan, .fld-medical-cover').show();

            // Hide all client selectors first and reset required attributes
            $('.fld-client-combined, .fld-company-only, .fld-consumer-secondary').hide();
            $('#client_combined, #company_only').attr('required', false);

            if (type === 'health') {
                $('.fld-proposer, .fld-plan').show();
                $('.fld-gst, .fld-pan').hide();
                $('.fld-client-combined').show();
                $('#client_combined').attr('required', true);
            } else if (type === 'fire') {
                $('.fld-proposer, .fld-sum-insured').show();
                $('.fld-medical-cover').hide();
                $('.fld-client-combined').show();
                $('#client_combined').attr('required', true);
            } else if (type === 'vehicle') {
                $('.fld-vehicle-details, .fld-subproduct, .fld-segment, .fld-organisation').show();
                $('.fld-medical-cover, .fld-gst, .fld-pan').hide();
                $('.fld-client-combined').show();
                $('#client_combined').attr('required', true);
            } else if (type === 'life') {
                $('.fld-plan, .fld-organisation, .fld-life-details, .fld-subproduct').show();
                $('.fld-medical-cover, .fld-gst, .fld-pan').hide();
                $('.fld-client-combined').show();
                $('#client_combined').attr('required', true);
            } else if (type === 'ecp') {
                $('.fld-company-only').show();
                $('#company_only').attr('required', true);
            } else {
                $('.fld-company-only, .fld-consumer-secondary').show();
                $('#company_only').attr('required', false);
            }

            // Filter Medical Cover options by insurance type
            try {
                var $mc = $('#medical_cover');
                if (!$mc.data('all-options')) {
                    // Store all original options on first run
                    $mc.data('all-options', $mc.find('option').clone());
                }

                var allOptions = $mc.data('all-options');
                var selectedVal = $mc.val();

                // Clear current options
                $mc.empty().append('<option value="">Select Medical Cover</option>');

                // Filter and re-add
                allOptions.each(function () {
                    var $opt = $(this);
                    var optType = $opt.data('type');
                    if ($opt.val() === "") return; // Skip empty

                    if (!optType || optType === type) {
                        $mc.append($opt.clone());
                    }
                });

                // Re-select value if it still exists
                $mc.val(selectedVal);

                if ($mc.hasClass('select2-hidden-accessible')) {
                    $mc.select2('destroy').select2({ width: '100%', allowClear: true, placeholder: 'Select Medical Cover' });
                }
            } catch (e) { console.error('Medical cover filter error:', e); }

            // Fix Select2 width=0 on newly visible elements
            setTimeout(function () { $(window).trigger('resize'); }, 50);
        }

        function calculatePremium() {
            var net = parseFloat(document.getElementById('net_premium').value) || 0;
            var gst = net * 0.18;
            var gross = net + gst;
            document.getElementById('gst_amount').value = gst.toFixed(2);
            document.getElementById('gross_premium').value = gross.toFixed(2);
        }

        function clearClientDetails() {
            // Clear auto-filled fields when insurance type / client changes
            var fields = ['proposer_name', 'organisation_name', 'email', 'mobile', 'gst_no', 'pan_no'];
            fields.forEach(function (name) {
                var $field = $('[name="' + name + '"]');
                if (!$field.length) return;
                $field.val('').trigger('input');
            });
        }

        function resetClientSelectors() {
            // Clear all client selectors (Select2-safe)
            ['#client_combined', '#company_only', '#consumer_id'].forEach(function (sel) {
                var $el = $(sel);
                if (!$el.length) return;
                $el.val('').trigger('change');
            });
        }

        function fillClientDetailsFromOption(option) {
            if (!option) return;

            var $option = $(option);
            var map = {
                proposer_name: $option.data('proposer') || '',
                organisation_name: $option.data('organisation') || '',
                email: $option.data('email') || '',
                mobile: $option.data('mobile') || '',
                gst_no: $option.data('gst') || '',
                pan_no: $option.data('pan') || ''
            };

            Object.keys(map).forEach(function (name) {
                var $field = $('[name="' + name + '"]');
                if (!$field.length) return;

                // Set even empty values so previous auto-filled values get cleared
                $field.val(map[name]).trigger('input');
            });
        }

        function fillClientDetails(selectId) {
            var select = document.getElementById(selectId);
            if (!select) return;

            fillClientDetailsFromOption(select.options[select.selectedIndex]);
        }

        $(document).ready(function () {
            // footer.php already initializes $('select').select2() globally
            toggleFields();

            $('#insurance_type').on('change', function () {
                // When insurance type changes, dependent client/company selection and auto-filled fields
                // must be cleared so old values don't remain.
                resetClientSelectors();
                clearClientDetails();
                toggleFields();
            });

            $('#client_combined').on('change select2:select', function () {
                fillClientDetails('client_combined');
            });

            $('#company_only').on('change select2:select', function () {
                fillClientDetails('company_only');
            });

            $('#consumer_id').on('change select2:select', function () {
                fillClientDetails('consumer_id');
            });

            // Date validation: End Date cannot be before Start Date
            $('#policy_start_date').on('change', function () {
                var startDate = $(this).val();
                $('#policy_end_date').attr('min', startDate);
                if ($('#policy_end_date').val() && $('#policy_end_date').val() < startDate) {
                    $('#policy_end_date').val('');
                }
            });

            if ($('#policy_start_date').val()) {
                $('#policy_end_date').attr('min', $('#policy_start_date').val());
            }

            // Bootstrap 5 form validation
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>
<?php endif; ?>

<?php if ($mode == 'list'): ?>
    <script>
        function exportInsuranceData() {
            var filterData = $('#ajaxFilterForm').serialize();
            window.location.href = 'insurance.php?action=export_excel&' + filterData;
        }

        $(document).ready(function () {
            // --- AJAX FILTERING LOGIC ---
            function loadListData() {
                var formData = $('#ajaxFilterForm').serialize();
                formData += '&ajax=1';

                $('#ajaxTableContainer').css('opacity', '0.5');

                $.ajax({
                    url: 'insurance.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        $('#ajaxTableContainer').html(response.html).css('opacity', '1');
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        $('#ajaxTableContainer').css('opacity', '1');
                    }
                });
            }

            // Centralized Filter Trigger
            $('#ajaxFilterForm').on('submit', function (e) {
                e.preventDefault();
                $('#currentPage').val(1);
                loadListData();
            });

            // Trigger submit on button click
            $('#btnFilterSubmit').on('click', function (e) {
                e.preventDefault();
                $('#ajaxFilterForm').submit();
            });

            // Handle Enter key in inputs
            $('#ajaxFilterForm input').on('keypress', function (e) {
                if (e.which == 13) {
                    e.preventDefault();
                    $('#ajaxFilterForm').submit();
                }
            });

            $(document).on('click', '.ajax-page', function (e) {
                e.preventDefault();
                var page = $(this).data('page');
                $('#currentPage').val(page);
                loadListData();
            });

            $('#resetFilters').on('click', function (e) {
                e.preventDefault();
                $('#ajaxFilterForm')[0].reset();
                $('.filter-input').val('').trigger('change');
                $('#currentPage').val(1);
                loadListData();
            });

            // Initial Load
            loadListData();
        });
    </script>
<?php endif; ?>
