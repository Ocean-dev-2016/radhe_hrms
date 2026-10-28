<?php
include 'root/config.php';
$ai_core->aiCheckLogin();

// Check Permissions
if (!$ai_core->aiCheckPermission('bulk_email', 'view')) {
    $_SESSION['error'] = "You do not have permission to access Bulk Email.";
    $ai_core->aiGoPage("dashboard.php");
}

$page_nm = "Bulk Email";
$redirection_url = "bulk_email.php";

// Fetch active companies with email
$companies = $ai_db->aiGetQueryObj("SELECT id, company_name, email FROM tbl_vendors_companies WHERE status='active' AND email IS NOT NULL AND TRIM(email) != '' ORDER BY company_name ASC");
if (empty($companies)) {
    $companies = [];
}

//$companies = array("company_name" => "Arti", "email" => "arti.ocean1997@gmail.com", "id" => "355");

// Handle Form Submission
if (isset($_POST['send_bulk_mail'])) {
    $company_ids = $_POST['company_id'] ?? [];
    if (!is_array($company_ids)) {
        $company_ids = !empty($company_ids) ? [$company_ids] : [];
    }
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    $recipients = [];

    if (in_array('all', $company_ids)) {
        foreach ($companies as $comp) {
            $comp_emails = array_filter(array_map('trim', preg_split('/[,;\s]+/', $comp->email)));
            foreach ($comp_emails as $em) {
                if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
                    $recipients[] = $em;
                }
            }
        }
    } else {
        foreach ($company_ids as $cid_val) {
            $cid = intval($cid_val);
            if ($cid > 0) {
                $single_comp = $ai_db->aiGetQueryObj("SELECT company_name, email FROM tbl_vendors_companies WHERE id='$cid' LIMIT 1");
                if (!empty($single_comp) && !empty($single_comp[0]->email)) {
                    $comp_emails = array_filter(array_map('trim', preg_split('/[,;\s]+/', $single_comp[0]->email)));
                    foreach ($comp_emails as $em) {
                        if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
                            $recipients[] = $em;
                        }
                    }
                }
            }
        }
    }

    $recipients = array_values(array_unique($recipients));

    if (empty($recipients)) {
        $_SESSION['error'] = "No valid email address found for the selected company!";
        $ai_core->aiGoPage($redirection_url);
    }

    if (empty($title)) {
        $_SESSION['error'] = "Please provide an email title / subject!";
        $ai_core->aiGoPage($redirection_url);
    }

    // Handle Attachment Upload (PDF, Word, Images)
    $attachments = [];
    $uploaded_file_name = '';
    if (isset($_FILES['attachment_file']) && $_FILES['attachment_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "uploads/bulk_email/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_info = $_FILES['attachment_file'];
        $ext = strtolower(pathinfo($file_info['name'], PATHINFO_EXTENSION));
        $allowed_exts = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (!in_array($ext, $allowed_exts)) {
            $_SESSION['error'] = "Invalid file type. Only PDF, Word (.doc, .docx), and Images (JPG, PNG, WEBP) are allowed.";
            $ai_core->aiGoPage($redirection_url);
        }

        $clean_name = time() . '_' . rand(1000, 9999) . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file_info['name']);
        $destination = $upload_dir . $clean_name;

        if (move_uploaded_file($file_info['tmp_name'], $destination)) {
            $uploaded_file_name = $clean_name;
            $attachments[] = $destination;
        }
    }

    // Build email HTML body
    $email_html = "<div style='font-family: Arial, Helvetica, sans-serif; max-width: 650px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);'>
        <div style='background: linear-gradient(135deg, #1e40af, #3b82f6); padding: 24px; text-align: center; color: #ffffff;'>
            <h2 style='margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 0.5px;'>Radhe Advisory</h2>
            <p style='margin: 6px 0 0; font-size: 13px; opacity: 0.9;'>Labour Law & HR Compliance Solutions</p>
        </div>
        <div style='padding: 30px; background-color: #ffffff; color: #334155; line-height: 1.6;'>
            <h3 style='color: #0f172a; margin-top: 0; font-size: 20px; font-weight: 600; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;'>" . htmlspecialchars($title) . "</h3>
            <div style='font-size: 15px; margin-top: 15px;'>" . $description . "</div>";

    if (!empty($uploaded_file_name)) {
        $email_html .= "<div style='margin-top: 24px; padding: 12px 16px; background-color: #f1f5f9; border-radius: 8px; font-size: 13px; color: #475569;'>
            <i style='font-style: normal;'>📎 <strong>Attached Document:</strong> " . htmlspecialchars($_FILES['attachment_file']['name']) . "</i>
        </div>";
    }

    $email_html .= "</div>
        <div style='background-color: #f8fafc; padding: 18px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0;'>
            <p style='margin: 0;'>This email was sent from <strong>Radhe Advisory</strong>.</p>
        </div>
    </div>";

    // Auto-create tbl_bulk_email_logs table if not exists
    $ai_db->aiQuery("CREATE TABLE IF NOT EXISTS tbl_bulk_email_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description LONGTEXT NULL,
        attachment VARCHAR(255) NULL,
        to_email TEXT NULL,
        from_email VARCHAR(255) NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    require_once 'root/ai_core/class.mailer.php';
    $mailer = new RadheMailer();

    // Get From Email from SMTP configuration
    $smtp_conf = include 'root/config_smtp.php';
    $from_email = $smtp_conf['from_email'] ?? 'info@radheconsultancy.co.in';

    $success_count = 0;
    $fail_count = 0;

    // Send emails
    foreach ($recipients as $to_email) {
        if ($mailer->sendMail($to_email, $title, $email_html, $attachments)) {
            $success_count++;
        } else {
            $fail_count++;
        }
    }

    // Save into tbl_bulk_email_logs
    $to_email_stored = implode(',', $company_ids);
    $title_esc = addslashes($title);
    $desc_esc = addslashes($description);
    $attach_esc = addslashes($uploaded_file_name);
    $to_email_esc = addslashes($to_email_stored);
    $from_email_esc = addslashes($from_email);

    $ai_db->aiQuery("INSERT INTO tbl_bulk_email_logs 
        (title, description, attachment, to_email, from_email, created_at) 
        VALUES 
        ('$title_esc', '$desc_esc', '$attach_esc', '$to_email_esc', '$from_email_esc', NOW())");

    if ($success_count > 0) {
        $_SESSION['success'] = "Bulk Email sent successfully to {$success_count} recipient(s)!" . ($fail_count > 0 ? " ({$fail_count} failed)" : "");
    } else {
        $err = $mailer->getLastError();
        $_SESSION['error'] = "Failed to send email. " . (!empty($err) ? "Reason: " . htmlspecialchars($err) : "");
    }

    $ai_core->aiGoPage($redirection_url);
}
?>

<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<link rel="stylesheet" href="assets/plugins/quill/quill.snow.css">

<style>
/* Disable uppercase transformation for email editor and title */
.email-normal-case,
.email-normal-case input,
.email-normal-case textarea,
.email-normal-case .ql-editor,
.email-normal-case .ql-container {
    text-transform: none !important;
}

#editor-container {
    min-height: 220px;
    background: #ffffff;
    font-size: 15px;
    font-family: inherit;
}

