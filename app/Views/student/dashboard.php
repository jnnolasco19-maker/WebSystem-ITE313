<?= $this->include('template/header') ?>

<style>
/* Modern Student Dashboard Styles */
.dashboard-header {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%);
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
    background: #198754;
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

.learning-progress-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 16px;
    padding: 1.5rem;
}

.learning-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(25, 135, 84, 0.1);
    color: #198754;
}
</style>

<div class="content-area">
    <div class="container-fluid py-4">
        
        <!-- Modern Dashboard Header -->
        <div class="dashboard-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="fw-bold mb-2">Student Dashboard</h2>
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
            <!-- Enrolled Courses -->
            <div class="col-xl-4 col-md-6">
                <div class="stat-card card h-100">
                    <div class="card-body">
                        <div class="stat-icon-container bg-success-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#198754" viewBox="0 0 16 16">
                                <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-1"><?= esc($enrolledCount) ?></h3>
                        <p class="text-muted mb-0">Enrolled Courses</p>
                    </div>
                </div>
            </div>

            <!-- Available Courses -->
            <div class="col-xl-4 col-md-6">
                <div class="stat-card card h-100">
                    <div class="card-body">
                        <div class="stat-icon-container bg-info-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#0dcaf0" viewBox="0 0 16 16">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-1"><?= esc($availableCount) ?></h3>
                        <p class="text-muted mb-0">Available Courses</p>
                    </div>
                </div>
            </div>

            <!-- Learning Progress -->
            <div class="col-xl-4 col-md-12">
                <div class="stat-card card h-100">
                    <div class="card-body">
                        <div class="stat-icon-container bg-warning-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#ffc107" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-1">75%</h3>
                        <p class="text-muted mb-0">Learning Progress</p>
                        <div class="progress mt-3" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Learning Progress Section -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="learning-progress-card">
                    <div class="d-flex align-items-center">
                        <div class="learning-icon me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Learning Journey</h5>
                            <p class="mb-0 text-muted">Keep up the great work! You're making excellent progress.</p>
                        </div>
                        <div>
                            <a href="<?= base_url('student/my-courses') ?>" class="btn btn-success">Continue Learning</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrolled Courses Section -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="stat-card card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="section-title mb-0">Your Enrolled Courses</h5>
                            <a href="<?= base_url('student/my-courses') ?>" class="btn btn-outline-success btn-sm">View All Courses</a>
                        </div>
                        <?php if (!empty($enrolledCourses)): ?>
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                <?php foreach (array_slice($enrolledCourses, 0, 3) as $course): ?>
                                    <div class="col">
                                        <div class="card border h-100">
                                            <div class="card-body">
                                                <h6 class="card-title fw-bold"><?= esc($course['title']) ?></h6>
                                                <p class="card-text text-muted small"><?= esc($course['description'] ?? 'No description available') ?></p>
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <span class="badge bg-success">Enrolled</span>
                                                    <small class="text-muted">Enrolled: <?= date('M d, Y', strtotime($course['enrollment_date'])) ?></small>
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
                                <h6 class="text-muted">No enrolled courses yet</h6>
                                <p class="text-muted small">Browse available courses to get started with your learning journey.</p>
                                <a href="<?= base_url('student/browse') ?>" class="btn btn-success">Browse Courses</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Courses Section -->
        <div class="row g-4">
            <div class="col-12">
                <div class="stat-card card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="section-title mb-0">Recommended Courses</h5>
                            <a href="<?= base_url('student/browse') ?>" class="btn btn-outline-info btn-sm">Browse All</a>
                        </div>
                        <?php if (!empty($availableCourses)): ?>
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                <?php foreach (array_slice($availableCourses, 0, 3) as $course): ?>
                                    <div class="col">
                                        <div class="card border h-100">
                                            <div class="card-body">
                                                <h6 class="card-title fw-bold"><?= esc($course['title']) ?></h6>
                                                <p class="card-text text-muted small"><?= esc($course['description'] ?? 'No description available') ?></p>
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <span class="badge bg-info">New</span>
                                                    <button class="btn btn-sm btn-outline-success enroll-btn" 
                                                            data-course-id="<?= esc($course['id']) ?>">
                                                        Enroll Now
                                                    </button>
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
                                <h6 class="text-muted">No available courses</h6>
                                <p class="text-muted small">Check back later for new course offerings.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery for enrollment functionality -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // Handle enroll button clicks
    $(document).on('click', '.enroll-btn', function(e) {
        e.preventDefault();
        
        const $button = $(this);
        const courseId = $button.data('course-id');
        
        // Disable button to prevent multiple clicks
        $button.prop('disabled', true).text('Enrolling...');
        
        // Get CSRF token
        const csrfToken = $('meta[name="<?= csrf_header() ?>"]').attr('content');
        const csrfTokenName = '<?= csrf_token() ?>';
        
        // Send AJAX request
        $.ajax({
            url: '<?= base_url('course/enroll') ?>',
            type: 'POST',
            data: {
                course_id: courseId,
                [csrfTokenName]: csrfToken
            },
            headers: {
                '<?= csrf_header() ?>': csrfToken
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Show success message
                    alert('Successfully enrolled in the course!');
                    // Reload the page to update the dashboard
                    location.reload();
                } else {
                    // Show error message
                    alert(response.message || 'Enrollment failed. Please try again.');
                    $button.prop('disabled', false).text('Enroll Now');
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 401) {
                    errorMessage = 'Unauthorized. Please log in again.';
                } else if (xhr.status === 403) {
                    errorMessage = 'CSRF token mismatch. Please refresh the page and try again.';
                }
                
                alert(errorMessage);
                $button.prop('disabled', false).text('Enroll Now');
            }
        });
    });
});
</script>
</body>
</html>