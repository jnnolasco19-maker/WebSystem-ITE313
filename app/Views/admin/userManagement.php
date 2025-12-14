<?= $this->include('template/header') ?>

<body>

<div class="content-area">

<div class="container-fluid py-4">
    <h3>User Management</h3>
    <!-- Search Bar -->
    <div class="card shadow-sm border-0 p-3 mb-4">
        <form method="get" action="<?= base_url('users') ?>">
            <div class="input-group">
                <input type="text" name="search" value="<?= esc($search) ?>" class="form-control" placeholder="Search users...">
                <button class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
            </div>
        </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-lg"></i> Add User
        </button>
    </div>
    <div class="row g-4">

        <!-- USERS TABLE -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-3 h-100">
                <h5 class="fw-semibold mb-3">All Users</h5>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($users): ?>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $u['id'] ?></td>
                                    <td><?= esc($u['name']) ?></td>
                                    <td><?= esc($u['email']) ?></td>
                                    <td>
                                        <span class="badge bg-info text-dark"><?= esc($u['role']) ?></span>
                                    </td>
                                    <td>
                                        <?php if ($u['status'] === 'granted'): ?>
                                            <span class="badge bg-success">Granted</span>

                                        <?php elseif ($u['status'] === 'restricted'): ?>
                                            <span class="badge bg-danger">Restricted</span>

                                        <?php else: ?>
                                            <span class="badge bg-secondary">Unknown</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(session()->get('user_id') === $u['id']):?>
                                            <h4>You</h4>
                                        <?php else: ?>
                                            <a href="<?= base_url('users/edit/' . $u['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No users found.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- EDIT FORM -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 p-3">

                <?php if ($editUser): ?>
                    <h5 class="fw-semibold mb-3">Edit User</h5>

                    <form method="post" action="<?= base_url('users/update') ?>">
                        <input type="hidden" name="id" value="<?= $editUser['id'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                value="<?= esc($editUser['name']) ?>" 
                                class="form-control"
                                pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" 
                                title="Only letters and spaces are allowed" 
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-control">
                                <option value="admin" <?= $editUser['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="instructor" <?= $editUser['role'] == 'instructor' ? 'selected' : '' ?>>Instructor</option>
                                <option value="student" <?= $editUser['role'] == 'student' ? 'selected' : '' ?>>Student</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="granted" <?= $editUser['status'] == 'granted' ? 'selected' : '' ?>>Granted</option>
                                <option value="restricted" <?= $editUser['status'] == 'restricted' ? 'selected' : '' ?>>Restricted</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                class="form-control"
                                placeholder="Enter new password"
                                minlength="8"
                            >
                            <small class="text-muted">Leave blank to keep current password</small>
                        </div>

                        <button class="btn btn-success w-100">Update</button>
                    </form>

                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        Select a user to edit.
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>

</div>

</div> <!-- END content-area -->

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="<?= base_url('users/create') ?>">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input 
                type="text" 
                name="name" 
                class="form-control" 
                pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" 
                title="Only letters and spaces are allowed" 
                required
            >
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input 
                type="email" 
                name="email" 
                class="form-control" 
                required
                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                title="Enter a valid email without special symbols (except . _ % + - @)"
            >

          </div>

          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="instructor">Instructor</option>
                <option value="student">Student</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="granted">Granted</option>
                <option value="restricted">Restricted</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Add User</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>