.ql-toolbar.ql-snow {
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    background-color: #f8fafc;
    border-color: #dee2e6;
    padding: 10px 12px;
}

.ql-container.ql-snow {
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    border-color: #dee2e6;
}

/* Ensure quill select elements are hidden and custom pickers render cleanly */
.ql-snow select {
    display: none !important;
}

.ql-snow .ql-picker {
    font-size: 13px !important;
}

.ql-snow .select2-container {
    display: none !important;
}
</style>

<div class="page-wrapper">
    <div class="content">

        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto">
                <h4 class="page-title mb-1"><?php echo $page_nm; ?></h4>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $page_nm; ?></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3 p-2 bg-soft-primary rounded-3 text-primary">
                                <i class="ti ti-mail-fast fs-24"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Send Bulk Email</h5>
                                <small class="text-muted">Broadcast custom email notifications to companies</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 email-normal-case">
                        <form method="POST" action="bulk_email.php" enctype="multipart/form-data" id="bulkEmailForm">
                            <!-- Company Dropdown (Multiple Selection) -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label fw-semibold text-dark mb-0">
                                        Select Companies <span class="text-danger">*</span>
                                    </label>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none me-2" onclick="selectAllCompanies()">Select All</button>
                                        <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none text-muted" onclick="clearCompanies()">Clear</button>
                                    </div>
                                </div>
                                <select name="company_id[]" id="company_id" class="form-select select2" multiple="multiple" data-placeholder="Choose one or more companies..." required>
                                    <option value="all">-- All Companies (Broadcast to All) --</option>
                                    <?php foreach ($companies as $c): ?>
                                        <option value="<?php echo $c->id; ?>">
                                            <?php echo htmlspecialchars($c->company_name); ?> (<?php echo htmlspecialchars($c->email); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text text-muted">
                                    <i class="ti ti-info-circle me-1"></i>You can select multiple companies from the dropdown, or choose "-- All Companies --".
                                </div>
                            </div>

                            <!-- Subject / Title -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    Title / Subject <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" name="title" id="email_title" class="form-control border-start-0 email-normal-case" 
                                           placeholder="e.g. Important Compliance Notice / Renewal Reminder" required>
                                </div>
                            </div>

                            <!-- Description / Rich Text Editor -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    Description / Message Content <span class="text-danger">*</span>
                                </label>
                                
                                <!-- Quill Rich Text Editor Container -->
                                <div id="editor-container"></div>
                                
                                <!-- Hidden textarea to submit rich HTML -->
                                <textarea name="description" id="hidden_description" style="display: none;"></textarea>
                            </div>

                            <!-- Attachment Upload (PDF, Word, Images) -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    Attach Document / Image (Optional)
                                </label>
                                <div class="p-3 border rounded-3 bg-light">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 bg-soft-primary rounded-3 text-primary me-3">
                                            <i class="ti ti-paperclip fs-28"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="attachment_file" id="attachment_file" class="form-control" 
                                                   accept=".pdf, .doc, .docx, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf, image/png, image/jpeg, image/jpg, image/webp" 
                                                   onchange="previewAttachment(this)">
                                            <small class="text-muted d-block mt-1">
                                                Accepted formats: <strong>PDF</strong> (.pdf), <strong>Word</strong> (.doc, .docx), <strong>Images</strong> (.png, .jpg, .jpeg, .webp)
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <!-- Dynamic File Preview Container -->
                                    <div id="filePreviewContainer" class="mt-3 text-center d-none">
                                        <div id="imagePreviewBox" class="d-none">
                                            <img id="imagePreview" src="#" alt="Image Preview" 
                                                 style="max-height: 180px; max-width: 100%; border-radius: 8px; border: 1px solid #e2e8f0; padding: 4px;">
                                        </div>
                                        <div id="docPreviewBox" class="p-3 border rounded-3 bg-white d-inline-flex align-items-center d-none">
                                            <i id="docIcon" class="ti ti-file-text fs-32 me-2 text-danger"></i>
                                            <div class="text-start">
                                                <span id="docFileName" class="fw-bold text-dark d-block"></span>
                                                <small id="docFileSize" class="text-muted"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="send_bulk_mail" value="1">

                            <!-- Actions -->
                            <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                                <button type="reset" class="btn btn-light px-4" onclick="handleReset()">
                                    <i class="ti ti-rotate-clockwise me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary px-4 fw-semibold" id="btnSubmit">
                                    <i class="ti ti-send me-1"></i> Send Email
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bulk Email Progress Modal -->
<div class="modal fade" id="bulkProgressModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bulkProgressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 justify-content-center text-center">
                <div class="text-center w-100 pt-2">
                    <div class="avatar avatar-xl bg-soft-primary rounded-circle mx-auto mb-2 text-primary d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="ti ti-mail-fast fs-28" id="modalStatusIcon"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark" id="modalStatusTitle">Sending Emails...</h5>
                    <p class="text-muted small mb-0" id="modalStatusSubtitle">Please do not close or refresh this page.</p>
                </div>
            </div>
            <div class="modal-body p-4">
                <!-- Progress Bar -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between text-muted small fw-semibold mb-2">
                        <span id="progressStatusText">Preparing job...</span>
                        <span id="progressPercentText" class="text-primary fw-bold">0%</span>
                    </div>
                    <div class="progress" style="height: 12px; border-radius: 6px; background-color: #e2e8f0;">
                        <div id="bulkProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <!-- Stats Counters -->
                <div class="row g-2 text-center pt-2">
                    <div class="col-4">
                        <div class="p-2 border rounded-3 bg-light">
                            <small class="text-muted d-block">Total</small>
                            <span class="fw-bold fs-16 text-dark" id="statTotal">0</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 border rounded-3 bg-soft-success">
                            <small class="text-success d-block">Sent</small>
                            <span class="fw-bold fs-16 text-success" id="statSent">0</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 border rounded-3 bg-soft-danger">
                            <small class="text-danger d-block">Failed</small>
                            <span class="fw-bold fs-16 text-danger" id="statFailed">0</span>
                        </div>
                    </div>
                </div>

                <div id="modalSuccessQueueBox" class="alert alert-success py-3 px-3 small mt-3 d-none mb-0 text-start">
                    <div class="fw-bold mb-1 fs-15"><i class="ti ti-circle-check fs-18 align-middle me-1"></i> Emails Added to Queue Successfully!</div>
                    <div id="queueSuccessMsg" class="mb-2"></div>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a href="cron_bulk_email_queue.php?token=radhe_queue_secure_2026" target="_blank" class="btn btn-sm btn-primary px-3">
                            <i class="ti ti-player-play me-1"></i> Run Queue Now (Send 5 Emails)
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-secondary px-3" onclick="window.location.reload();">
                            Done & Close
                        </button>
                    </div>
                </div>
                <div id="modalErrorNotice" class="alert alert-danger py-2 px-3 small mt-3 d-none mb-0"></div>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                <button type="button" class="btn btn-secondary px-4 d-none" id="btnModalFinish" onclick="window.location.reload();">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Quill Editor JS -->
<script src="assets/plugins/quill/quill.min.js"></script>

<script>
let quill;
document.addEventListener("DOMContentLoaded", function () {
    // Initialize Quill Rich Text Editor
    quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Type your email message or announcement here...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'clean']
            ]
        }
    });

    // Handle "All Companies" option logic in select2
    $('#company_id').on('select2:select', function (e) {
        const selectedVal = e.params.data.id;
        if (selectedVal === 'all') {
            $('#company_id').val(['all']).trigger('change');
        } else {
            const currentVals = $('#company_id').val() || [];
            if (currentVals.includes('all')) {
                const filtered = currentVals.filter(v => v !== 'all');
                $('#company_id').val(filtered).trigger('change');
            }
        }
    });
});

