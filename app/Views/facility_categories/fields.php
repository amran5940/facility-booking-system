<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Urus Medan untuk Kategori: <?= esc($category['name']) ?></h2>
    <a href="/admin/facility-categories" class="btn btn-secondary mb-3">Kembali ke Kategori Fasiliti</a>

    <div class="row">
        <div class="col-md-6">
            <h4>Medan Lalai</h4>
            <p class="text-muted">Medan ini secara automatik tersedia untuk semua fasiliti dalam kategori ini.</p>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Jenis</th>
                        <th>Diperlukan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($defaultFields as $field): ?>
                        <tr>
                            <td><?= esc($field['field_label']) ?></td>
                            <td><?= esc($field['field_type']) ?></td>
                            <td><?= $field['required'] ? 'Ya' : 'Tidak' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h4>Medan Tersuai</h4>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Jenis</th>
                        <th>Diperlukan</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customFields as $field): ?>
                        <tr>
                            <td><?= esc($field['field_label']) ?></td>
                            <td><?= esc($field['field_type']) ?></td>
                            <td><?= $field['required'] ? 'Ya' : 'Tidak' ?></td>
                            <td>
                                <form method="post" action="/admin/facility-categories/fields/<?= $field['id'] ?>/delete" class="d-inline" onsubmit="return confirm('<?= lang('App.are_you_sure') ?>')">
                                    <button type="submit" class="btn btn-sm btn-danger"><?= lang('App.delete') ?></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h5>Tambah Medan Tersuai</h5>
            <form method="post" action="/admin/facility-categories/<?= $category['id'] ?>/fields">
                <div class="mb-3">
                    <label for="field_name" class="form-label">Nama Medan</label>
                    <input type="text" class="form-control" id="field_name" name="field_name" required>
                    <small class="form-text text-muted">Nama dalaman (tiada ruang, alfanumerik)</small>
                </div>
                <div class="mb-3">
                    <label for="field_label" class="form-label">Label Medan</label>
                    <input type="text" class="form-control" id="field_label" name="field_label" required>
                </div>
                <div class="mb-3">
                    <label for="field_type" class="form-label">Jenis Medan</label>
                    <select class="form-control" id="field_type" name="field_type" required>
                        <option value="text">Teks</option>
                        <option value="textarea">Textarea</option>
                        <option value="number">Nombor</option>
                        <option value="date">Tarikh</option>
                        <option value="select">Pilih</option>
                        <option value="checkbox">Checkbox</option>
                    </select>
                </div>
                <div class="mb-3" id="options_group" style="display: none;">
                    <label for="options" class="form-label">Pilihan (satu per baris)</label>
                    <textarea class="form-control" id="options" name="options" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="required" name="required" value="1">
                        <label class="form-check-label" for="required">
                            Diperlukan
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Susunan</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="0">
                </div>
                <button type="submit" class="btn btn-primary">Tambah Medan</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('field_type').addEventListener('change', function() {
    const optionsGroup = document.getElementById('options_group');
    if (this.value === 'select') {
        optionsGroup.style.display = 'block';
    } else {
        optionsGroup.style.display = 'none';
    }
});
</script>
<?= $this->endSection() ?>