<?php
include 'root/config.php';
require_once 'root/ai_core/class.mailer.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$hash = $_GET['hash'] ?? '';

if ($id && $hash === md5($id . "radhe_secret")) {
    $table = "tbl_factory_quotations";

    // Check if already approved
    $check = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1");
    if (!$check) {
        die("Invalid Quotation ID.");
    }

    $data = $check[0];

    // --- AUTOMATIC VENDOR ENTRY (Ensures entry exists even for previously approved quotes) ---
    $v_table = "tbl_vendors_companies";
    $v_email = addslashes($data->email);
    $v_phone = addslashes($data->phone);

    // Check if company already exists (matching both name and email for better test flexibility)
    $v_name = addslashes($data->company_name);
    $v_office_branch = addslashes($data->office_branch ?? 'Rajkot');
    $check_vendor = $ai_db->aiGetQueryObj("SELECT id, office_branch FROM $v_table WHERE company_name='$v_name' AND email='$v_email' LIMIT 1");

    if (empty($check_vendor)) {
        // Generate Company Code
        $last_v = $ai_db->aiGetQueryObj("SELECT MAX(id) as max_id FROM $v_table");
        $v_next_id = ($last_v[0]->max_id ?? 0) + 1;
        $v_code = "COMP" . str_pad($v_next_id, 3, '0', STR_PAD_LEFT);

        $v_company_name = addslashes($data->company_name);
        $v_owner_name = addslashes($data->owner_name);
        $v_owner_address = addslashes($data->owner_address);
        $v_address = addslashes($data->address);

        $v_sql = "INSERT INTO $v_table SET 
                  company_code='$v_code', 
                  company_name='$v_company_name', 
                  name='$v_company_name', 
                  owner_name='$v_owner_name', 
                  owner_address='$v_owner_address', 
                  address='$v_address', 
                  phone='$v_phone', 
                  email='$v_email', 
                  office_branch='$v_office_branch', 
                  status='active'";
        $ai_db->aiQuery($v_sql);
    } else {
        // If company already exists but office_branch is empty or was not set, update it from quotation
        $existing_comp = $check_vendor[0];
        if (empty($existing_comp->office_branch) && !empty($v_office_branch)) {
            $exist_id = $existing_comp->id;
            $ai_db->aiQuery("UPDATE $v_table SET office_branch='$v_office_branch' WHERE id='$exist_id'");
        }
    }

    if ($data->client_approval_status === 'Approved by Client') {
        $msg = "This quotation has already been approved. Thank you!";
    } else {
        // Update Status
        $ai_db->aiQuery("UPDATE $table SET client_approval_status='Approved by Client', mail_status='send' WHERE id='$id'");

        // Notify Radhe Advisory
        $mailer = new RadheMailer();
        $config = include 'root/config_smtp.php';

        $subject = "Quotation Approved by Client: " . $data->company_name;
        $message = "
            <div style='font-family: Arial, sans-serif; padding: 20px;'>
                <h3>Quotation Approved</h3>
                <p><strong>Company:</strong> " . $data->company_name . "</p>
                <p><strong>Quotation ID:</strong> #" . $id . "</p>
                <p><strong>Status:</strong> Approved by Client</p>
                <p>Please proceed with the Plan Maker details sharing.</p>
            </div>
        ";
        $mailer->sendMail($config['from_email'], $subject, $message);

        $msg = "Quotation Approved Successfully! Our team will contact you soon.";
    }
} else {
    die("Invalid request.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Approved | Radhe Advisory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 20px;
        }

        .main-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 60px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            max-width: 550px;
            width: 100%;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon-container {
            width: 100px;
            height: 100px;
            background: #10b981;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            margin: 0 auto 30px;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
            animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }

        h1 {
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 15px;
            font-size: 32px;
        }

        p {
            color: #64748b;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .branding {
            border-top: 1px solid #e2e8f0;
            padding-top: 30px;
        }

        .firm-name {
            font-weight: 700;
            color: #0056b3;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .firm-tagline {
            color: #94a3b8;
            font-size: 12px;
            margin-top: 5px;
        }

        .btn-home {
            background: #0f172a;
            color: white;
            border: none;
            padding: 15px 35px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-home:hover {
            background: #1e293b;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="main-card">
        <div class="icon-container">✓</div>
        <h1>Submission Successful</h1>
        <p><?php echo $msg; ?></p>
        <div class="branding">
            <div class="firm-name">Radhe Advisory </div>
            <div class="firm-tagline">Strategic Industrial Compliance Partners</div>
        </div>
    </div>
</body>

</html>