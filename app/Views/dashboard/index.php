<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<div class="p-4 bg-light rounded-3">
  <h2 class="mb-1">Welcome, <?= esc($userName) ?>!</h2>
  <p class="text-muted mb-0">This is your student dashboard.</p>
</div>

<div class="row mt-4 g-3">
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Profile</h5>
        <p class="card-text">View and update your personal information.</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Courses</h5>
        <p class="card-text">Access your enrolled courses and materials.</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Grades</h5>
        <p class="card-text">Check your latest grades and progress.</p>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
