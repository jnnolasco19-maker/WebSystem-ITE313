<?= $this->include('template/header') ?>

<body>

<div class="content-area">  <!-- ADD THIS WRAPPER -->

<?php if (session()->get('user_role') === 'admin'): ?>

    <div class="container-fluid py-4">

        <!-- Statistic Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card text-center p-4 shadow-sm">
                    <h6 class="text-muted mb-2">Total Students</h6>
                    <h3 class="fw-bold text-primary"><?= esc($students ?? 250) ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-4 shadow-sm">
                    <h6 class="text-muted mb-2">Total Courses</h6>
                    <h3 class="fw-bold text-primary"><?= esc($courses ?? 18) ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-4 shadow-sm">
                    <h6 class="text-muted mb-2">Instructors</h6>
                    <h3 class="fw-bold text-primary"><?= esc($instructors ?? 12) ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-4 shadow-sm">
                    <h6 class="text-muted mb-2">Pending Approvals</h6>
                    <h3 class="fw-bold text-primary"><?= esc($pending ?? 5) ?></h3>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <h5 class="fw-semibold mb-3">Recent Activities</h5>
        <div class="card shadow-sm border-0 p-3">
            <table class="table table-borderless align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Activity</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>New course added: <strong>Python Basics</strong></td>
                        <td>Instructor A</td>
                        <td>Nov 13, 2025</td>
                        <td><span class="badge bg-success">Approved</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Student registered: <strong>John Doe</strong></td>
                        <td>System</td>
                        <td>Nov 12, 2025</td>
                        <td><span class="badge bg-info">New</span></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Assignment submitted: <strong>UI/UX Project</strong></td>
                        <td>Jane Smith</td>
                        <td>Nov 12, 2025</td>
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

<?php endif; ?>

<?php if (session()->get('user_role') === 'instructor'): ?>
    <div class="container-fluid py-4">

    <!-- Statistic Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card text-center p-4 shadow-sm">
                <h6 class="text-muted mb-2">My Courses</h6>
                <h3 class="fw-bold text-primary"><?= esc($myCourses ?? 6) ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-4 shadow-sm">
                <h6 class="text-muted mb-2">Active Students</h6>
                <h3 class="fw-bold text-primary"><?= esc($activeStudents ?? 140) ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-4 shadow-sm">
                <h6 class="text-muted mb-2">Assignments to Grade</h6>
                <h3 class="fw-bold text-primary"><?= esc($pendingGrades ?? 24) ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-4 shadow-sm">
                <h6 class="text-muted mb-2">Announcements Posted</h6>
                <h3 class="fw-bold text-primary"><?= esc($announcements ?? 3) ?></h3>
            </div>
        </div>
    </div>

    <!-- Recent Submissions -->
    <h5 class="fw-semibold mb-3">Recent Student Submissions</h5>
    <div class="card shadow-sm border-0 p-3 mb-5">
        <table class="table table-borderless align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Assignment</th>
                    <th>Course</th>
                    <th>Date Submitted</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Ana Cruz</td>
                    <td>Project 1</td>
                    <td>Web Development</td>
                    <td>Nov 14, 2025</td>
                    <td><span class="badge bg-warning text-dark">To Grade</span></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Marco Reyes</td>
                    <td>Quiz 2</td>
                    <td>Python Basics</td>
                    <td>Nov 14, 2025</td>
                    <td><span class="badge bg-warning text-dark">To Grade</span></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Sarah Gomez</td>
                    <td>Module 3 Task</td>
                    <td>UX Design</td>
                    <td>Nov 13, 2025</td>
                    <td><span class="badge bg-success">Graded</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- My Courses -->
    <h5 class="fw-semibold mb-3">My Courses</h5>
    <div class="card shadow-sm border-0 p-3">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Course Name</th>
                    <th>Students</th>
                    <th>Status</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Python Basics</td>
                    <td>48</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Web Development</td>
                    <td>56</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>UI/UX Design</td>
                    <td>36</td>
                    <td><span class="badge bg-secondary">Paused</span></td>
                    <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                </tr>
            </tbody>
        </table>
    </div>

<?php endif; ?>

