<?= $this->include('template/header') ?>

<style>
/* Modern Dashboard Styles */
.dashboard-header {
    background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
    border-radius: 16px;
    padding: 2rem;
    color: white;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.stat-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.stat-icon-container {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.bg-primary-light {
    background: rgba(111, 66, 193, 0.15);
}

.bg-success-light {
    background: rgba(25, 135, 84, 0.15);
}

.bg-info-light {
    background: rgba(13, 202, 240, 0.15);
}

.bg-warning-light {
    background: rgba(255, 193, 7, 0.15);
}

.bg-danger-light {
    background: rgba(220, 53, 69, 0.15);
}

.modern-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.modern-table thead {
    background: #f8f9fa;
}

.modern-table th {
    padding: 1rem 1.5rem;
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #e9ecef;
}

.modern-table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.modern-table tbody tr:last-child td {
    border-bottom: none;
}

.modern-table tbody tr:hover {
    background-color: #f8f9fa;
}

.badge-modern {
    padding: 0.5em 0.8em;
    border-radius: 12px;
    font-weight: 500;
    font-size: 0.85em;
}

.section-title {
    position: relative;
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: #6f42c1;
    border-radius: 3px;
}

.chart-container {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    height: 300px;
}
</style>

<div class="content-area">
    <div class="container-fluid py-4">
        
        <!-- Modern Dashboard Header -->
        <div class="dashboard-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="fw-bold mb-2">Admin Dashboard</h2>
                    <p class="mb-0 opacity-75">Welcome back, <?= esc(session()->get('user_email')) ?></p>
                </div>
                <div class="text-end">
                    <div class="fs-5 fw-semibold"><?= date('F d, Y') ?></div>
                    <div class="small opacity-75"><?= date('l') ?></div>
                </div>
            </div>
        </div>

        <!-- Enhanced Statistics Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Students -->
            <div class="col-xl-3 col-md-6">
                <div class="stat-card card h-100">
                    <div class="card-body">
                        <div class="stat-icon-container bg-primary-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#6f42c1" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-1"><?= esc($totalStudents) ?></h3>
                        <p class="text-muted mb-0">Total Students</p>
                    </div>
                </div>
            </div>

            <!-- Total Courses -->
            <div class="col-xl-3 col-md-6">
                <div class="stat-card card h-100">
                    <div class="card-body">
                        <div class="stat-icon-container bg-success-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#198754" viewBox="0 0 16 16">
                                <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z"/>
                                <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-1"><?= esc($totalCourses) ?></h3>
                        <p class="text-muted mb-0">Total Courses</p>
                    </div>
                </div>
            </div>

            <!-- Total Instructors -->
            <div class="col-xl-3 col-md-6">
                <div class="stat-card card h-100">
                    <div class="card-body">
                        <div class="stat-icon-container bg-info-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#0dcaf0" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-1"><?= esc($totalInstructors) ?></h3>
                        <p class="text-muted mb-0">Total Instructors</p>
                    </div>
                </div>
            </div>

            <!-- Total Enrollments -->
            <div class="col-xl-3 col-md-6">
                <div class="stat-card card h-100">
                    <div class="card-body">
                        <div class="stat-icon-container bg-warning-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#ffc107" viewBox="0 0 16 16">
                                <path d="M8 3a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm.5 11.5a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h.5v-1H2a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h.5v-1H2a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h.5v-1H2a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h.5V3H2a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-.5V3h.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-.5v1h.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-.5v1h.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-.5v1h.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-6.5zm.5-11H3v1h.5V3zm0 2H3v1h.5V5zm0 2H3v1h.5V7zm0 2H3v1h.5V9zm0 2H3v1h.5v-1zm6.5 0h-.5v1H13v-1zm0-2h-.5v1H13V9zm0-2h-.5v1H13V7zm0-2h-.5v1H13V5zm0-2h-.5v1H13V3z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-1"><?= esc($totalEnrollments) ?></h3>
                        <p class="text-muted mb-0">Total Enrollments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <!-- User Statistics Chart -->
            <div class="col-lg-8">
                <div class="chart-container">
                    <h5 class="section-title">User Statistics Overview</h5>
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="text-center">
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="text-muted" viewBox="0 0 16 16">
                                    <path d="M0 14.5a1.5 1.5 0 0 0 1.5 1.5h13a1.5 1.5 0 0 0 1.5-1.5v-7a1.5 1.5 0 0 0-1.5-1.5H10.5a.5.5 0 0 0-.5.5V8a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V6.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 7.5v7zm1.5 0V7.5a.5.5 0 0 1 .5-.5H5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5zm12 0v-7a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                            </div>
                            <h6 class="text-muted">Interactive charts coming soon</h6>
                            <p class="text-muted small">Detailed analytics visualization will be available in the next update</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Restricted Users -->
            <div class="col-lg-4">
                <div class="stat-card card h-100">
                    <div class="card-body">
                        <h5 class="section-title">Account Status</h5>
                        <div class="d-flex align-items-center mb-4">
                            <div class="stat-icon-container bg-danger-light me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#dc3545" viewBox="0 0 16 16">
                                    <path d="M8.158 1.266a1 1 0 0 0-.316 0L1.267 3.003l-.118.037a.5.5 0 0 0-.254.254l-.038.118L.5 7.979l-.001.118a.5.5 0 0 0 .148.353l.118.118.625.625a.5.5 0 0 0 .353.148l.118-.001 4.567-1.522a.5.5 0 0 1 .316 0l4.567 1.522.118.001a.5.5 0 0 0 .353-.148l.625-.625.118-.118a.5.5 0 0 0 .148-.353l-.001-.118-.364-5.567-.038-.118a.5.5 0 0 0-.254-.254l-.118-.037-5.567-.364zm.182 2.873L12 5.5 8.5 6 5 5.5l3.5-1.361zM1.5 8.5l.5 5.5.5-5.5-.5-1-.5 1zm12 0l-.5 1 .5 5.5.5-5.5-.5-1z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0"><?= esc($restrictedUsers) ?></h3>
                                <p class="text-muted mb-0">Restricted Accounts</p>
                            </div>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?= ($restrictedUsers / max($totalStudents + $totalInstructors, 1)) * 100 ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Tables -->
        <div class="row g-4">
            <!-- Recent Users -->
            <div class="col-lg-6">
                <div class="stat-card card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="section-title mb-0">Recent Users</h5>
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-primary btn-sm">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recentUsers)): ?>
                                        <?php foreach ($recentUsers as $user): ?>
                                            <tr>
                                                <td><?= esc($user['name']) ?></td>
                                                <td><?= esc($user['email']) ?></td>
                                                <td>
                                                    <span class="badge bg-secondary"><?= ucfirst(esc($user['role'])) ?></span>
                                                </td>
                                                <td>
                                                    <?php if ($user['status'] === 'granted'): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php elseif ($user['status'] === 'restricted'): ?>
                                                        <span class="badge bg-danger">Restricted</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning"><?= ucfirst(esc($user['status'])) ?></span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No recent users found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Courses -->
            <div class="col-lg-6">
                <div class="stat-card card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="section-title mb-0">Recent Courses</h5>
                            <a href="<?= base_url('admin/courses') ?>" class="btn btn-outline-primary btn-sm">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Course Title</th>
                                        <th>Instructor</th>
                                        <th>Created</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recentCourses)): ?>
                                        <?php foreach ($recentCourses as $course): ?>
                                            <tr>
                                                <td><?= esc($course['title']) ?></td>
                                                <td><?= esc($course['instructor_name'] ?? 'Not assigned') ?></td>
                                                <td><?= date('M d', strtotime($course['created_at'])) ?></td>
                                                <td>
                                                    <?php if ($course['status'] === 'active'): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary"><?= ucfirst(esc($course['status'])) ?></span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No recent courses found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>