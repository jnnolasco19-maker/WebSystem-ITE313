<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?= $this->include('templates/header') ?>
<div class="container mt-5">
    <h2 class="mb-4">Courses</h2>
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
                <div class="col-md-4 mb-4">
                    <div class="card course-card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($course['title']) ?></h5>
                            <p class="card-text"><?= esc($course['description']) ?></p>
                            <a href="<?= site_url('/courses/view/' . $course['id']) ?>" class="btn btn-primary">View Course</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">No courses available.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
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
    // Matches only, in case sort is wanted; in this task just hiding/showing is fine
    $('#coursesContainer').append(matches);
  });
});
</script>
</body>
</html>
