<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Edit Kategori Fasiliti</h3>
            </div>
            <div class="card-body">
                <form method="post" action="/admin/facility-categories/<?= $category['id'] ?>/update">
                    <div class="mb-3">
                        <label for="name" class="form-label"><?= lang('App.name') ?></label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= esc($category['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label"><?= lang('App.description') ?></label>
                        <textarea class="form-control" id="description" name="description"><?= esc($category['description']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kemaskini Kategori</button>
                    <a href="/admin/facility-categories" class="btn btn-secondary"><?= lang('App.cancel') ?></a>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>