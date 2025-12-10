<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>User Login</h2>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (isset($validation)): ?>
    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
<?php endif; ?>

<form action="/login" method="post">
    <input type="email" name="email" class="form-control mb-2" placeholder="Email Address">
    <input type="password" name="password" class="form-control mb-2" placeholder="Password">

    <button class="btn btn-primary w-100">Login</button>

    <p class="mt-3">Don't have an account? <a href="/register">Register here</a></p>
</form>

</body>
</html>
