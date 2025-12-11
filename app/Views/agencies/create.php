<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>Cipta Agensi</h1>
    <form method="post" action="/admin/agencies">
        <div class="mb-3">
            <label for="name" class="form-label"><?= lang('App.name') ?></label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label"><?= lang('App.description') ?></label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?= lang('App.create') ?></button>
        <a href="/admin/agencies" class="btn btn-secondary"><?= lang('App.cancel') ?></a>
    </form>
</div>
<?= $this->endSection() ?>