<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= csrf_meta() ?>
    <title>Login - Learning Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
            --secondary-gradient: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .login-card {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        
        .login-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
        }
        
        .login-form {
            padding: 2rem;
        }
        
        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
        }
        
        .btn-login {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(111, 66, 193, 0.4);
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        .forgot-password {
            text-align: right;
            margin-bottom: 1rem;
        }
        
        .forgot-password a {
            color: #6f42c1;
            font-weight: 500;
            text-decoration: none;
        }
        
        .signup-link {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid #e9ecef;
            margin-top: 1.5rem;
        }
        
        .signup-link a {
            color: #6f42c1;
            font-weight: 600;
            text-decoration: none;
        }
        
        .logo {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .welcome-text {
            font-size: 1.1rem;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-mortarboard" viewBox="0 0 16 16">
                        <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5ZM8 8.46 1.758 5.965 8 3.052l6.242 2.913L8 8.46Z"/>
                        <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46l-3.892-1.556Z"/>
                    </svg>
                </div>
                <h2 class="fw-bold mb-2">Welcome Back</h2>
                <p class="welcome-text mb-0">Sign in to continue your learning journey</p>
            </div>
            
            <div class="login-form">
                <!-- Alert Messages -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= esc(session()->getFlashdata('error')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error_log')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= esc(session()->getFlashdata('error_log')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('validation_errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('validation_errors') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('login') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="mb-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?= old('email') ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                        <div class="forgot-password">
                            <a href="#" class="text-decoration-none">Forgot Password?</a>
                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-login text-white">Sign In</button>
                    </div>
                </form>

                <div class="signup-link">
                    <p class="mb-0">
                        Don't have an account? 
                        <a href="<?= base_url('register') ?>" class="text-decoration-none">
                            Create Account
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>