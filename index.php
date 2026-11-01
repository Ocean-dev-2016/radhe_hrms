<?php
include 'root/config.php';

// Login Logic
if (isset($_POST['login_submit'])) {
    $login_id = mysqli_real_escape_string($ai_conn, $_POST['email']);
    $password = md5($_POST['password']);

    // Check Admin first
    $qry = "SELECT * FROM tbl_admin WHERE (email='$login_id' OR username='$login_id') AND password='$password' AND is_active=1";
    $res = $ai_db->aiGetQuery($qry);

    if (count($res) > 0) {
        $_SESSION['id'] = $res[0]['id'];
        $_SESSION['username'] = $res[0]['username'];
        $_SESSION['email'] = $res[0]['email'];
        $_SESSION['user_type'] = 'admin';
        $_SESSION['success'] = "Login Successful! Welcome Admin.";
        $ai_core->aiGoPage("dashboard.php");
    } else {
        $emp_qry = "SELECT * FROM tbl_users WHERE (user_type='employee' OR user_type='branch') AND (email='$login_id' OR username='$login_id') AND password='$password' AND status='active'";
        $emp_res = $ai_db->aiGetQuery($emp_qry);

        if (count($emp_res) > 0) {
            $_SESSION['id'] = $emp_res[0]['id'];
            $_SESSION['username'] = $emp_res[0]['username'] ? $emp_res[0]['username'] : $emp_res[0]['name'];
            $_SESSION['email'] = $emp_res[0]['email'];
            $_SESSION['user_type'] = $emp_res[0]['user_type'];
            $_SESSION['role'] = $emp_res[0]['role'];
            $_SESSION['branch'] = $emp_res[0]['branch'] ?? 'All';
            unset($_SESSION['role_permissions']);
            $_SESSION['success'] = "Login Successful! Welcome back.";
            $ai_core->aiGoPage("dashboard.php");
        } else {
            $_SESSION['error'] = "Invalid Email/Username or Password!";
        }
    }
}

// Redirect if already logged in
if (isset($_SESSION['id']) && $_SESSION['id'] != '') {
    $ai_core->aiGoPage("dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | Radhe Consultancy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Radhe Consultancy">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/logo/favicon.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="assets/plugins/tabler-icons/tabler-icons.min.css">
    <!-- Custom Login CSS -->
    <link rel="stylesheet" href="assets/css/login-style.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <!-- Floating Consultancy Icons -->
    <i class="ti ti-briefcase medical-icon icon-1"></i>
    <i class="ti ti-chart-bar medical-icon icon-2"></i>
    <i class="ti ti-bulb medical-icon icon-3"></i>
    <i class="ti ti-presentation medical-icon icon-4"></i>
    <i class="ti ti-device-desktop-analytics medical-icon icon-5"></i>
    <i class="ti ti-message medical-icon icon-6"></i>
    <i class="ti ti-target medical-icon icon-7"></i>
    <i class="ti ti-users medical-icon icon-8"></i>
    <i class="ti ti-file-text medical-icon icon-9"></i>
    <i class="ti ti-certificate medical-icon icon-10"></i>
    <i class="ti ti-puzzle medical-icon icon-11"></i>
    <i class="ti ti-signature medical-icon icon-12"></i>
    <i class="ti ti-phone-call medical-icon icon-13"></i>
    <i class="ti ti-brand-zoom medical-icon icon-14"></i>
    <i class="ti ti-coin medical-icon icon-15"></i>

    <div class="auth-container">
        <div class="auth-card">
            <div class="logo-box">
                <h1>RADHE</h1>
                <p>CONSULTANCY</p>
                <h4 style="margin-bottom: 30px; font-weight: 400; opacity: 0.9;">Sign In to Dashboard</h4>
            </div>

            <form action="" method="POST" class="needs-validation" novalidate>
                <div class="form-group">
                    <label class="form-label">Email or Username</label>
                    <div class="input-group">
                        <i class="ti ti-mail"></i>
                        <input type="text" name="email" class="form-control" placeholder="admin@radhe.com or Username"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <i class="ti ti-lock"></i>
                        <input type="password" name="password" id="password-input" class="form-control"
                            placeholder="••••••••" required>
                        <i class="ti ti-eye password-toggle" id="toggle-password"></i>
                    </div>
                </div>

                <div class="form-group d-flex align-items-center gap-2">
                    <input type="checkbox" id="remember" style="accent-color: #2dd4bf; width: 16px; height: 16px;">
                    <label for="remember" style="font-size: 14px; margin: 0; cursor: pointer;">Remember me</label>
                </div>

                <button type="submit" name="login_submit" class="btn-login">SIGN IN NOW</button>
            </form>
        </div>
    </div>

    <div class="copyright-section">
        <p>© 2026 RADHE CONSULTANCY. ALL RIGHTS RESERVED.</p>
        <p>Developed By <span class="dev-by">Ocean Infotech</span></p>
    </div>

    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Form Validation with Toastr
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()

                            // Show Toastr Error for validation
                            toastr.error("Please fill in all required fields properly.", "Validation Error");
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })();

        // Password Toggle Functionality
        const togglePassword = document.querySelector('#toggle-password');
        const password = document.querySelector('#password-input');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('ti-eye');
            this.classList.toggle('ti-eye-off');
        });

        // Toastr Configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        };

        // Check for session messages
        <?php if (isset($_SESSION['success'])): ?>
            toastr.success("<?php echo $_SESSION['success']; ?>", "Success");
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            toastr.error("<?php echo $_SESSION['error']; ?>", "Login Failed");
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </script>
</body>

</html>