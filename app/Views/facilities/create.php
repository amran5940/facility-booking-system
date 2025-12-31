<?= $this->extend('manager_layout') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
#map { height: 400px; width: 100%; border-radius: 8px; margin-bottom: 1rem; }
.geocoder-control { position: absolute; top: 10px; right: 10px; z-index: 1000; }
.geocoder-control input { padding: 0.5rem; border: 2px solid #ccc; border-radius: 4px; width: 250px; }
.image-preview-container { display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1rem; }
.image-preview { position: relative; width: 150px; height: 150px; border: 2px solid #ddd; border-radius: 8px; overflow: hidden; }
.image-preview img { width: 100%; height: 100%; object-fit: cover; }
.image-preview .remove-btn { position: absolute; top: 5px; right: 5px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 25px; height: 25px; cursor: pointer; }
.image-preview .primary-badge { position: absolute; bottom: 5px; left: 5px; background: #28a745; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; }
.image-preview.primary { border-color: #28a745; border-width: 3px; }
</style>
<h2>Tambah Fasiliti</h2>

<form method="post" action="/manager/facilities">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="name" class="form-label"><?= lang('App.name') ?></label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label"><?= lang('App.description') ?></label>
        <textarea class="form-control" id="description" name="description"></textarea>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Kategori</label>
        <select class="form-control" id="category_id" name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="type" class="form-label"><?= lang('App.type') ?></label>
        <select class="form-control" id="type" name="type" required>
            <option value="public">Awam</option>
            <option value="agency">Agensi</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="capacity" class="form-label">Kapasiti</label>
        <input type="number" class="form-control" id="capacity" name="capacity">
    </div>
    <div class="mb-3">
        <label for="location" class="form-label">Lokasi</label>
        <input type="text" class="form-control" id="location" name="location">
    </div>
    <div class="mb-3">
        <label for="pricing_type" class="form-label">Jenis Harga</label>
        <select class="form-control" id="pricing_type" name="pricing_type" required>
            <option value="hourly">Mengikut Jam (Slot)</option>
            <option value="daily">Harian</option>
        </select>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3" id="hourly_price_field">
            <label for="price_per_hour" class="form-label">Harga Sejam (RM)</label>
            <input type="number" step="0.01" class="form-control" id="price_per_hour" name="price_per_hour" min="0" value="0.00">
        </div>
        <div class="col-md-6 mb-3" id="daily_price_field" style="display: none;">
            <label for="price_per_day" class="form-label">Harga Sehari (RM)</label>
            <input type="number" step="0.01" class="form-control" id="price_per_day" name="price_per_day" min="0" value="0.00">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Pilih Lokasi di Peta</label>
        <div class="position-relative">
            <div class="geocoder-control">
                <input type="text" id="geocoder" class="form-control" placeholder="Cari lokasi..." />
            </div>
            <div id="map"></div>
        </div>
        <small class="text-muted">Klik pada peta untuk pilih lokasi atau gunakan carian di atas</small>
        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">
    </div>
    <div class="mb-3">
        <label class="form-label">Gambar Fasiliti (Maksimum 5)</label>
        <input type="file" class="form-control" id="facility_images" name="facility_images[]" multiple accept="image/*">
        <small class="text-muted">Klik pada gambar pertama untuk jadikan gambar utama</small>
        <div id="imagePreviewContainer" class="image-preview-container"></div>
    </div>
    <button type="submit" class="btn btn-primary">Cipta Fasiliti</button>
    <a href="/manager/facilities" class="btn btn-secondary"><?= lang('App.cancel') ?></a>
</form>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// Kedah coordinates and bounds
const kedahBounds = L.latLngBounds(
    L.latLng(5.5, 99.6),  // Southwest
    L.latLng(6.7, 100.8)  // Northeast
);

let map = L.map('map', {
    center: [6.1184, 100.3681], // Alor Setar, Kedah
    zoom: 10,
    maxBounds: kedahBounds,
    maxBoundsViscosity: 1.0,
    minZoom: 9
});

L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
    attribution: '© OpenStreetMap contributors © CARTO',
    subdomains: 'abcd',
    maxZoom: 20
}).addTo(map);

let marker = null;

map.on('click', function(e) {
    const lat = e.latlng.lat;
    const lng = e.latlng.lng;
    
    if (marker) {
        marker.setLatLng(e.latlng);
    } else {
        marker = L.marker(e.latlng).addTo(map);
    }
    
    document.getElementById('latitude').value = lat.toFixed(8);
    document.getElementById('longitude').value = lng.toFixed(8);
    
    // Reverse geocode to get address
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            if (data.display_name) {
                document.getElementById('location').value = data.display_name;
            }
        });
});

