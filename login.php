<?php
require_once 'config/database.php';
require_once 'classes/Database.php';
require_once 'classes/Auth.php';

$auth = new Auth();

// Redirect if already logged in
if ($auth->isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($auth->login($username, $password)) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}

$pageTitle = 'Login - HR Management System';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .login-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right {
            padding: 40px 30px;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .login-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container row g-0">
            <div class="col-md-6 login-left">
                <div class="text-center">
                    <i class="fas fa-users-cog login-icon"></i>
                    <h2 class="mb-3">HR Management System</h2>
                    <p class="lead">Streamline your HR operations with our comprehensive management solution</p>
                    <ul class="list-unstyled mt-4 text-start">
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Employee Management</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Payroll Processing</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Attendance Tracking</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Employee Onboarding</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Leave Management</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-6 login-right">
                <h3 class="mb-4">Welcome Back!</h3>
                <p class="text-muted mb-4">Please login to your account</p>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-2"></i>Username
                        </label>
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>

                    <div class="text-center mt-3">
                        <a href="#" class="text-decoration-none">Forgot Password?</a>
                    </div>
                </form>

                <div class="mt-4">
                    <h6 class="text-center mb-3">Quick Login (Demo Accounts)</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="quickLogin('super_admin')">
                                <i class="fas fa-crown me-1"></i>Super Admin
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="quickLogin('hr_director')">
                                <i class="fas fa-user-tie me-1"></i>HR Director
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-info btn-sm w-100" onclick="quickLogin('hr_manager')">
                                <i class="fas fa-users me-1"></i>HR Manager
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-success btn-sm w-100" onclick="quickLogin('payroll_manager')">
                                <i class="fas fa-money-bill me-1"></i>Payroll Mgr
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-warning btn-sm w-100" onclick="quickLogin('recruitment_manager')">
                                <i class="fas fa-user-plus me-1"></i>Recruiter
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="quickLogin('attendance_manager')">
                                <i class="fas fa-clock me-1"></i>Attendance
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-dark btn-sm w-100" onclick="quickLogin('department_manager')">
                                <i class="fas fa-building me-1"></i>Dept Mgr
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-muted btn-sm w-100" onclick="quickLogin('employee')">
                                <i class="fas fa-user me-1"></i>Employee
                            </button>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <small class="text-muted">All demo accounts use password: <strong>1234</strong></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    function quickLogin(username) {
        document.getElementById('username').value = username;
        document.getElementById('password').value = '1234';
        document.querySelector('form').submit();
    }
    </script>
</body>
</html>