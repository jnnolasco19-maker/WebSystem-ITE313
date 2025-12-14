<?= $this->include('templates/header') ?>

<style>
    .dash-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fafafa;
        padding: 24px;
    }

    .dash-card {
        width: 100%;
        max-width: 1100px;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 10px 30px rgba(16, 24, 40, .06);
    }

    .dash-title {
        font-weight: 700;
        font-size: 28px;
        margin-bottom: 4px;
    }

    .dash-subtitle {
        color: #475467;
        margin-bottom: 18px;
    }

    .btn-primary {
        background-color: #1a73e8;
        border-color: #1a73e8;
        font-weight: 600;
        padding: 8px 14px;
    }

    .btn-primary:hover {
        background-color: #1669d2;
        border-color: #1669d2;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .course-card {
        border-radius: 10px;
    }
</style>
    <div class="dash-wrapper">
        <div class="dash-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <div class="dash-title">Welcome, <?= esc($name) ?>!</div>
                    <div class="dash-subtitle">You are signed in as <strong><?= esc($role) ?></strong>.</div>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= site_url('/') ?>" class="btn btn-primary">Go to Home</a>
                    <a href="<?= site_url('/logout') ?>" class="btn btn-outline-secondary">Logout</a>
                </div>
            </div>

            <div class="row g-4">
                <!-- Enrolled Courses -->
                <div class="col-lg-6">
                    <div class="section-title">Enrolled Courses</div>

                    <?php if (!empty($enrollments)): ?>
                        <div id="enrolledList" class="list-group">
                            <?php foreach ($enrollments as $e): ?>
                                <div class="list-group-item list-group-item-action mb-2 course-card"
                                    data-course-id="<?= esc($e['id']) ?>">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div>
                                            <h5 class="mb-1"><?= esc($e['title']) ?></h5>
                                            <?php if (!empty($e['description'])): ?>
                                                <small class="text-muted"><?= esc($e['description']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-success">Enrolled</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div id="enrolledList" class="alert alert-info">You have no enrolled courses yet.</div>
                    <?php endif; ?>
                </div>

                <!-- Available Courses -->
                <div class="col-lg-6">
                    <div class="section-title">Available Courses</div>

                    <?php
                    // Build a quick map of enrolled course IDs for disabling buttons
                    $enrolledIds = [];
                    if (!empty($enrollments)) {
                        foreach ($enrollments as $ei) {
                            $enrolledIds[] = $ei['id'];
                        }
                    }
                    ?>

                    <?php if (!empty($courses)): ?>
                        <div id="availableList" class="row g-3">
                            <?php foreach ($courses as $c):
                                $isEnrolled = in_array($c['id'], $enrolledIds, true);
                                ?>
                                <div class="col-12">
                                    <div class="card course-card">
                                        <div class="card-body d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="card-title mb-1"><?= esc($c['title']) ?></h6>
                                                <?php if (!empty($c['description'])): ?>
                                                    <p class="card-text small text-muted mb-0"><?= esc($c['description']) ?></p>
                                                <?php endif; ?>
                                            </div>

                                            <div>
                                                <button class="btn btn-sm btn-primary enroll-btn"
                                                    data-course-id="<?= esc($c['id']) ?>" data_course_id="<?= esc($c['id']) ?>"
                                                    <?= $isEnrolled ? 'disabled' : '' ?>>
                                                    <?= $isEnrolled ? 'Enrolled' : 'Enroll' ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-secondary">No courses available right now.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Grab CSRF token name and value from meta tags
        const csrfName = document.querySelector('meta[name="ci-csrf-name"]').getAttribute('content');
        const csrfHash = document.querySelector('meta[name="ci-csrf-token"]').getAttribute('content');

        // Helper: show simple toast (bootstrap 5 alert style)
        function showToast(message, type = 'success') {
            const wrapper = document.createElement('div');
            wrapper.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show position-fixed" style="right:20px;bottom:20px;z-index:9999;">
                                    ${message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                 </div>`;
            document.body.appendChild(wrapper);
            setTimeout(() => {
                try { wrapper.remove(); } catch (e) { /*ignore*/ }
            }, 4000);
        }

        // Enroll button handlers
        document.querySelectorAll('.enroll-btn').forEach(btn => {
            btn.addEventListener('click', async function () {
                const courseId = this.getAttribute('data-course-id');
                if (!courseId) return;

                // disable while processing
                this.disabled = true;
                const oldText = this.textContent;
                this.textContent = 'Processing...';

                try {
                    // build form data with CSRF token
                    const fd = new FormData();
                    fd.append('course_id', courseId);
                    fd.append(csrfName, csrfHash);

                    const res = await fetch('<?= site_url('course/enroll') ?>', {
                        method: 'POST',
                        body: fd,
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const json = await res.json();

                    if (json.status === 'success') {
                        showToast(json.message || 'Enrolled.', 'success');

                        // Move this course card to enrolled list
                        const card = this.closest('.course-card');
                        if (card) {
                            // create enrolled list item
                            const enrolledList = document.getElementById('enrolledList');
                            const node = document.createElement('div');
                            node.className = 'list-group-item list-group-item-action mb-2 course-card';
                            node.setAttribute('data-course-id', courseId);
                            node.innerHTML = `<div class="d-flex w-100 justify-content-between align-items-start">
                                <div><h5 class="mb-1">${card.querySelector('.card-title').textContent}</h5></div>
                                <small class="text-success">Enrolled</small>
                              </div>`;
                            // if enrolledList was "no enrolled" alert, replace it
                            if (enrolledList.classList.contains('alert')) {
                                enrolledList.innerHTML = '';
                                enrolledList.className = 'list-group';
                                enrolledList.appendChild(node);
                            } else {
                                enrolledList.prepend(node);
                            }

                            // update button text
                            this.textContent = 'Enrolled';
                            this.disabled = true;
                        }

                    } else {
                        // error from server (already enrolled, not logged in, etc)
                        showToast(json.message || 'Enrollment failed.', 'danger');
                        this.disabled = false;
                        this.textContent = oldText;
                    }

                } catch (err) {
                    console.error(err);
                    showToast('Network error. Try again.', 'danger');
                    this.disabled = false;
                    this.textContent = oldText;
                }
            });
        });
    </script>

    <script>
$(function() {
  // read CI4 CSRF token name/value from meta tags (meta names used previously)
  const csrfName  = $('meta[name="ci-csrf-name"]').attr('content'); // token name
  const csrfHash  = $('meta[name="ci-csrf-token"]').attr('content'); // token value

  // helper to show bootstrap alert (insert into top of dash-card)
  function showAlert(message, type = 'success') {
    const alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                         ${message}
                         <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                       </div>`;
    // prepend so user sees it
    $('.dash-card').prepend(alertHtml);
    // remove after 4s
    setTimeout(() => { $('.dash-card .alert').first().alert('close'); }, 4000);
  }

  // click handler for enroll buttons
  $(document).on('click', '.enroll-btn', function(e) {
    e.preventDefault();

    const $btn = $(this);
    // prefer the explicit data_course_id attribute; fallback to data-course-id
    const courseId = $btn.attr('data_course_id') || $btn.data('course-id');

    if (!courseId) return;

    // disable while working
    $btn.prop('disabled', true).text('Processing...');

    // prepare post data with CSRF
    const postData = {};
    postData['course_id'] = courseId;
    if (csrfName && csrfHash) postData[csrfName] = csrfHash;

    $.post('<?= site_url('course/enroll') ?>', postData, function(resp) {
      // expected JSON response with {status: 'success'|'error', message: '...'}
      if (resp && resp.status === 'success') {
        showAlert(resp.message || 'Enrolled.', 'success');

        // change button to disabled + enrolled text
        $btn.text('Enrolled').prop('disabled', true);

        // update enrolled courses list dynamically
        const card = $btn.closest('.course-card');
        let title = 'Course';
        const titleEl = card.find('.card-title, .card h6, .card .card-title').first();
        if (titleEl.length) title = titleEl.text().trim();

        const enrolledList = $('#enrolledList');

        const newItem = $(`<div class="list-group-item list-group-item-action mb-2 course-card" data-course-id="${courseId}">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                              <div><h5 class="mb-1">${title}</h5></div>
                              <small class="text-success">Enrolled</small>
                            </div>
                          </div>`);

        // If enrolledList was alert (no enrollments), convert it to list-group
        if (enrolledList.hasClass('alert')) {
          enrolledList.removeClass().addClass('list-group').empty().append(newItem);
        } else {
          enrolledList.prepend(newItem);
        }

      } else {
        // show server error message
        showAlert((resp && resp.message) ? resp.message : 'Enrollment failed.', 'danger');
        $btn.prop('disabled', false).text('Enroll');
      }
    }, 'json').fail(function() {
      showAlert('Network or server error. Try again.', 'danger');
      $btn.prop('disabled', false).text('Enroll');
    });
  });
});
</script>

<!-- Keep page-specific scripts only; jQuery/Bootstrap already loaded in header -->