<?php if (session()->get('user_role') === 'student'): ?>
    <div class="container-fluid py-4">

    <!-- Statistic Cards -->
    <div class="row g-4 mb-5">
        
        <div class="col-md-3">
            <div class="card text-center p-4 shadow-sm">
                <h6 class="text-muted mb-2">Enrolled Courses</h6>
                <h3 class="fw-bold text-primary"><?= esc($enrolledCoursesCount ?? 0) ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-4 shadow-sm">
                <h6 class="text-muted mb-2">Completed Lessons</h6>
                <h3 class="fw-bold text-primary"><?= esc($completedLessons ?? 32) ?></h3>
            </div>
        </div> 

        <div class="col-md-3">
            <div class="card text-center p-4 shadow-sm">
                <h6 class="text-muted mb-2">Pending Assignments</h6>
                <h3 class="fw-bold text-primary"><?= esc($pendingAssignments ?? 4) ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-4 shadow-sm">
                <h6 class="text-muted mb-2">My Average Grade</h6>
                <h3 class="fw-bold text-primary"><?= esc($averageGrade ?? "88%") ?></h3>
            </div>
        </div>

    </div>

    <!-- Recent Activity -->
    <h5 class="fw-semibold mb-3">Recent Activity</h5>
    <div class="card shadow-sm border-0 p-3 mb-5">
        <table class="table table-borderless align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Activity</th>
                    <th>Course</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td>Completed Lesson 5</td>
                    <td>Python Basics</td>
                    <td>Nov 14, 2025</td>
                    <td><span class="badge bg-success">Completed</span></td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Submitted Assignment 2</td>
                    <td>Web Development</td>
                    <td>Nov 14, 2025</td>
                    <td><span class="badge bg-info">Submitted</span></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>New Announcement</td>
                    <td>UX Design</td>
                    <td>Nov 13, 2025</td>
                    <td><span class="badge bg-secondary">Unread</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Enrolled Courses Section -->
    <h5 class="fw-semibold mb-3">Enrolled Courses</h5>
    <div class="card shadow-sm border-0 p-3 mb-5" id="enrolledCoursesSection">
        <?php if (!empty($enrolledCourses)): ?>
            <div class="list-group">
                <?php foreach ($enrolledCourses as $index => $enrollment): ?>
                    <div class="list-group-item list-group-item-action" data-course-id="<?= esc($enrollment['course_id']) ?>">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><?= esc($enrollment['title']) ?></h6>
                                <p class="mb-1 text-muted"><?= esc($enrollment['description'] ?? 'No description available') ?></p>
                                <small class="text-muted">Enrolled on: <?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?></small>
                            </div>
                            <span class="badge bg-success">Enrolled</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle"></i> You are not enrolled in any courses yet. Browse available courses below to get started!
            </div>
        <?php endif; ?>
    </div>

    <!-- Available Courses Section -->
    <h5 class="fw-semibold mb-3">Available Courses</h5>
    <div class="card shadow-sm border-0 p-3" id="availableCoursesSection">
        <?php if (!empty($availableCourses)): ?>
            <div class="list-group">
                <?php foreach ($availableCourses as $course): ?>
                    <div class="list-group-item list-group-item-action" data-course-id="<?= esc($course['id']) ?>">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1"><?= esc($course['title']) ?></h6>
                                <p class="mb-1 text-muted"><?= esc($course['description'] ?? 'No description available') ?></p>
                            </div>
                            <button class="btn btn-primary btn-sm enroll-btn" data-course-id="<?= esc($course['id']) ?>">
                                Enroll
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle"></i> No available courses at the moment. All courses have been enrolled or there are no courses in the system.
            </div>
        <?php endif; ?>
    </div>

    <!-- Alert Container for Messages -->
    <div id="alertContainer" class="mt-3"></div>

</div>

<?php endif; ?>

</div> <!-- END content-area -->

<!-- jQuery Library -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- AJAX Enrollment Script -->
<script>
$(document).ready(function() {
    // Handle enroll button clicks
    $(document).on('click', '.enroll-btn', function(e) {
        e.preventDefault();
        
        const $button = $(this);
        const courseId = $button.data('course-id');
        const $courseItem = $button.closest('.list-group-item');
        
        // Disable button to prevent multiple clicks
        $button.prop('disabled', true).text('Enrolling...');
        
        // Get CSRF token from meta tag (CodeIgniter uses X-CSRF-TOKEN header name)
        const csrfToken = $('meta[name="<?= csrf_header() ?>"]').attr('content');
        const csrfTokenName = '<?= csrf_token() ?>';
        
        if (!csrfToken) {
            showAlert('danger', 'CSRF token not found. Please refresh the page.');
            $button.prop('disabled', false).text('Enroll');
            return;
        }
        
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
                    showAlert('success', response.message);
                    
                    // Remove course from available courses
                    $courseItem.fadeOut(300, function() {
                        $(this).remove();
                        
                        // Check if no more available courses
                        if ($('#availableCoursesSection .list-group-item').length === 0) {
                            $('#availableCoursesSection').html(
                                '<div class="alert alert-info mb-0">' +
                                '<i class="bi bi-info-circle"></i> No available courses at the moment.' +
                                '</div>'
                            );
                        }
                    });
                    
                    // Add to enrolled courses section
                    addToEnrolledCourses(response.course);
                    
                    // Update enrolled courses count
                    updateEnrolledCount();
                } else {
                    // Show error message
                    showAlert('danger', response.message);
                    $button.prop('disabled', false).text('Enroll');
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
                    // Optionally reload the page to get a new CSRF token
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
                
                showAlert('danger', errorMessage);
                $button.prop('disabled', false).text('Enroll');
            }
        });
    });
    
    // Function to show alert messages
    function showAlert(type, message) {
        const alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                         message +
                         '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                         '</div>';
        
        $('#alertContainer').html(alertHtml);
        
        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $('#alertContainer .alert').fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Function to add course to enrolled courses section
    function addToEnrolledCourses(course) {
        const enrolledSection = $('#enrolledCoursesSection');
        
        // Remove "no courses" message if exists
        enrolledSection.find('.alert-info').remove();
        
        // Create list group if it doesn't exist
        if (enrolledSection.find('.list-group').length === 0) {
            enrolledSection.html('<div class="list-group"></div>');
        }
        
        const enrollmentDate = new Date().toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric' 
        });
        
        const courseHtml = '<div class="list-group-item list-group-item-action" data-course-id="' + course.id + '">' +
                          '<div class="d-flex w-100 justify-content-between align-items-center">' +
                          '<div>' +
                          '<h6 class="mb-1">' + escapeHtml(course.title) + '</h6>' +
                          '<p class="mb-1 text-muted">' + escapeHtml(course.description || 'No description available') + '</p>' +
                          '<small class="text-muted">Enrolled on: ' + enrollmentDate + '</small>' +
                          '</div>' +
                          '<span class="badge bg-success">Enrolled</span>' +
                          '</div>' +
                          '</div>';
        
        enrolledSection.find('.list-group').prepend(courseHtml);
    }
    
    // Function to update enrolled courses count
    function updateEnrolledCount() {
        const count = $('#enrolledCoursesSection .list-group-item').length;
        $('.card:has(h6:contains("Enrolled Courses")) h3').text(count);
    }
    
    // Function to escape HTML (prevent XSS)
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
    }
    
});
</script>

</body>
</html>