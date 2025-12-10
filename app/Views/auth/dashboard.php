<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body class="container mt-5">

<h2>Welcome, <?= session()->get('name') ?>!</h2>
<p>Your role: <?= session()->get('role') ?></p>

<a href="/logout">Logout</a>

</body>
</html>
