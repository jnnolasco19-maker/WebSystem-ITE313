<!DOCTYPE html>
<html>
<head>
    <title>My Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<?= $this->include('templates/header') ?>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">My Enrolled Courses</h2>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form id="searchForm" class="d-flex" method="get" action="">
                            <div class="input-group">
                                <input type="text" id="searchInput" name="search_term" class="form-control" placeholder="Search courses..." value="<?= isset($searchTerm) ? esc($searchTerm) : '' ?>">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="bi bi-search"></i> Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div id="coursesContainer" class="row">
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $course): ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card course-card h-100">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title mb-0"><?= esc($course['title']) ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($course['description'])): ?>
                                            <p class="card-text"><?= esc($course['description']) ?></p>
                                        <?php endif; ?>
                                        
                                        <h6 class="mt-3 mb-2">Course Materials (<?= count($course['materials']) ?>)</h6>
                                        
                                        <?php if (!empty($course['materials'])): ?>
                                            <div class="list-group list-group-flush">
                                                <?php foreach ($course['materials'] as $material): ?>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span><?= esc($material['file_name']) ?></span>
                                                        <a href="<?= site_url('/materials/download/' . $material['id']) ?>" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            Download
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-info mb-0">
                                                <small>No materials uploaded yet.</small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <h4>No Enrolled Courses</h4>
                            <p>You haven't enrolled in any courses yet. Visit the <a href="<?= site_url('/dashboard') ?>">Dashboard</a> to browse available courses.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
    $(document).ready(function() {
      $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        var $cards = $('.course-card').parent();
        var matches = [];
        $cards.each(function() {
          var text = $(this).text().toLowerCase();
          if (!value || text.indexOf(value) > -1) {
            matches.push(this);
            $(this).show();
          } else {
            $(this).hide();
          }
        });
        $('#coursesContainer').append(matches);
      });
    });
    </script>
</body>
</html>
