<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>User Registration</h2>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (isset($validation)): ?>
    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
<?php endif; ?>

<form action="/register" method="post">
    <input type="text" name="name" class="form-control mb-2" placeholder="Full Name">
    <input type="email" name="email" class="form-control mb-2" placeholder="Email Address">
    <input type="password" name="password" class="form-control mb-2" placeholder="Password">
    <input type="password" name="password_confirm" class="form-control mb-2" placeholder="Confirm Password">

    <button class="btn btn-primary w-100">Register</button>

    <p class="mt-3">Already registered? <a href="/login">Login here</a></p>
</form>

</body>
</html>
