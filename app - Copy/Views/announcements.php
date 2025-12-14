<?= $this->extend('templates/header') ?>
<?= $this->section('content') ?>

<?php $isLogged = session()->has('logged_in') || session()->get('isLoggedIn'); ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">📢 Announcements</h2>
            <small class="text-muted">Latest news and updates for all users</small>
        </div>
    </div>

    <!-- flash messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <!-- announcements grid -->
    <?php if (!empty($announcements)): ?>
        <div class="row g-4">
            <?php foreach ($announcements as $a): 
                $id = 'annModal' . $a['id'];
                $excerpt = strlen($a['content']) > 180 ? substr($a['content'], 0, 177) . '...' : $a['content'];
            ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <article class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2"><?= esc($a['title']) ?></h5>
                            <p class="card-text text-muted mb-3" style="flex:0 0 auto;">
                                <?= esc($excerpt) ?>
                            </p>

                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <small class="text-muted"><?= date('M j, Y', strtotime($a['created_at'] ?? 'now')) ?></small>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#<?= $id ?>">
                                        View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Modal for full announcement -->
                <div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= esc($a['title']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted small mb-2">Posted on <?= date('F j, Y g:i A', strtotime($a['created_at'] ?? 'now')) ?></p>
                                <div><?= nl2br(esc($a['content'])) ?></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <h5 class="mb-1">No announcements yet</h5>
                <p class="text-muted mb-0">Check back later for updates.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
