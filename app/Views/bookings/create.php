<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker@latest/dist/litepicker.css">
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --card-shadow: 0 15px 35px rgba(0,0,0,0.1);
        --card-shadow-hover: 0 25px 50px rgba(0,0,0,0.15);
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .booking-header {
        background: var(--primary-gradient);
        border-radius: 25px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        color: white;
        text-align: center;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .booking-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
    }

    .booking-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        position: relative;
        z-index: 2;
    }

    .booking-header p {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 2;
    }

    .facility-info-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(102, 126, 234, 0.1);
        transition: all 0.3s ease;
    }

    .facility-info-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
    }

    .facility-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        margin: 0 auto 1rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .facility-name {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        text-align: center;
        margin-bottom: 0.5rem;
    }

    .facility-details {
        text-align: center;
        color: #6c757d;
    }

    .booking-form-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(102, 126, 234, 0.1);
    }

    .form-section {
        margin-bottom: 2.5rem;
        padding: 2rem;
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        border-radius: 15px;
        border-left: 4px solid #667eea;
    }

    .form-section h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .form-section h3 i {
        margin-right: 0.75rem;
        color: #667eea;
    }

    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        font-size: 1rem;
    }

    .form-label i {
        margin-right: 0.5rem;
        color: #667eea;
        width: 20px;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        transform: translateY(-2px);
    }

    .form-control[type="date"],
    .form-control[type="datetime-local"] {
        padding: 0.875rem 1.25rem;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .date-input-group {
        display: flex;
        gap: 1rem;
        align-items: end;
    }

    .date-input-group .form-group {
        flex: 1;
        margin-bottom: 0;
    }

    /* Litepicker custom styling */
    .date-picker-input {
        cursor: pointer;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>');
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 20px;
        padding-right: 45px !important;
    }

    .litepicker {
        font-family: 'Poppins', sans-serif;
        border-radius: 15px !important;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3) !important;
        border: none !important;
    }

    .litepicker .month-item {
        border-radius: 10px !important;
    }

    .litepicker .month-item .month-label {
        font-weight: 600;
        color: #667eea;
        padding: 10px 0;
        font-size: 1rem;
    }

    .litepicker .day {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .litepicker .day:hover:not(.is-disabled) {
        background: rgba(102, 126, 234, 0.1);
        transform: scale(1.05);
    }

    .litepicker .day.is-today {
        color: #667eea;
        font-weight: 700;
    }

    .litepicker .day.is-selected {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
        font-weight: 600;
    }

    .litepicker .day.is-in-range {
        background: rgba(102, 126, 234, 0.15) !important;
        color: #667eea !important;
    }

    .litepicker .day.is-start-date {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
    }

    .litepicker .day.is-end-date {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
    }

    .booking-card {
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .booking-card:hover {
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.15);
    }

    .booking-card-info {
        flex: 1;
    }

    .booking-card-date {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }

    .booking-card-date i {
        color: #667eea;
        font-size: 1.1rem;
    }

    .booking-card-date strong {
        color: #2c3e50;
        font-weight: 600;
    }

    /* Multi-select calendar styling */
    #calendarPicker {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.1);
    }

    #calendarPicker .calendar-month {
        margin-bottom: 0.5rem;
    }

    #calendarPicker .calendar-header {
        text-align: center;
        margin-bottom: 0.75rem;
        font-weight: 600;
        color: #667eea;
        font-size: 0.95rem;
    }

    #calendarPicker .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.3rem;
        margin-bottom: 0.5rem;
    }

    #calendarPicker .calendar-weekday {
        text-align: center;
        font-weight: 600;
        color: #667eea;
        font-size: 0.7rem;
        padding: 0.25rem;
    }

    #calendarPicker .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.3rem;
    }

    #calendarPicker .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s ease;
        font-weight: 500;
        color: #2c3e50;
        user-select: none;
        font-size: 0.85rem;
    }

    #calendarPicker .calendar-day.empty {
        cursor: default;
    }

    #calendarPicker .calendar-day.today {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        font-weight: 700;
        border-color: #667eea;
    }

    #calendarPicker .calendar-day.selectable {
        background: white;
        border: 2px solid #e9ecef;
    }

    #calendarPicker .calendar-day.selectable:hover {
        background: rgba(102, 126, 234, 0.05);
        border-color: #667eea;
        transform: scale(1.05);
    }

    #calendarPicker .calendar-day.selected {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        font-weight: 600;
    }

    #calendarPicker .calendar-day.in-range {
        background: rgba(102, 126, 234, 0.15);
        color: #667eea;
        border-color: #667eea;
        font-weight: 500;
    }

    #calendarPicker .calendar-day.booked {
        background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
        color: white;
        border-color: #f5576c;
        font-weight: 600;
        cursor: not-allowed !important;
        opacity: 0.7;
    }

    #calendarPicker .calendar-day.booked:hover {
        transform: none;
        background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
    }

    #calendarPicker .calendar-day.past {
        color: #ccc;
        cursor: not-allowed;
    }

    .booking-card-days {
        color: #667eea;
        font-size: 0.9rem;
        font-weight: 600;
        background: rgba(102, 126, 234, 0.1);
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        margin-top: 0.5rem;
    }

    .booking-card-remove {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        border: none;
        border-radius: 8px;
        color: white;
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        margin-left: 1rem;
    }

    .booking-card-remove:hover {
        box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        transform: translateY(-2px);
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 3rem;
        flex-wrap: wrap;
    }

    .btn-submit {
        background: var(--success-gradient);
        border: none;
        border-radius: 15px;
        padding: 1rem 3rem;
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        box-shadow: 0 8px 25px rgba(240, 147, 251, 0.3);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(240, 147, 251, 0.4);
        color: white;
    }

    .btn-cancel {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        border: none;
        border-radius: 15px;
        padding: 1rem 3rem;
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-cancel:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(108, 117, 125, 0.4);
        color: white;
    }

    .facility-badge {
        display: inline-block;
        background: var(--info-gradient);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0.25rem;
    }

    .booking-summary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 2rem;
        color: white;
        margin-top: 2rem;
        box-shadow: var(--card-shadow);
    }

    .booking-summary h4 {
        font-weight: 700;
        margin-bottom: 1rem;
        text-align: center;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .summary-label {
        font-weight: 500;
        opacity: 0.9;
    }

    .summary-value {
        font-weight: 600;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 0.5;
            transform: scale(1);
        }
        50% {
            opacity: 1;
            transform: scale(1.05);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }

    .stagger-animation > * {
        animation: fadeInUp 0.8s ease-out;
    }

    .stagger-animation > *:nth-child(1) { animation-delay: 0.1s; }
    .stagger-animation > *:nth-child(2) { animation-delay: 0.2s; }
    .stagger-animation > *:nth-child(3) { animation-delay: 0.3s; }

    @media (max-width: 768px) {
        .booking-header {
            padding: 2rem 1rem;
        }

        .booking-header h1 {
            font-size: 2rem;
        }

        .facility-info-card,
        .booking-form-card {
            padding: 1.5rem;
        }

        .date-input-group {
            flex-direction: column;
            gap: 0;
        }

        .action-buttons {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-submit,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- Booking Header -->
<div class="booking-header fade-in-up">
    <h1><i class="fas fa-calendar-plus me-3"></i>Tempah Fasiliti</h1>
    <p>Sila lengkapkan maklumat tempahan untuk fasiliti yang dipilih</p>
</div>

<div class="container">
    <div class="row stagger-animation">
        <!-- Facility Information -->
        <div class="col-lg-4 mb-4">
            <div class="facility-info-card">
                <div class="facility-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3 class="facility-name"><?= esc($facility['name']) ?></h3>
                <div class="facility-details">
                    <div class="facility-badge">
                        <i class="fas fa-tag me-1"></i>
                        <?= esc($facility['category_name'] ?? 'Fasiliti') ?>
                    </div>
                    <?php if ($facility['agency_id']): ?>
                        <div class="facility-badge">
                            <i class="fas fa-university me-1"></i>
                            <?= esc($facility['agency_name'] ?? 'Agensi') ?>
                        </div>
                    <?php else: ?>
                        <div class="facility-badge">
                            <i class="fas fa-globe me-1"></i>
                            Fasiliti Awam
                        </div>
                    <?php endif; ?>
                    <p class="mt-3 mb-0">
                        <?= esc($facility['description'] ?: 'Tiada penerangan tambahan untuk fasiliti ini.') ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="col-lg-8">
            <div class="booking-form-card">
                <form method="post" action="/user/bookings" id="bookingForm">
                    <input type="hidden" name="facility_id" value="<?= $facility['id'] ?>">
                    <?php $isHostel = isset($category) && strtolower($category['name']) === 'hostel'; ?>

                    <!-- Date Selection Section -->
                    <div class="form-section">
                        <h3><i class="fas fa-calendar-alt"></i> Pilih Hari-Hari Tempahan</h3>
                        <div class="booking-dates-container">
                            <label class="form-label">
                                <i class="fas fa-calendar-check me-2" style="color: #667eea;"></i>
                                Klik pada kalendar untuk memilih hari-hari tempahan
                            </label>
                            <div id="calendarPicker" style="margin: 1.5rem 0;"></div>
                            
                            <!-- Selected Days Display -->
                            <div id="selectedDaysInfo" class="mt-3 p-3" style="background: rgba(102, 126, 234, 0.08); border-radius: 10px; border-left: 4px solid #667eea; display: none;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <small style="color: #666; display: block; margin-bottom: 0.5rem;">Hari-Hari Dipilih:</small>
                                        <div id="selectedDaysList" style="color: #667eea; font-weight: 600;"></div>
                                    </div>
                                    <div style="text-align: right;">
                                        <small style="color: #666; display: block; margin-bottom: 0.5rem;">Jumlah Hari:</small>
                                        <strong id="totalDays" style="color: #667eea; font-size: 1.25rem;">0</strong>
                                    </div>
                                </div>
                            </div>

                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>Anda boleh memilih hari-hari yang tidak bersebelahan. Tekan Ctrl+Klik (atau Cmd+Klik di Mac) untuk memilih berbilang hari
                            </small>

                            <!-- Hidden inputs for form submission -->
                            <input type="hidden" id="selected_dates" name="selected_dates" value="[]">
                        </div>
                    </div>

                    <!-- Additional Notes Section -->
                    <div class="form-section">
                        <h3><i class="fas fa-sticky-note"></i> Maklumat Tambahan</h3>
                        <div class="form-group">
                            <label for="notes" class="form-label">
                                <i class="fas fa-comment"></i>
                                <?= lang('App.notes') ?> (Pilihan)
                            </label>
                            <textarea class="form-control" id="notes" name="notes" placeholder="Sila nyatakan sebarang maklumat tambahan atau kehendak khas..."></textarea>
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="form-section">
                        <h3><i class="fas fa-credit-card"></i> Maklumat Pembayaran</h3>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="payment_gateway" class="form-label">
                                    <i class="fas fa-money-check"></i>
                                    Kaedah Pembayaran
                                </label>
                                <select class="form-control" id="payment_gateway" name="payment_gateway" required>
                                    <option value="">Pilih Kaedah Pembayaran</option>
                                    <option value="online_banking">Perbankan Dalam Talian (FPX)</option>
                                    <option value="credit_card">Kad Kredit</option>
                                    <option value="debit_card">Kad Debit</option>
                                    <option value="cash">Tunai</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="deposit_amount" class="form-label">
                                    <i class="fas fa-coins"></i>
                                    Jumlah Deposit (RM)
                                </label>
                                <input type="number" class="form-control" id="deposit_amount" name="deposit_amount"
                                       placeholder="0.00" step="0.01" min="0" required>
                                <small class="text-muted">Minimum deposit: RM 50.00</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="total_amount" class="form-label">
                                    <i class="fas fa-calculator"></i>
                                    Jumlah Keseluruhan (RM) - Pilihan
                                </label>
                                <input type="number" class="form-control" id="total_amount" name="total_amount"
                                       placeholder="0.00" step="0.01" min="0">
                                <small class="text-muted">Kos penuh termasuk deposit</small>
                            </div>
                        </div>

                        <div class="alert alert-info" style="border-radius: 10px; border-left: 4px solid #17a2b8;">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Maklumat Pembayaran:</strong><br>
                            • Deposit minimum: RM 50.00<br>
                            • Baki pembayaran boleh dibuat selepas kelulusan tempahan<br>
                            • Pembayaran deposit diperlukan untuk mengesahkan tempahan
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            Hantar Tempahan
                        </button>
                        <a href="/user" class="btn-cancel">
                            <i class="fas fa-times"></i>
                            <?= lang('App.cancel') ?>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Multi-day calendar selector
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bookingForm');
    const calendarContainer = document.getElementById('calendarPicker');
    const selectedDateInput = document.getElementById('selected_dates');
    const selectedDaysInfo = document.getElementById('selectedDaysInfo');
    const selectedDaysList = document.getElementById('selectedDaysList');
    const totalDaysSpan = document.getElementById('totalDays');

    let selectedDates = [];
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    // Current viewing month and year
    let currentViewMonth = today.getMonth();
    let currentViewYear = today.getFullYear();

    // Get booked dates from PHP
    const existingBookings = <?php echo json_encode($existingBookings ?? []); ?>;
    const bookedDates = [];
    
    existingBookings.forEach(booking => {
        const start = new Date(booking.start_date);
        const end = new Date(booking.end_date);
        for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
            bookedDates.push(d.toISOString().split('T')[0]);
        }
    });

    // Generate calendar
    const generateCalendar = () => {
        const date = new Date(currentViewYear, currentViewMonth, 1);
        const month = date.toLocaleDateString('ms-MY', { month: 'long', year: 'numeric' });

        // Generate single month with navigation
        let html = `
            <div style="display: flex; align-items: center; justify-content: center; gap: 1rem; margin-bottom: 1rem;">
                <button type="button" id="prevMonth" class="btn btn-outline-primary" style="border-radius: 50%; width: 40px; height: 40px; padding: 0;">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h5 style="margin: 0; min-width: 200px; text-align: center; font-weight: 700;">${month}</h5>
                <button type="button" id="nextMonth" class="btn btn-outline-primary" style="border-radius: 50%; width: 40px; height: 40px; padding: 0;">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        `;
            
            html += `<div class="calendar-month">
                <div class="calendar-header">${month}</div>
                <div class="calendar-weekdays">
                    <div class="calendar-weekday">Ahad</div>
                    <div class="calendar-weekday">Isnin</div>
                    <div class="calendar-weekday">Selasa</div>
                    <div class="calendar-weekday">Rabu</div>
                    <div class="calendar-weekday">Khamis</div>
                    <div class="calendar-weekday">Jumaat</div>
                    <div class="calendar-weekday">Sabtu</div>
                </div>
                <div class="calendar-days">`;

            // Get first day of month
            const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            
            // Add empty cells before first day
            for (let i = 0; i < firstDay.getDay(); i++) {
                html += '<div class="calendar-day empty"></div>';
            }

            // Add days of month
            for (let day = 1; day <= lastDay.getDate(); day++) {
                const dayDate = new Date(date.getFullYear(), date.getMonth(), day);
                const dateStr = dayDate.toISOString().split('T')[0];
                const isToday = dayDate.getTime() === today.getTime();
                const isPast = dayDate < today;
                const isSelected = selectedDates.includes(dateStr);
                const isBooked = bookedDates.includes(dateStr);
                
                // Check if date is within the range
                let isInRange = false;
                if (selectedDates.length > 1) {
                    const minDate = new Date(selectedDates[0]);
                    const maxDate = new Date(selectedDates[selectedDates.length - 1]);
                    isInRange = dayDate >= minDate && dayDate <= maxDate;
                }

                let classes = 'calendar-day';
                if (isBooked) {
                    classes += ' booked';
                } else if (isPast) {
                    classes += ' past';
                } else {
                    classes += ' selectable';
                    if (isToday) classes += ' today';
                }
                if (isSelected) classes += ' selected';
                if (isInRange && !isSelected) classes += ' in-range';

                html += `<div class="${classes}" data-date="${dateStr}" onclick="toggleDate('${dateStr}', event)" style="cursor: ${isPast || isBooked ? 'not-allowed' : 'pointer'}">${day}</div>`;
            }

            html += '</div></div>';

        calendarContainer.innerHTML = html;

        // Add event listeners for month navigation
        document.getElementById('prevMonth').addEventListener('click', () => {
            currentViewMonth--;
            if (currentViewMonth < 0) {
                currentViewMonth = 11;
                currentViewYear--;
            }
            generateCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentViewMonth++;
            if (currentViewMonth > 11) {
                currentViewMonth = 0;
                currentViewYear++;
            }
            generateCalendar();
        });
    };

    // Global function to toggle date - only allow adjacent dates
    window.toggleDate = (dateStr, event) => {
        // Check if date is booked
        if (bookedDates.includes(dateStr)) {
            alert('Tarikh ini telah ditempah. Sila pilih tarikh lain.');
            return;
        }

        const index = selectedDates.indexOf(dateStr);
        
        if (index > -1) {
            // If date is already selected, remove it
            selectedDates.splice(index, 1);
        } else {
            // New date selection
            if (selectedDates.length === 0) {
                // First date
                selectedDates = [dateStr];
            } else if (selectedDates.length === 1) {
                // Second date - add it to create a range
                const existingDate = new Date(selectedDates[0]);
                const newDate = new Date(dateStr);
                
                // Ensure new date is not before existing date
                if (newDate < existingDate) {
                    selectedDates = [dateStr, selectedDates[0]];
                } else {
                    selectedDates = [selectedDates[0], dateStr];
                }
            } else {
                // Already have a range
                const minDate = new Date(Math.min(new Date(selectedDates[0]), new Date(selectedDates[selectedDates.length - 1])));
                const maxDate = new Date(Math.max(new Date(selectedDates[0]), new Date(selectedDates[selectedDates.length - 1])));
                const clickedDate = new Date(dateStr);
                
                // Check if clicked date is adjacent to the range
                const dayBefore = new Date(minDate);
                dayBefore.setDate(dayBefore.getDate() - 1);
                
                const dayAfter = new Date(maxDate);
                dayAfter.setDate(dayAfter.getDate() + 1);
                
                const clickedDateStr = clickedDate.toISOString().split('T')[0];
                const dayBeforeStr = dayBefore.toISOString().split('T')[0];
                const dayAfterStr = dayAfter.toISOString().split('T')[0];
                
                if (clickedDateStr === dayBeforeStr) {
                    // Extend range backwards
                    selectedDates.unshift(dateStr);
                } else if (clickedDateStr === dayAfterStr) {
                    // Extend range forwards
                    selectedDates.push(dateStr);
                } else {
                    // Date is not adjacent - start new selection with this date
                    selectedDates = [dateStr];
                }
            }
        }
        
        // Generate full range if we have 2 dates
        if (selectedDates.length >= 2) {
            const start = new Date(selectedDates[0]);
            const end = new Date(selectedDates[selectedDates.length - 1]);
            selectedDates = [];
            
            for (let date = new Date(start); date <= end; date.setDate(date.getDate() + 1)) {
                const dateStr = date.toISOString().split('T')[0];
                // Skip booked dates
                if (!bookedDates.includes(dateStr)) {
                    selectedDates.push(dateStr);
                }
            }
        }
        
        selectedDates.sort();
        selectedDateInput.value = JSON.stringify(selectedDates);
        generateCalendar();
        updateDisplay();
    };

    // Update display of selected dates
    const updateDisplay = () => {
        if (selectedDates.length === 0) {
            selectedDaysInfo.style.display = 'none';
            return;
        }

        selectedDaysInfo.style.display = 'block';
        const dateStrings = selectedDates.map(dateStr => {
            const date = new Date(dateStr + 'T00:00:00');
            return date.toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' });
        });

        selectedDaysList.innerHTML = dateStrings.join(', ');
        totalDaysSpan.textContent = selectedDates.length;
    };

    // Form validation
    form.addEventListener('submit', function(e) {
        if (selectedDates.length === 0) {
            e.preventDefault();
            alert('Sila pilih sekurang-kurangnya satu hari untuk tempahan');
            return false;
        }

        // Validate deposit amount
        const depositAmount = parseFloat(document.getElementById('deposit_amount').value);
        if (!depositAmount || depositAmount < 50) {
            e.preventDefault();
            alert('Jumlah deposit minimum adalah RM 50.00');
            document.getElementById('deposit_amount').focus();
            return false;
        }

        // Convert selected dates to start_date and end_date
        const sortedDates = [...selectedDates].sort();
        const startDate = sortedDates[0];
        const endDate = sortedDates[sortedDates.length - 1];

        // Create hidden inputs for start_date and end_date
        let startDateInput = document.getElementById('form_start_date');
        let endDateInput = document.getElementById('form_end_date');

        if (!startDateInput) {
            startDateInput = document.createElement('input');
            startDateInput.type = 'hidden';
            startDateInput.id = 'form_start_date';
            startDateInput.name = 'start_date';
            form.appendChild(startDateInput);
        }

        if (!endDateInput) {
            endDateInput = document.createElement('input');
            endDateInput.type = 'hidden';
            endDateInput.id = 'form_end_date';
            endDateInput.name = 'end_date';
            form.appendChild(endDateInput);
        }

        startDateInput.value = startDate;
        endDateInput.value = endDate;

        // Add loading state to submit button
        const submitBtn = form.querySelector('.btn-submit');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghantar...';
        submitBtn.disabled = true;
    });

    // Add focus effects
    const inputs = form.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = '#667eea';
            this.style.boxShadow = '0 0 0 0.2rem rgba(102, 126, 234, 0.25)';
        });

        input.addEventListener('blur', function() {
            this.style.borderColor = '#e9ecef';
            this.style.boxShadow = 'none';
        });
    });

    // Animate cards on load
    const cards = document.querySelectorAll('.facility-info-card, .booking-form-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        setTimeout(() => {
            card.style.transition = 'all 0.8s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Initial render
    generateCalendar();
});
</script>

<?= $this->endSection() ?>