function selectAllCompanies() {
    $('#company_id').val(['all']).trigger('change');
}

function clearCompanies() {
    $('#company_id').val(null).trigger('change');
}

function handleReset() {
    document.getElementById('filePreviewContainer').classList.add('d-none');
    document.getElementById('imagePreviewBox').classList.add('d-none');
    document.getElementById('docPreviewBox').classList.add('d-none');
    if (quill) {
        quill.setText('');
    }
    clearCompanies();
}

function previewAttachment(input) {
    const fileContainer = document.getElementById('filePreviewContainer');
    const imgBox = document.getElementById('imagePreviewBox');
    const docBox = document.getElementById('docPreviewBox');
    const imgPreview = document.getElementById('imagePreview');
    const docFileName = document.getElementById('docFileName');
    const docFileSize = document.getElementById('docFileSize');
    const docIcon = document.getElementById('docIcon');

    imgBox.classList.add('d-none');
    docBox.classList.add('d-none');
    fileContainer.classList.add('d-none');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const ext = file.name.split('.').pop().toLowerCase();
        const sizeFormatted = (file.size / 1024).toFixed(1) + ' KB';

        fileContainer.classList.remove('d-none');

        if (['jpg', 'jpeg', 'png', 'webp', 'gif'].includes(ext)) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgBox.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            // PDF or Word Document
            docFileName.textContent = file.name;
            docFileSize.textContent = sizeFormatted;

            if (ext === 'pdf') {
                docIcon.className = 'ti ti-file-type-pdf fs-36 me-3 text-danger';
            } else if (['doc', 'docx'].includes(ext)) {
                docIcon.className = 'ti ti-file-type-doc fs-36 me-3 text-primary';
            } else {
                docIcon.className = 'ti ti-file-text fs-36 me-3 text-secondary';
            }

            docBox.classList.remove('d-none');
        }
    }
}

