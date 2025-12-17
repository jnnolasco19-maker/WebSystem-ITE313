<?= $this->include('template/header') ?>

<style>
/* Modern Instructor Dashboard Styles */
.dashboard-header {
    background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
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
    background: #0dcaf0;
    border-radius: 3px;
}

.progress-modern {
    height: 8px;
    border-radius: 4px;
}

.progress-container {
    background: #e9ecef;
    border-radius: 4px;
    height: 8px;
    overflow: hidden;
}

.progress-bar-modern {
    height: 100%;
    border-radius: 4px;
}

.teaching-progress-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 16px;
    padding: 1.5rem;
}

.teaching-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(13, 202, 240, 0.1);
    color: #0dcaf0;
}

.course-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.course-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
    border-color: #dee2e6;
}
</style>

<div class="content-area">
    <div class="container-fluid py-4">
        
        <!-- Modern Dashboard Header -->
        <div class="dashboard-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="fw-bold mb-2">Instructor Dashboard</h2>
                    <p class="mb-0 opacity-75">Welcome back, <?= esc($user['name']) ?>!</p>
                </div>
                <div class="text-end">
                    <div class="fs-5 fw-semibold"><?= date('F d, Y') ?></div>
                    <div class="small opacity-75"><?= date('l') ?></div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Enhanced Statistics Cards -->
        <div class="row g-4 mb-4">
            <!-- My Courses -->
            <div class="col-xl-4 col-md-6">
                <div class="stat-card card h-100">
                    <div class="card-body">
                        <div class="stat-icon-container bg-info-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#0dcaf0" viewBox="0 0 16 16">
                                <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-1"><?= esc($myCoursesCount) ?></h3>
                        <p class="text-muted mb-0">My Courses</p>
                    </div>
                </div>
            </div>

            <!-- Total Students -->
            <div class="col-xl-4 col-md-6">
                <div class="stat-card card h-100">
                    <div class="card-body">
                        <div class="stat-icon-container bg-success-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#198754" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-1"><?= esc($totalStudents) ?></h3>
                        <p class="text-muted mb-0">Total Students</p>
                    </div>
                </div>
            </div>

            <!-- Teaching Progress -->
            <div class="col-xl-4 col-md-12">
                <div class="stat-card card h-100">
                    <div class="card-body">
                        <div class="stat-icon-container bg-warning-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#ffc107" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-1">85%</h3>
                        <p class="text-muted mb-0">Teaching Progress</p>
                        <div class="progress mt-3" style="height: 8px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 85%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teaching Progress Section -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="teaching-progress-card">
                    <div class="d-flex align-items-center">
                        <div class="teaching-icon me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Teaching Excellence</h5>
                            <p class="mb-0 text-muted">Great job! Your students are thriving under your guidance.</p>
                        </div>
                        <div>
                            <a href="<?= base_url('instructor/my-courses') ?>" class="btn btn-info">Manage Courses</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Courses Section -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="stat-card card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="section-title mb-0">My Courses</h5>
                            <a href="<?= base_url('instructor/my-courses') ?>" class="btn btn-outline-info btn-sm">View All Courses</a>
                        </div>
                        <?php if (!empty($myCourses)): ?>
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                <?php foreach (array_slice($myCourses, 0, 3) as $course): ?>
                                    <div class="col">
                                        <div class="card course-card h-100">
                                            <div class="card-body">
                                                <h6 class="card-title fw-bold"><?= esc($course['title']) ?></h6>
                                                <p class="card-text text-muted small"><?= esc($course['description'] ?? 'No description available') ?></p>
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <span class="badge bg-info">Active</span>
                                                    <small class="text-muted">
                                                        <?= esc($course['student_count']) ?> students
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="text-muted" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    </svg>
                                </div>
                                <h6 class="text-muted">No courses created yet</h6>
                                <p class="text-muted small">Create your first course to start teaching.</p>
                                <a href="<?= base_url('instructor/my-courses') ?>" class="btn btn-info">Create Course</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Enrollments Section -->
        <div class="row g-4">
            <div class="col-12">
                <div class="stat-card card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="section-title mb-0">Recent Student Enrollments</h5>
                            <a href="<?= base_url('instructor/students') ?>" class="btn btn-outline-success btn-sm">View All Students</a>
                        </div>
                        <?php if (!empty($recentEnrollments)): ?>
                            <div class="table-responsive">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Course</th>
                                            <th>Enrollment Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentEnrollments as $enrollment): ?>
                                            <tr>
                                                <td><?= esc($enrollment['student_name']) ?></td>
                                                <td><?= esc($enrollment['course_title']) ?></td>
                                                <td><?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?></td>
                                                <td><span class="badge bg-success">Enrolled</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="text-muted" viewBox="0 0 16 16">
                                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                    </svg>
                                </div>
                                <h6 class="text-muted">No recent enrollments</h6>
                                <p class="text-muted small">Students will appear here once they enroll in your courses.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>