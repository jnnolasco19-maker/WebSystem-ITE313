<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CodeIgniter + Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">My Web System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Push nav links to the right -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= service('uri')->getPath() == '' ? 'active' : '' ?>" href="<?= site_url('/') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= service('uri')->getPath() == 'about' ? 'active' : '' ?>" href="<?= site_url('about') ?>">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= service('uri')->getPath() == 'contact' ? 'active' : '' ?>" href="<?= site_url('contact') ?>">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-success <?= service('uri')->getPath() == 'login' ? 'active' : '' ?>" href="<?= site_url('/login') ?>">Login</a>
                </li>
				<li class="nav-item">
					<a class="nav-link text-primary <?= service('uri')->getPath() == 'register' ? 'active' : '' ?>" href="<?= site_url('/register') ?>">Register</a>
				</li>
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
            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-4">
        <?= $this->renderSection('content') ?>
    </div>

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
					var row = $('<div class="d-flex align-items-start"></div>');
					var body = $('<div class="flex-grow-1 small"></div>').text(n.message);
					var actions = $('<div class="ms-2"></div>');
					var btn = $('<button class="btn btn-sm btn-outline-primary">Mark as read</button>');
					btn.on('click', function(e){
						e.preventDefault();
						$.post('<?= site_url('/notifications/mark_read') ?>/'+n.id)
							.done(function(){
								fetchNotifications();
							});
					});
					actions.append(btn);
					row.append(body).append(actions);
					item.append(row);
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
</body>
</html>