// AJAX Batch Sender Handler
document.getElementById('bulkEmailForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const selectedCompanies = $('#company_id').val();
    if (!selectedCompanies || selectedCompanies.length === 0) {
        toastr.error('Please select at least one company.');
        return false;
    }

    const titleVal = document.getElementById('email_title').value.trim();
    if (!titleVal) {
        toastr.error('Please enter email title / subject.');
        return false;
    }

    const htmlContent = quill.root.innerHTML.trim();
    const plainText = quill.getText().trim();
    if (!plainText && htmlContent === '<p><br></p>') {
        toastr.error('Please enter description / message content.');
        return false;
    }
    document.getElementById('hidden_description').value = htmlContent;

    // Open progress modal
    const progressModal = new bootstrap.Modal(document.getElementById('bulkProgressModal'));
    
    // Reset modal state
    document.getElementById('modalStatusTitle').textContent = 'Initializing Batch Job...';
    document.getElementById('modalStatusSubtitle').textContent = 'Connecting and gathering recipients...';
    document.getElementById('modalStatusIcon').className = 'ti ti-loader fs-28 fa-spin';
    document.getElementById('progressStatusText').textContent = 'Please wait...';
    document.getElementById('progressPercentText').textContent = '0%';
    document.getElementById('bulkProgressBar').style.width = '0%';
    document.getElementById('bulkProgressBar').className = 'progress-bar progress-bar-striped progress-bar-animated bg-primary';
    document.getElementById('statTotal').textContent = '0';
    document.getElementById('statSent').textContent = '0';
    document.getElementById('statFailed').textContent = '0';
    document.getElementById('btnModalFinish').classList.add('d-none');
    document.getElementById('modalErrorNotice').classList.add('d-none');
    
    progressModal.show();

    // Prepare Form Data for step 1
    const formElement = document.getElementById('bulkEmailForm');
    const formData = new FormData(formElement);
    formData.append('action', 'prepare_bulk_email');

    // Step 1: Initialize Job
    $.ajax({
        url: 'ajax_send_bulk_email.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(initRes) {
            if (initRes.status === 'queued') {
                document.getElementById('statTotal').textContent = initRes.total;
                document.getElementById('modalStatusTitle').textContent = 'Queued for Scheduled Sending';
                document.getElementById('modalStatusSubtitle').textContent = initRes.total + ' emails queued (Daily limit: 5 emails/day)';
                document.getElementById('modalStatusIcon').className = 'ti ti-clock-check fs-28 text-success';
                document.getElementById('progressStatusText').textContent = 'Emails added into Queue';
                document.getElementById('progressPercentText').textContent = '100%';
                document.getElementById('bulkProgressBar').style.width = '100%';
                document.getElementById('bulkProgressBar').classList.remove('progress-bar-animated', 'progress-bar-striped');
                document.getElementById('bulkProgressBar').classList.add('bg-success');
                
                document.getElementById('queueSuccessMsg').innerHTML = initRes.message || 'All emails added to the queue.';
                document.getElementById('modalSuccessQueueBox').classList.remove('d-none');
                return;
            }

            if (initRes.status !== 'success') {
                document.getElementById('modalStatusTitle').textContent = 'Initialization Error';
                document.getElementById('modalStatusSubtitle').textContent = 'Failed to prepare job';
                document.getElementById('modalErrorNotice').textContent = initRes.message || 'Unknown error occurred.';
                document.getElementById('modalErrorNotice').classList.remove('d-none');
                document.getElementById('btnModalFinish').classList.remove('d-none');
                return;
            }

            const jobId = initRes.job_id;
            const totalRecipients = initRes.total;
            const batchSize = initRes.batch_size || 10;

            document.getElementById('statTotal').textContent = totalRecipients;
            document.getElementById('modalStatusTitle').textContent = 'Sending Bulk Emails...';
            document.getElementById('modalStatusSubtitle').textContent = 'Sending in batches of ' + batchSize + ' to prevent server load';
            document.getElementById('modalStatusIcon').className = 'ti ti-mail-fast fs-28';

            let currentOffset = 0;

            // Step 2: Recursive Batch Sender
            function processNextBatch() {
                const batchPercent = Math.min(100, Math.round((currentOffset / totalRecipients) * 100));
                document.getElementById('progressStatusText').textContent = 'Sending ' + (currentOffset + 1) + ' - ' + Math.min(currentOffset + batchSize, totalRecipients) + ' of ' + totalRecipients + '...';
                
                $.ajax({
                    url: 'ajax_send_bulk_email.php',
                    type: 'POST',
                    data: {
                        action: 'send_bulk_batch',
                        job_id: jobId,
                        batch_offset: currentOffset,
                        batch_size: batchSize
                    },
                    dataType: 'json',
                    success: function(batchRes) {
                        if (batchRes.status === 'error') {
                            document.getElementById('modalErrorNotice').textContent = batchRes.message || 'Error occurred during sending.';
                            document.getElementById('modalErrorNotice').classList.remove('d-none');
                            document.getElementById('btnModalFinish').classList.remove('d-none');
                            return;
                        }

                        currentOffset = batchRes.processed;
                        const pct = batchRes.percentage;
                        
                        document.getElementById('progressPercentText').textContent = pct + '%';
                        document.getElementById('bulkProgressBar').style.width = pct + '%';
                        document.getElementById('statSent').textContent = batchRes.total_sent;
                        document.getElementById('statFailed').textContent = batchRes.total_failed;

                        if (batchRes.status === 'complete' || currentOffset >= totalRecipients) {
                            // Completed!
                            document.getElementById('bulkProgressBar').classList.remove('progress-bar-animated', 'progress-bar-striped');
                            document.getElementById('bulkProgressBar').classList.add('bg-success');
                            document.getElementById('modalStatusTitle').textContent = 'All Emails Sent Successfully!';
                            document.getElementById('modalStatusSubtitle').textContent = 'Finished sending bulk emails to ' + totalRecipients + ' recipient(s).';
                            document.getElementById('modalStatusIcon').className = 'ti ti-circle-check fs-28 text-success';
                            document.getElementById('progressStatusText').textContent = 'Process Complete';
                            document.getElementById('btnModalFinish').classList.remove('d-none');
                        } else {
                            // Brief 100ms pause before next batch
                            setTimeout(processNextBatch, 100);
                        }
                    },
                    error: function(xhr, status, error) {
                        document.getElementById('modalErrorNotice').textContent = 'Server response error: ' + error + '. You can refresh to check logs.';
                        document.getElementById('modalErrorNotice').classList.remove('d-none');
                        document.getElementById('btnModalFinish').classList.remove('d-none');
                    }
                });
            }

            // Start sending first batch
            processNextBatch();
        },
        error: function(xhr, status, error) {
            document.getElementById('modalStatusTitle').textContent = 'Request Failed';
            document.getElementById('modalErrorNotice').textContent = 'Network or server error: ' + error;
            document.getElementById('modalErrorNotice').classList.remove('d-none');
            document.getElementById('btnModalFinish').classList.remove('d-none');
        }
    });
});
</script>
