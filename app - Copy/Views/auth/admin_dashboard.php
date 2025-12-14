<?= $this->include('templates/header') ?>
<div class="container p-5 mt-5">
    <div class="alert alert-success">
        <h2>Welcome, <?= esc($name) ?> (Admin)!</h2>
        <p>You are signed in as <strong><?= esc($role) ?></strong>. This is your dashboard.</p>
        <!-- Add your admin features here -->
    </div>
</div>
