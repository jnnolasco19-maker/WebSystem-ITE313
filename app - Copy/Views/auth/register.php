<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
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
            width: 480px;
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

        .input-lg {
            padding: 12px 14px;
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
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-title">Create account</div>
            <div class="auth-subtitle">Join us and start learning</div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success mb-3"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (isset($validation)): ?>
                <div class="alert alert-danger mb-3">
                    <?= $validation->listErrors() ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('/register') ?>" novalidate>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Full name</label>
                    <input type="text" name="name" placeholder="Enter you Name" class="form-control input-lg"
                        value="<?= set_value('name') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" placeholder="you@example.com" class="form-control input-lg"
                        value="<?= set_value('email') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" placeholder="••••••••" class="form-control input-lg"
                        required>
                </div>

                <div class="mb-1">
                    <label class="form-label">Confirm password</label>
                    <input type="password" name="password_confirm" placeholder="••••••••" class="form-control input-lg"
                        required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Create account</button>
            </form>

            <div class="auth-footer">
                Already have an account? <a href="<?= site_url('/login') ?>">Log in</a>
            </div>
        </div>
    </div>
</body>

</html>