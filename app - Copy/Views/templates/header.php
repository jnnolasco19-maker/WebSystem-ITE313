<!DOCTYPE html>
<html>

<head>
    <title><?= esc($title ?? 'LMS') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php $uriPath = service('uri')->getPath(); ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="<?= site_url('/') ?>">Learning Management System</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-primary" href="<?= site_url('/dashboard') ?>">Dashboard</a>
                </li>

                <?php if (session()->get('role') === 'student'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/student/courses') ?>">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/dashboard') ?>">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/dashboard') ?>">My Grades</a>
                    </li>
                <?php endif; ?>

                <?php if (session()->get('role') === 'teacher'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/admin/courses') ?>">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/dashboard') ?>">My Class</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/dashboard') ?>">Students</a>
                    </li>
                <?php endif; ?>

                <?php if (session()->get('role') === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/admin/courses') ?>">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/dashboard') ?>">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/dashboard') ?>">Reports</a>
                    </li>
                <?php endif; ?>

                <!-- Notifications Dropdown -->
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="bi bi-bell"></span>
                        <span id="notifBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="notifDropdown" style="min-width: 320px; max-height: 400px; overflow:auto;" id="notifMenu">
                        <li class="dropdown-item text-muted">No notifications</li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $uriPath === '' || $uriPath === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('/dashboard') ?>">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $uriPath === 'announcements' ? 'active' : '' ?>" href="<?= site_url('/announcements') ?>">Announcements</a>
                </li>

                <?php $role = session()->get('role'); ?>

                <?php if ($role === 'student'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $uriPath === 'student/dashboard' ? 'active' : '' ?>" href="<?= site_url('student/dashboard') ?>">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $uriPath === 'student/grades' ? 'active' : '' ?>" href="<?= site_url('student/grades') ?>">My Grades</a>
                    </li>
                <?php endif; ?>

                <?php if ($role === 'teacher'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $uriPath === 'teacher/dashboard' ? 'active' : '' ?>" href="<?= site_url('teacher/dashboard') ?>">My Class</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $uriPath === 'teacher/students' ? 'active' : '' ?>" href="<?= site_url('teacher/students') ?>">Students</a>
                    </li>
                <?php endif; ?>

                <?php if ($role === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $uriPath === 'admin/dashboard' ? 'active' : '' ?>" href="<?= site_url('admin/dashboard') ?>">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $uriPath === 'admin/reports' ? 'active' : '' ?>" href="<?= site_url('admin/reports') ?>">Reports</a>
                    </li>
                <?php endif; ?>

                <?php if (session()->get('isLoggedIn')): ?>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="<?= site_url('/logout') ?>">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/login') ?>">Login</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        (function($){
            function renderNotifications(data){
                var count = data.count || 0;
                var list = data.notifications || [];
                var $badge = $('#notifBadge');
                var $menu = $('#notifMenu');
                if(count > 0){
                    $badge.text(count).show();
                }else{
                    $badge.hide();
                }
                $menu.empty();
                if(list.length === 0){
                    $menu.append('<li class="dropdown-item text-muted">No notifications</li>');
                    return;
                }
                list.forEach(function(n){
                    var item = $('<li class="dropdown-item"></li>');
                    var box = $('<div class="alert alert-info mb-0 py-2 px-2 d-flex align-items-start"></div>');
                    var body = $('<div class="flex-grow-1 small"></div>').text(n.message);
                    var actions = $('<div class="ms-2"></div>');
                    var btn = $('<button class="btn btn-sm btn-outline-primary">Mark as read</button>');
                    btn.on('click', function(e){
                        e.preventDefault();
                        $.post('<?= site_url('/notifications/mark_read') ?>/'+n.id)
                            .done(function(){ fetchNotifications(); });
                    });
                    actions.append(btn);
                    box.append(body).append(actions);
                    item.append(box);
                    $menu.append(item);
                });
            }

            function fetchNotifications(){
                $.get('<?= site_url('/notifications') ?>')
                    .done(function(data){
                        if(data && data.success){
                            renderNotifications(data);
                        }
                    });
            }

            $(document).ready(function(){
                fetchNotifications();
                setInterval(fetchNotifications, 60000);
            });
        })(jQuery);
        </script>
