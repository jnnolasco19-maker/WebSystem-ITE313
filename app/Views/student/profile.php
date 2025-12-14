<?= $this->include('template/header') ?>

<div class="content-area">
    <div class="container-fluid py-4">
        
        <!-- Page Header -->
        <div class="mb-4">
            <h3 class="fw-bold mb-1">My Profile</h3>
            <p class="text-muted mb-0">Manage your account settings</p>
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

        <div class="row g-4">
            <!-- Profile Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="text-primary" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                </svg>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-1"><?= esc($user['name']) ?></h4>
                        <p class="text-muted mb-3"><?= esc($user['email']) ?></p>
                        <span class="badge bg-primary fs-6 mb-3">Student</span>
                        
                        <hr class="my-4">
                        
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="fw-bold text-primary mb-0"><?= $enrolledCount ?></h4>
                                <small class="text-muted">Enrolled Courses</small>
                            </div>
                            <div class="col-6">
                                <h4 class="fw-bold text-success mb-0">Active</h4>
                                <small class="text-muted">Account Status</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-semibold mb-0">Account Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Member Since</span>
                            <span class="fw-semibold"><?= date('M d, Y', strtotime($user['created_at'] ?? 'now')) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Last Updated</span>
                            <span class="fw-semibold"><?= date('M d, Y', strtotime($user['updated_at'] ?? 'now')) ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Account Type</span>
                            <span class="badge bg-primary">Student</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-semibold mb-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2 text-primary" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                            </svg>
                            Edit Profile
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('student/profile/update') ?>">
                            <?= csrf_field() ?>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" value="<?= esc($user['name']) ?>" class="form-control form-control-lg" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" value="<?= esc($user['email']) ?>" class="form-control form-control-lg" disabled>
                                <small class="text-muted">Email cannot be changed</small>
                            </div>

                            <hr class="my-4">

                            <h6 class="fw-semibold mb-3">Change Password</h6>
                            <p class="text-muted small mb-3">Leave blank if you don't want to change your password</p>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">New Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter new password" minlength="8">
                                    <small class="text-muted">Minimum 8 characters</small>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">Confirm Password</label>
                                    <input type="password" name="password_confirm" class="form-control" placeholder="Confirm new password">
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022z"/>
                                    </svg>
                                    Save Changes
                                </button>
                                <a href="<?= base_url('student/dashboard') ?>" class="btn btn-outline-secondary btn-lg">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
