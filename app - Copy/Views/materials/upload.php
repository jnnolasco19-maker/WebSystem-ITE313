<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Material</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4 col-md-6">
    <h3 class="mb-3">Upload Course Material</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?php echo session()->getFlashdata('success'); ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?php echo session()->getFlashdata('error'); ?></div>
    <?php endif; ?>
    
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors(); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= current_url() ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="file" class="form-label">Choose File</label>
            <input class="form-control" type="file" name="file" id="file" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Upload</button>
            <a href="<?= site_url('/admin/courses') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