// Geocoder search
const geocoderInput = document.getElementById('geocoder');
let searchTimeout;

geocoderInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const query = this.value;
    
    if (query.length < 3) return;
    
    searchTimeout = setTimeout(() => {
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=my&bounded=1&viewbox=99.6,6.7,100.8,5.5`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    const result = data[0];
                    const lat = parseFloat(result.lat);
                    const lng = parseFloat(result.lon);
                    
                    map.setView([lat, lng], 15);
                    
                    if (marker) {
                        marker.setLatLng([lat, lng]);
                    } else {
                        marker = L.marker([lat, lng]).addTo(map);
                    }
                    
                    document.getElementById('latitude').value = lat.toFixed(8);
                    document.getElementById('longitude').value = lng.toFixed(8);
                    document.getElementById('location').value = result.display_name;
                }
            });
    }, 500);
});

// Auto-search when name field loses focus
document.getElementById('name').addEventListener('blur', function() {
    const facilityName = this.value.trim();
    
    if (facilityName.length < 3) return;
    
    // Search for facility name in Kedah
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(facilityName + ' Kedah')}&countrycodes=my&bounded=1&viewbox=99.6,6.7,100.8,5.5`)
        .then(res => res.json())
        .then(data => {
            if (data.length > 0) {
                const result = data[0];
                const lat = parseFloat(result.lat);
                const lng = parseFloat(result.lon);
                
                map.setView([lat, lng], 15);
                
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng]).addTo(map);
                }
                
                document.getElementById('latitude').value = lat.toFixed(8);
                document.getElementById('longitude').value = lng.toFixed(8);
                document.getElementById('location').value = result.display_name;
            }
        })
        .catch(err => console.log('Geocoding error:', err));
});

// Image upload preview
const imageInput = document.getElementById('facility_images');
const previewContainer = document.getElementById('imagePreviewContainer');
let selectedFiles = [];
let primaryIndex = 0;

imageInput.addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    
    if (files.length > 5) {
        alert('Maksimum 5 gambar sahaja');
        return;
    }
    
    selectedFiles = files;
    previewContainer.innerHTML = '';
    
    files.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.createElement('div');
            preview.className = 'image-preview' + (index === primaryIndex ? ' primary' : '');
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="remove-btn" onclick="removeImage(${index})">&times;</button>
                ${index === primaryIndex ? '<span class="primary-badge">Utama</span>' : ''}
            `;
            preview.onclick = (ev) => {
                if (!ev.target.classList.contains('remove-btn')) {
                    setPrimaryImage(index);
                }
            };
            previewContainer.appendChild(preview);
        };
        reader.readAsDataURL(file);
    });
});

function setPrimaryImage(index) {
    primaryIndex = index;
    imageInput.dispatchEvent(new Event('change'));
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    imageInput.files = dataTransfer.files;
    imageInput.dispatchEvent(new Event('change'));
}

// Pricing type toggle
document.getElementById('pricing_type').addEventListener('change', function() {
    const hourlyField = document.getElementById('hourly_price_field');
    const dailyField = document.getElementById('daily_price_field');
    
    if (this.value === 'hourly') {
        hourlyField.style.display = 'block';
        dailyField.style.display = 'none';
        document.getElementById('price_per_hour').required = true;
        document.getElementById('price_per_day').required = false;
    } else {
        hourlyField.style.display = 'none';
        dailyField.style.display = 'block';
        document.getElementById('price_per_hour').required = false;
        document.getElementById('price_per_day').required = true;
    }
});
</script>
<?= $this->endSection() ?>