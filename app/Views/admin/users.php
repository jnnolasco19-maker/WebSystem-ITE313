<?= $this->include('template/header') ?>

<div class="content-area">
    <div class="container-fluid py-4">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">User Management</h3>
                <p class="text-muted mb-0">Manage all system users</p>
            </div>
            <button class="btn" style="background-color: #6f42c1; color: white;" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                Add User
            </button>
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

        <!-- Search & Filter -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="get" action="<?= base_url('admin/users') ?>">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" value="<?= esc($search) ?>" class="form-control" placeholder="Search by name or email...">
                        </div>
                        <div class="col-md-3">
                            <select name="role" class="form-select">
                                <option value="">All Roles</option>
                                <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="instructor" <?= $role === 'instructor' ? 'selected' : '' ?>>Instructor</option>
                                <option value="student" <?= $role === 'student' ? 'selected' : '' ?>>Student</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="granted" <?= $status === 'granted' ? 'selected' : '' ?>>Active</option>
                                <option value="restricted" <?= $status === 'restricted' ? 'selected' : '' ?>>Restricted</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn w-100" style="background-color: #6f42c1; color: white;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg>
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <!-- Users Table -->
            <div class="<?= $editUser ? 'col-lg-8' : 'col-12' ?>">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)): ?>
                                        <?php foreach ($users as $u): ?>
                                            <tr class="<?= ($editUser && $editUser['id'] == $u['id']) ? 'table-active' : '' ?><?= $u['is_deleted'] ? ' table-secondary' : '' ?>">
                                                <td><span class="badge bg-light text-dark">#<?= $u['id'] ?></span></td>
                                                <td>
                                                    <div>
                                                        <div class="fw-semibold"><?= esc($u['name']) ?></div>
                                                        <small class="text-muted"><?= esc($u['email']) ?></small>
                                                        <?php if ($u['is_deleted']): ?>
                                                            <span class="badge bg-danger ms-2">DELETED</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php
                                                    $roleClass = match($u['role']) {
                                                        'admin' => 'bg-danger',
                                                        'instructor' => 'bg-info',
                                                        default => 'bg-secondary'
                                                    };
                                                    ?>
                                                    <span class="badge <?= $roleClass ?>"><?= ucfirst(esc($u['role'])) ?></span>
                                                </td>
                                                <td>
                                                    <?php if ($u['status'] === 'granted'): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Restricted</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <small class="text-muted"><?= date('M d, Y', strtotime($u['created_at'] ?? 'now')) ?></small>
                                                </td>
                                                <td>
                                                    <?php if (session()->get('user_id') == $u['id']): ?>
                                                        <span class="badge" style="background-color: #6f42c1;">You</span>
                                                    <?php elseif ($u['role'] === 'instructor'): ?>
                                                        <!-- Instructors cannot be deleted, show a disabled button -->
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" title="Instructors cannot be deleted" disabled>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                                <path d="M8 1a7 7 0 1 1 0 14A7 7 0 0 1 8 1zM0 8a8 8 0 1 0 16 0A8 8 0 0 0 0 8z"/>
                                                                <path d="M9.5 6.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                                <path d="M5.5 8.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                                            </svg>
                                                        </button>
                                                    <?php elseif ($u['is_deleted']): ?>
                                                        <!-- Restore button for deleted users -->
                                                        <form action="<?= base_url('admin/users/restore/' . $u['id']) ?>" method="post" class="d-inline">
                                                            <?= csrf_field() ?>
                                                            <button type="submit" class="btn btn-outline-success btn-sm" title="Restore">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.354-5.854a.5.5 0 1 1-.708-.708L13.293 8.5 12.146 7.354a.5.5 0 1 1 .708-.708l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5Z"/>
                                                                    <path d="M8.5 12.5a.5.5 0 0 1-1 0V9.793l-.646.647a.5.5 0 0 1-.708-.708l1.5-1.5a.5.5 0 0 1 .708 0l1.5 1.5a.5.5 0 0 1-.708.708L8.5 9.793V12.5Z"/>
                                                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5ZM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2Z"/>
                                                                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5Z"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    <?php else: ?>
                                                        <!-- Action buttons for active users -->
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="<?= base_url('admin/users/edit/' . $u['id']) ?>" class="btn btn-outline-warning" title="Edit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                                </svg>
                                                            </a>
                                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $u['id'] ?>" title="Delete">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                                </svg>
                                                            </button>
                                                        </div>

                                                        <!-- Delete Modal -->
                                                        <div class="modal fade" id="deleteModal<?= $u['id'] ?>" tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header border-0">
                                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center py-4">
                                                                        <div class="mb-3">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="text-danger" viewBox="0 0 16 16">
                                                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                                                            </svg>
                                                                        </div>
                                                                        <p>Are you sure you want to delete <strong><?= esc($u['name']) ?></strong>?</p>
                                                                        <small class="text-muted">This user will be hidden but can be restored later.</small>
                                                                    </div>
                                                                    <div class="modal-footer border-0 justify-content-center">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                        <form action="<?= base_url('admin/users/delete/' . $u['id']) ?>" method="post" class="d-inline">
                                                                            <?= csrf_field() ?>
                                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="mb-3 text-muted" viewBox="0 0 16 16">
                                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                                </svg>
                                                <p class="mb-0">No users found</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form Sidebar -->
            <?php if ($editUser): ?>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning bg-opacity-10 border-0">
                        <h5 class="fw-semibold mb-0 text-warning">Edit User</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('admin/users/update') ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $editUser['id'] ?>">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Name</label>
                                <input type="text" name="name" value="<?= esc($editUser['name']) ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" value="<?= esc($editUser['email']) ?>" class="form-control" disabled>
                                <small class="text-muted">Email cannot be changed</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="instructor" <?= $editUser['role'] == 'instructor' ? 'selected' : '' ?>>Instructor</option>
                                    <option value="student" <?= $editUser['role'] == 'student' ? 'selected' : '' ?>>Student</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="granted" <?= $editUser['status'] == 'granted' ? 'selected' : '' ?>>Active</option>
                                    <option value="restricted" <?= $editUser['status'] == 'restricted' ? 'selected' : '' ?>>Restricted</option>
                                </select>
                            </div>

                            <hr class="my-3">

                            <div class="mb-4">
                                <label class="form-label fw-semibold">New Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter new password" minlength="8">
                                <small class="text-muted">Leave blank to keep current password</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning">Update User</button>
                                <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?= base_url('admin/users/create') ?>">
                <?= csrf_field() ?>
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email address" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" minlength="8" required>
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="student">Student</option>
                                <option value="instructor">Instructor</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="granted">Active</option>
                                <option value="restricted">Restricted</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background-color: #6f42c1; color: white;">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
