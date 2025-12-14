<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fafafa;
        }

        .auth-card {
            width: 420px;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(16, 24, 40, .06);
        }

        .auth-title {
            font-weight: 700;
            font-size: 40px;
            line-height: 1.1;
            margin-bottom: 8px;
        }

        .auth-subtitle {
            color: #475467;
            margin-bottom: 28px;
        }

        .form-label {
            font-weight: 600;
            color: #344054;
        }

        .auth-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 6px;
        }

        .btn-primary {
            background-color: #1a73e8;
            border-color: #1a73e8;
            font-weight: 600;
            padding: 10px 16px;
        }

        .btn-primary:hover {
            background-color: #1669d2;
            border-color: #1669d2;
        }

        .login-arrow {
            width: 18px;
            height: 18px;
            margin-left: 6px;
        }

        .auth-footer {
            text-align: center;
            color: #475467;
            margin-top: 18px;
        }

        .auth-footer a {
            text-decoration: none;
            font-weight: 600;
        }

        .input-lg {
            padding: 12px 14px;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="color-scheme" content="light" />
    <meta name="supported-color-schemes" content="light" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="theme-color" content="#ffffff" />
    <meta name="robots" content="noindex, nofollow" />
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div>
                <div class="auth-title">Log in</div>
                <div class="auth-subtitle">to start learning</div>
            </div>

            <!-- Flash messages -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger mb-3"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success mb-3"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (isset($validation)): ?>
                <div class="alert alert-danger mb-3">
                    <?= $validation->listErrors() ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('/login') ?>" method="post" novalidate>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control input-lg" placeholder="you@example.com"
                        value="<?= set_value('email') ?>" required>
                </div>

                <div class="mb-1">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control input-lg" placeholder="••••••••"
                        required>
                </div>

                <div class="auth-actions">
                    <a href="#" class="small">Forgot password?</a>
                </div>

                <button type="submit"
                    class="btn btn-primary w-100 mt-3 d-flex align-items-center justify-content-center">
                    Log in
                    <svg class="login-arrow" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path d="M5 12h14M13 5l7 7-7 7" stroke="#fff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </form>

            <div class="auth-footer">
                Don’t have an account? <a href="<?= site_url('/register') ?>">Sign up now!</a>
            </div>
        </div>
    </div>
</body>

</html>