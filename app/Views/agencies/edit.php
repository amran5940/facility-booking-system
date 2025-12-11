<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>Edit Agensi</h1>
    <div class="row">
        <?php if (session('error')): ?>
            <div class="alert alert-danger"><?= session('error') ?></div>
        <?php endif; ?>
        <?php if (isset($errors) && $errors): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    <form method="post" action="/admin/agencies/<?= $agency['id'] ?>/update">
        <div class="mb-3">
            <label for="name" class="form-label"><?= lang('App.name') ?></label>
            <input type="text" class="form-control" id="name" name="name" value="<?= old('name', esc($agency['name'])) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label"><?= lang('App.description') ?></label>
            <textarea class="form-control" id="description" name="description"><?= old('description', esc($agency['description'])) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label"><?= lang('App.status') ?></label>
            <select class="form-control" id="status" name="status">
                <option value="active" <?= old('status', $agency['status']) == 'active' ? 'selected' : '' ?>><?= lang('App.active') ?></option>
                <option value="inactive" <?= old('status', $agency['status']) == 'inactive' ? 'selected' : '' ?>><?= lang('App.inactive') ?></option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Kemaskini</button>
        <a href="/admin/agencies" class="btn btn-secondary"><?= lang('App.cancel') ?></a>
    </form>
</div>
<?= $this->endSection() ?>