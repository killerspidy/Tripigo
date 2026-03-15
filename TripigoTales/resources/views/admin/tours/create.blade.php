@extends('admin.layouts.app')

@section('title', 'Add New Tour')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
/* ─── Tag Input ─────────────────────────────── */
.tags-input {
    display:flex; flex-wrap:wrap; align-items:center; gap:6px;
    padding:8px 10px; border:1.5px solid #d1d3dd; border-radius:6px; min-height:44px;
    background:#fff; cursor:text;
}
.tags-input:focus-within { border-color:#4e73df; box-shadow:0 0 0 3px rgba(78,115,223,.12); }
.tags-input input { border:none; outline:none; flex:1; min-width:120px; padding:2px 4px; font-size:14px; background:transparent; }
.tag {
    display:inline-flex; align-items:center; gap:6px;
    background:#e8f0fe; border:1px solid #c2d4f8; color:#3a5fc8;
    border-radius:20px; padding:3px 12px; font-size:13px; font-weight:500;
}
.tag .remove-tag { cursor:pointer; font-weight:700; opacity:.7; line-height:1; }
.tag .remove-tag:hover { opacity:1; }

/* ─── Section Headers ───────────────────────── */
.form-section-header {
    display:flex; align-items:center; gap:10px;
    padding:10px 16px; margin-bottom:20px;
    background:linear-gradient(135deg,#f0f4ff,#fafbff);
    border-left:4px solid #4e73df; border-radius:0 8px 8px 0;
}
.form-section-header i { color:#4e73df; font-size:16px; }
.form-section-header h6 { margin:0; color:#2e59d9; font-weight:700; font-size:15px; }

/* ─── Schedule Cards ────────────────────────── */
.sched-radio-card {
    display:flex; align-items:flex-start; gap:12px; padding:14px 18px;
    border:2px solid #e2e8f0; border-radius:10px; cursor:pointer;
    transition:all .2s ease; flex:1; min-width:200px;
}
.sched-radio-card:hover { border-color:#4e73df; background:#f0f4ff; }
.sched-radio-card input[type=radio]:checked + label,
.sched-radio-card.active { border-color:#4e73df !important; background:#eef2ff; }
.sched-radio-card .sched-icon { font-size:22px; margin-top:2px; flex-shrink:0; }
.sched-radio-card .sched-title { font-weight:700; color:#1a202c; font-size:14px; }
.sched-radio-card .sched-desc  { font-size:12px; color:#718096; margin-top:2px; }

.day-badge {
    display:inline-flex; flex-direction:column; align-items:center;
    border:2px solid #e2e8f0; border-radius:10px; padding:8px 14px;
    cursor:pointer; transition:all .2s; min-width:76px;
    background:#fff; user-select:none;
}
.day-badge:hover { border-color:#4e73df; background:#f0f4ff; }
.day-badge input[type=checkbox] { display:none; }
.day-badge.checked { border-color:#4e73df; background:#eef2ff; color:#2e59d9; }
.day-badge .day-abbr { font-size:11px; font-weight:600; letter-spacing:.5px; text-transform:uppercase; color:#718096; }
.day-badge.checked .day-abbr { color:#4e73df; }
.day-badge .day-name { font-size:13px; font-weight:600; margin-top:2px; color:#2d3748; }
.day-badge.checked .day-name { color:#2e59d9; }

/* ─── Upload Preview ────────────────────────── */
.upload-zone {
    border:2px dashed #cbd5e0; border-radius:10px; padding:16px;
    text-align:center; cursor:pointer; transition:all .2s; background:#fafafa;
}
.upload-zone:hover { border-color:#4e73df; background:#f0f4ff; }
.upload-zone .upload-icon { font-size:28px; color:#a0aec0; }
.upload-zone small { display:block; color:#718096; margin-top:4px; font-size:12px; }
.upload-zone input[type=file] { display:none; }

/* ─── Misc ──────────────────────────────────── */
.flatpickr-input[readonly] { background:#fff; }
.form-label { font-weight:600; font-size:13px; color:#374151; margin-bottom:6px; }
.form-control, .form-select { border-radius:8px; font-size:14px; }
.form-control:focus { border-color:#4e73df; box-shadow:0 0 0 3px rgba(78,115,223,.12); }
.required { color:#e53e3e; }
</style>
@endpush

@section('content')
<div class="container-fluid pb-5">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Add New Tour</h4>
            <small class="text-muted">Fill in all required fields to publish a new tour.</small>
        </div>
        <a href="{{ route('tours.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back to Tours
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
        <strong><i class="fa fa-exclamation-triangle me-2"></i>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('tours.store') }}" enctype="multipart/form-data" onkeydown="return event.key !== 'Enter';">
        @csrf

        {{-- ═══════════════════════════════════════════════
             SECTION 1 · BASIC INFORMATION
        ═══════════════════════════════════════════════ --}}
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="form-section-header">
                    <i class="fa fa-info-circle"></i>
                    <h6>Basic Information</h6>
                </div>

                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Tour Title</label>
                        <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                               placeholder="e.g. Manali Winter Trek" value="{{ old('title') }}">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}"
                               placeholder="e.g. Manali, Himachal Pradesh" value="{{ old('location') }}">
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Language</label>
                        <input type="text" name="language" class="form-control {{ $errors->has('language') ? 'is-invalid' : '' }}"
                               placeholder="e.g. Hindi, English" value="{{ old('language') }}">
                        @error('language')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Destination</label>
                        <select id="category" name="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                            <option value="">Select Destination</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Travel Type</label>
                        <select id="subcategory" name="subcategory_id" class="form-control {{ $errors->has('subcategory_id') ? 'is-invalid' : '' }}">
                            <option value="">Select Travel Type</option>
                        </select>
                        @error('subcategory_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tour Duration</label>
                        <input type="text" name="tour_duration" class="form-control {{ $errors->has('tour_duration') ? 'is-invalid' : '' }}"
                               placeholder="e.g. 3 Days / 2 Nights" value="{{ old('tour_duration') }}">
                        @error('tour_duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Star Rating</label>
                        <select name="star_rating" class="form-control {{ $errors->has('star_rating') ? 'is-invalid' : '' }}">
                            <option value="">Select</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('star_rating') == $i ? 'selected' : '' }}>{{ $i }} ★</option>
                            @endfor
                        </select>
                        @error('star_rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', 1) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="status">Publish Tour</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             SECTION 2 · MEDIA
        ═══════════════════════════════════════════════ --}}
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="form-section-header">
                    <i class="fa fa-images"></i>
                    <h6>Media & Documents</h6>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Main Cover Image</label>
                        <label class="upload-zone w-100" for="mainImageInput">
                            <div class="upload-icon">🖼️</div>
                            <div class="fw-semibold mt-1" style="font-size:13px;">Click to upload</div>
                            <small>JPG, PNG, WEBP up to 2MB</small>
                            <input type="file" id="mainImageInput" name="image" accept="image/*"
                                   onchange="showFileName(this, 'mainImageLabel')">
                        </label>
                        <small id="mainImageLabel" class="text-muted d-block mt-1"></small>
                        @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Gallery Images <span class="text-muted fw-normal">(optional)</span></label>
                        <label class="upload-zone w-100" for="galleryInput">
                            <div class="upload-icon">📸</div>
                            <div class="fw-semibold mt-1" style="font-size:13px;">Select multiple</div>
                            <small>JPG, PNG, WEBP — multiple allowed</small>
                            <input type="file" id="galleryInput" name="gallery_images[]" accept="image/*" multiple
                                   onchange="showFileName(this, 'galleryLabel')">
                        </label>
                        <small id="galleryLabel" class="text-muted d-block mt-1"></small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tour Brochure PDF <span class="text-muted fw-normal">(optional)</span></label>
                        <label class="upload-zone w-100" for="pdfInput">
                            <div class="upload-icon">📄</div>
                            <div class="fw-semibold mt-1" style="font-size:13px;">Upload PDF</div>
                            <small>PDF up to 5MB</small>
                            <input type="file" id="pdfInput" name="pdf" accept=".pdf"
                                   onchange="showFileName(this, 'pdfLabel')">
                        </label>
                        <small id="pdfLabel" class="text-muted d-block mt-1"></small>
                        @error('pdf')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             SECTION 3 · PRICING
        ═══════════════════════════════════════════════ --}}
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="form-section-header">
                    <i class="fa fa-tag"></i>
                    <h6>Pricing</h6>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Price Per Person</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" step="0.01" name="price" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                   placeholder="e.g. 2999" value="{{ old('price') }}">
                        </div>
                        <small class="text-muted">Fixed price. GST applied globally from Settings.</small>
                        @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Special Discount (%)</label>
                        <div class="input-group">
                            <input type="number" name="special_discount" class="form-control {{ $errors->has('special_discount') ? 'is-invalid' : '' }}"
                                   value="{{ old('special_discount', 0) }}" min="0" max="100">
                            <span class="input-group-text">%</span>
                        </div>
                        @error('special_discount')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="status_discount" name="status_discount" value="1">
                            <label class="form-check-label fw-semibold" for="status_discount">Enable Discount</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             SECTION 4 · TOUR DETAILS
        ═══════════════════════════════════════════════ --}}
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="form-section-header">
                    <i class="fa fa-compass"></i>
                    <h6>Tour Details</h6>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Max Group Size</label>
                        <input type="number" name="max_people" class="form-control {{ $errors->has('max_people') ? 'is-invalid' : '' }}"
                               value="{{ old('max_people') }}" min="1" placeholder="e.g. 15">
                        @error('max_people')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Minimum Age</label>
                        <input type="number" name="min_age" class="form-control {{ $errors->has('min_age') ? 'is-invalid' : '' }}"
                               value="{{ old('min_age') }}" min="0" max="120" placeholder="e.g. 10">
                        @error('min_age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Stay Type</label>
                        <input type="text" name="bedroom" class="form-control {{ $errors->has('bedroom') ? 'is-invalid' : '' }}"
                               value="{{ old('bedroom') }}" placeholder="e.g. Camping, Hotel">
                        @error('bedroom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Transportation</label>
                        <input type="text" name="pickup" class="form-control {{ $errors->has('pickup') ? 'is-invalid' : '' }}"
                               value="{{ old('pickup') }}" placeholder="e.g. Bus from Delhi">
                        @error('pickup')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Things to Carry</label>
                        <div class="tags-input" id="daysTags" onclick="document.getElementById('daysInput').focus()">
                            <input type="text" id="daysInput" placeholder="Type item & press Enter…" autocomplete="off">
                        </div>
                        <input type="hidden" name="day" id="daysHidden" value="{{ old('day') }}">
                        <small class="text-muted">e.g. Jacket, Water bottle, Torch</small>
                        @error('day')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">What to Expect</label>
                        <div class="tags-input" id="expectTags" onclick="document.getElementById('expectInput').focus()">
                            <input type="text" id="expectInput" placeholder="Type item & press Enter…" autocomplete="off">
                        </div>
                        <input type="hidden" name="what_to_expect" id="expectHidden" value="{{ old('what_to_expect') }}">
                        <small class="text-muted">e.g. Mountain views, Campfire, Local food</small>
                        @error('what_to_expect')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Inclusions</label>
                        <div class="tags-input" id="tagsInput" onclick="document.getElementById('tagInput').focus()">
                            <input type="text" id="tagInput" placeholder="Type item & press Enter…" autocomplete="off">
                        </div>
                        <input type="hidden" name="price_includes" id="tagsValue" value="{{ old('price_includes') }}">
                        <small class="text-muted">e.g. Breakfast, Guide, Entry fees</small>
                        @error('price_includes')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Exclusions</label>
                        <div class="tags-input" id="departureTags" onclick="document.getElementById('departureInput').focus()">
                            <input type="text" id="departureInput" placeholder="Type item & press Enter…" autocomplete="off">
                        </div>
                        <input type="hidden" name="departure_return_location" id="departureHidden" value="{{ old('departure_return_location') }}">
                        <small class="text-muted">e.g. Flights, Personal expenses</small>
                        @error('departure_return_location')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4"
                                  class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                  placeholder="Detailed tour description…">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             SECTION 5 · AVAILABILITY SCHEDULE
        ═══════════════════════════════════════════════ --}}
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="form-section-header">
                    <i class="fa fa-calendar-alt"></i>
                    <h6>Availability Schedule</h6>
                </div>
                <p class="text-muted mb-4" style="font-size:13px;">
                    Define <strong>when this tour runs</strong>. This directly controls which dates customers can pick on the booking page.
                </p>

                {{-- Schedule Type Selector --}}
                <label class="form-label">Schedule Type</label>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    @php
                        $oldSched = old('schedule_type', 'weekly');
                    @endphp

                    <label class="sched-radio-card {{ $oldSched === 'weekly' ? 'active' : '' }}" for="sched_weekly" style="cursor:pointer;">
                        <input class="form-check-input me-2 mt-1" type="radio" name="schedule_type" id="sched_weekly"
                               value="weekly" {{ $oldSched === 'weekly' ? 'checked' : '' }}
                               onchange="switchSchedule('weekly')">
                        <div>
                            <div class="sched-icon">🗓</div>
                            <div class="sched-title">Weekly</div>
                            <div class="sched-desc">Runs on specific day(s) every week for the next 6 months</div>
                        </div>
                    </label>

                    <label class="sched-radio-card {{ $oldSched === 'specific' ? 'active' : '' }}" for="sched_specific" style="cursor:pointer;">
                        <input class="form-check-input me-2 mt-1" type="radio" name="schedule_type" id="sched_specific"
                               value="specific" {{ $oldSched === 'specific' ? 'checked' : '' }}
                               onchange="switchSchedule('specific')">
                        <div>
                            <div class="sched-icon">📌</div>
                            <div class="sched-title">Specific Dates</div>
                            <div class="sched-desc">Only listed dates are available — great for one-off trips</div>
                        </div>
                    </label>

                    <label class="sched-radio-card {{ $oldSched === 'open' ? 'active' : '' }}" for="sched_open" style="cursor:pointer;">
                        <input class="form-check-input me-2 mt-1" type="radio" name="schedule_type" id="sched_open"
                               value="open" {{ $oldSched === 'open' ? 'checked' : '' }}
                               onchange="switchSchedule('open')">
                        <div>
                            <div class="sched-icon">🌐</div>
                            <div class="sched-title">Open / Flexible</div>
                            <div class="sched-desc">Customer picks any future date — ideal for private/hire tours</div>
                        </div>
                    </label>
                </div>

                {{-- Weekly: Day Badges --}}
                <div id="sched_weekly_opts" class="schedule-opts mb-3">
                    <label class="form-label">Days of the Week</label>
                    @php
                        $dayDefs = [
                            0 => ['abbr'=>'SUN', 'full'=>'Sunday'],
                            1 => ['abbr'=>'MON', 'full'=>'Monday'],
                            2 => ['abbr'=>'TUE', 'full'=>'Tuesday'],
                            3 => ['abbr'=>'WED', 'full'=>'Wednesday'],
                            4 => ['abbr'=>'THU', 'full'=>'Thursday'],
                            5 => ['abbr'=>'FRI', 'full'=>'Friday'],
                            6 => ['abbr'=>'SAT', 'full'=>'Saturday'],
                        ];
                        $oldDays = old('schedule_days', [5]);
                    @endphp
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach($dayDefs as $idx => $info)
                            @php $isChecked = $oldSched === 'weekly' && in_array($idx, (array)$oldDays); @endphp
                            <label class="day-badge {{ $isChecked ? 'checked' : '' }}" for="day_{{ $idx }}" id="badge_{{ $idx }}" onclick="toggleDay({{ $idx }})">
                                <input type="checkbox" name="schedule_days[]" id="day_{{ $idx }}" value="{{ $idx }}"
                                       {{ $isChecked ? 'checked' : '' }}>
                                <span class="day-abbr">{{ $info['abbr'] }}</span>
                                <span class="day-name">{{ $info['full'] }}</span>
                            </label>
                        @endforeach
                    </div>
                    <small class="text-muted mt-2 d-block">
                        The booking calendar will show all matching days for the next 6 months.
                    </small>
                </div>

                {{-- Specific Dates --}}
                <div id="sched_specific_opts" class="schedule-opts mb-3" style="display:none;">
                    <label class="form-label">Select Specific Dates</label>
                    <input type="text" id="specific_dates_picker" class="form-control" placeholder="Click to pick dates…" readonly style="cursor:pointer;">
                    <input type="hidden" name="specific_dates" id="specific_dates_hidden" value="{{ old('specific_dates') }}">
                    <small class="text-muted">Only these exact dates will be selectable on the booking page. Click the calendar to add or remove dates.</small>
                </div>

                {{-- Open --}}
                <div id="sched_open_opts" class="schedule-opts mb-3" style="display:none;">
                    <div class="alert alert-info border-0 rounded-3 mb-0 py-3" style="background:#e8f4fd;">
                        <i class="fa fa-info-circle me-2 text-info"></i>
                        <strong>Open Schedule:</strong> Customers can select any future date on the booking page.
                        You can still use Blocked Dates below to close specific days (e.g. holidays).
                    </div>
                </div>

                {{-- Blocked Dates (universal) --}}
                <hr class="my-4">
                <label class="form-label">🚫 Blocked / Closed Dates <span class="text-muted fw-normal">(optional — applies to all modes)</span></label>
                <input type="text" id="available_dates_picker" class="form-control" placeholder="Click to select dates to block…" readonly style="cursor:pointer;">
                <input type="hidden" name="available_dates" id="available_dates_hidden" value="{{ old('available_dates') }}">
                <small class="text-muted">These dates will be greyed out and unavailable regardless of schedule type. Use for public holidays, tour operator breaks, etc.</small>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             SECTION 6 · TRAVEL PLAN
        ═══════════════════════════════════════════════ --}}
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="form-section-header">
                    <i class="fa fa-route"></i>
                    <h6>Day-by-Day Travel Plan</h6>
                </div>
                <p class="text-muted mb-3" style="font-size:13px;">Add the itinerary for each day. Click <strong>+ Add Day</strong> to expand.</p>

                <div id="qaWrapper">
                    @php 
                        $oldQuestions = old('question', ['']); 
                        $oldAnswers = old('answer', ['']); 
                    @endphp
                    @foreach($oldQuestions as $index => $oldQ)
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-light" style="min-width:70px; font-size:12px;">Day {{ $index + 1 }}</span>
                            <input type="text" name="question[]" class="form-control" placeholder="Day title (e.g. Departure from Delhi)" value="{{ $oldQ }}">
                            <input type="text" name="answer[]" class="form-control" placeholder="Description" value="{{ $oldAnswers[$index] ?? '' }}">
                            @if($index > 0)
                                <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove(); reindexDays();">×</button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addQA()">
                    <i class="fa fa-plus me-1"></i> Add Day
                </button>
                <div id="draft-alert" class="text-success small fw-semibold mt-2" style="display:none;">
                    <i class="fa fa-save me-1"></i> Draft saved locally. <a href="#" onclick="clearDraft(event)" class="text-danger ms-2">Clear Draft</a>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             SUBMIT
        ═══════════════════════════════════════════════ --}}
        <div class="d-flex justify-content-end gap-2 mt-2">
            <a href="{{ route('tours.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="fa fa-check me-2"></i> Publish Tour
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
// ── Category → Subcategory Ajax ─────────────────────────────────────────
$('#category').change(function () {
    let id = $(this).val();
    $('#subcategory').html('<option>Loading…</option>');
    $.get('/admin/get-subcategories/' + id, function (data) {
        $('#subcategory').html('<option value="">Select Travel Type</option>');
        data.forEach(item => {
            const sel = '{{ old("subcategory_id") }}' == item.id ? 'selected' : '';
            $('#subcategory').append(`<option value="${item.id}" ${sel}>${item.name}</option>`);
        });
    });
});

// ── File Name Preview ────────────────────────────────────────────────────
function showFileName(input, labelId) {
    const el = document.getElementById(labelId);
    if (input.files.length > 1) {
        el.textContent = `${input.files.length} files selected`;
    } else if (input.files.length === 1) {
        el.textContent = input.files[0].name;
    }
}

// ── Tag Input ────────────────────────────────────────────────────────────
function initTagInput(inputId, boxId, hiddenId) {
    const input  = document.getElementById(inputId);
    const box    = document.getElementById(boxId);
    const hidden = document.getElementById(hiddenId);
    if (!input || !box || !hidden) return;
    
    let tags = hidden.value ? hidden.value.split(',') : [];

    function renderTags() {
        // Remove existing visual tags
        box.querySelectorAll('.tag').forEach(t => t.remove());
        tags.forEach(val => {
            const tag = document.createElement('span');
            tag.className = 'tag';
            tag.innerHTML = `${val}<span class="remove-tag" data-val="${val}">×</span>`;
            tag.querySelector('.remove-tag').onclick = function () {
                tags = tags.filter(t => t !== this.dataset.val);
                renderTags(); // Re-render to keep DOM clean
            };
            box.insertBefore(tag, input);
        });
        hidden.value = tags.join(',');
        
        // Trigger manual change for draft save observer
        hidden.dispatchEvent(new Event('change', { bubbles: true }));
    }

    // Auto-render any tags from old() or localStorage values on load
    if(tags.length > 0) renderTags();

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const val = input.value.trim().replace(/,$/, '');
            if (!val || tags.includes(val)) { input.value = ''; return; }
            tags.push(val);
            renderTags();
            input.value = '';
        }
    });
}

// ── Schedule Switcher ────────────────────────────────────────────────────
function switchSchedule(type) {
    document.querySelectorAll('.schedule-opts').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.sched-radio-card').forEach(el => el.classList.remove('active'));
    const opt = document.getElementById('sched_' + type + '_opts');
    if (opt) opt.style.display = '';
    const card = document.querySelector(`label[for="sched_${type}"]`);
    if (card) card.classList.add('active');
}
window.switchSchedule = switchSchedule;

// ── Day Badge Toggle ─────────────────────────────────────────────────────
function toggleDay(idx) {
    const cb    = document.getElementById('day_' + idx);
    const badge = document.getElementById('badge_' + idx);
    cb.checked = !cb.checked;
    badge.classList.toggle('checked', cb.checked);
}

// ── Travel Plan ──────────────────────────────────────────────────────────
let dayCount = 1;
function addQA() {
    dayCount++;
    const wrapper = document.getElementById('qaWrapper');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <span class="input-group-text bg-light" style="min-width:70px;font-size:12px;">Day ${dayCount}</span>
        <input type="text" name="question[]" class="form-control" placeholder="Day title">
        <input type="text" name="answer[]" class="form-control" placeholder="Description">
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove(); reindexDays();">×</button>
    `;
    wrapper.appendChild(div);
}

function reindexDays() {
    document.querySelectorAll('#qaWrapper .input-group-text').forEach((el, i) => {
        el.textContent = `Day ${i + 1}`;
    });
    dayCount = document.querySelectorAll('#qaWrapper .input-group').length;
}

// ── Flatpickr Instances ──────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

    // Schedule type init
    const initialType = document.querySelector('input[name="schedule_type"]:checked')?.value || 'weekly';
    switchSchedule(initialType);

    // Specific dates
    let specificDatesPicker = flatpickr('#specific_dates_picker', {
        mode: 'multiple',
        dateFormat: 'Y-m-d',
        conjunction: ',',
        minDate: 'today',
        defaultDate: document.getElementById('specific_dates_hidden').value
            ? document.getElementById('specific_dates_hidden').value.split(',') : [],
        onChange: (_, dateStr) => { 
            document.getElementById('specific_dates_hidden').value = dateStr;
            document.getElementById('specific_dates_hidden').dispatchEvent(new Event('change', {bubbles:true}));
        }
    });

    // Blocked dates
    let blockedDatesPicker = flatpickr('#available_dates_picker', {
        mode: 'multiple',
        dateFormat: 'Y-m-d',
        conjunction: ',',
        defaultDate: document.getElementById('available_dates_hidden').value
            ? document.getElementById('available_dates_hidden').value.split(',') : [],
        onChange: (_, dateStr) => { 
            document.getElementById('available_dates_hidden').value = dateStr;
            document.getElementById('available_dates_hidden').dispatchEvent(new Event('change', {bubbles:true}));
        }
    });

    // Tag inputs
    initTagInput('daysInput',     'daysTags',     'daysHidden');
    initTagInput('expectInput',   'expectTags',   'expectHidden');
    initTagInput('tagInput',      'tagsInput',    'tagsValue');
    initTagInput('departureInput','departureTags','departureHidden');

    // ── LocalStorage Draft Feature ───────────────────────────────────────────
    const DRAFT_KEY = 'tour_create_draft';
    const form = document.querySelector('form');
    
    // Attempt Draft Restoration (If no validation errors have populated the form)
    if (!document.querySelector('.is-invalid')) {
        const draftStr = localStorage.getItem(DRAFT_KEY);
        if (draftStr) {
            try {
                const draft = JSON.parse(draftStr);
                // Standard Inputs
                ['title', 'location', 'language', 'tour_duration', 'price', 'special_discount', 'max_people', 'min_age', 'bedroom', 'pickup', 'description']
                    .forEach(name => {
                        const el = document.querySelector(`[name="${name}"]`);
                        if (el && draft[name]) el.value = draft[name];
                    });
                
                // Selects
                ['category_id', 'star_rating'].forEach(name => {
                    const el = document.querySelector(`select[name="${name}"]`);
                    if (el && draft[name]) {
                        el.value = draft[name];
                        if(name === 'category_id') $(el).trigger('change'); // trigger subcategory fetch
                    }
                });

                // Checkboxes
                if (draft.status !== undefined) document.getElementById('status').checked = draft.status;
                if (draft.status_discount !== undefined) document.getElementById('status_discount').checked = draft.status_discount;

                // Hidden Tag Fields & Calendars
                ['daysHidden', 'expectHidden', 'tagsValue', 'departureHidden', 'specific_dates_hidden', 'available_dates_hidden']
                    .forEach(id => {
                        const el = document.getElementById(id);
                        if (el && draft[el.name]) el.value = draft[el.name];
                    });
                
                // Travel Plan Restoration
                if (draft.question && draft.answer && draft.question.length > 0) {
                    document.getElementById('qaWrapper').innerHTML = ''; // clear default
                    dayCount = 0;
                    draft.question.forEach((q, i) => {
                        let ans = draft.answer[i] || '';
                        dayCount++;
                        let cancelBtn = i > 0 ? `<button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove(); reindexDays(); saveDraft();">×</button>` : '';
                        
                        document.getElementById('qaWrapper').insertAdjacentHTML('beforeend', `
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light" style="min-width:70px;font-size:12px;">Day ${dayCount}</span>
                                <input type="text" name="question[]" class="form-control" placeholder="Day title" value="${q.replace(/"/g, '&quot;')}">
                                <input type="text" name="answer[]" class="form-control" placeholder="Description" value="${ans.replace(/"/g, '&quot;')}">
                                ${cancelBtn}
                            </div>
                        `);
                    });
                }

                // Re-initialize dynamic GUI elements based on restored hidden values
                initTagInput('daysInput', 'daysTags', 'daysHidden');
                initTagInput('expectInput', 'expectTags', 'expectHidden');
                initTagInput('tagInput', 'tagsInput', 'tagsValue');
                initTagInput('departureInput', 'departureTags', 'departureHidden');
                
                if(draft.specific_dates) specificDatesPicker.setDate(draft.specific_dates.split(','));
                if(draft.available_dates) blockedDatesPicker.setDate(draft.available_dates.split(','));

                // Show Draft Message
                document.getElementById('draft-alert').style.display = 'block';
            } catch (e) {
                console.error("Draft restore error", e);
            }
        }
    }

    // Capture Draft on Change
    window.saveDraft = function() {
        const formData = new FormData(form);
        const draft = {};
        for(let pair of formData.entries()) {
            if(pair[0].endsWith('[]')) {
                let name = pair[0].replace('[]', '');
                if(!draft[name]) draft[name] = [];
                draft[name].push(pair[1]);
            } else {
                if(pair[0] === '_token' || pair[0] === 'image' || pair[0] === 'pdf') continue; // don't track tokens or files
                draft[pair[0]] = pair[1];
            }
        }
        
        draft.status = document.getElementById('status').checked;
        draft.status_discount = document.getElementById('status_discount').checked;
        
        localStorage.setItem(DRAFT_KEY, JSON.stringify(draft));
        document.getElementById('draft-alert').style.display = 'block';
    };

    form.addEventListener('input', saveDraft);
    form.addEventListener('change', saveDraft); // catches selects, checkboxes, hidden inputs

    // Clear Draft Action
    window.clearDraft = function(e) {
        if(e) e.preventDefault();
        localStorage.removeItem(DRAFT_KEY);
        document.getElementById('draft-alert').style.display = 'none';
        if(confirm("Draft cleared. Refresh the page to reset the form?")) {
            window.location.reload();
        }
    };

    // Clean up on successful submission
    form.addEventListener('submit', function() {
        // If file uploads succeed, the redirection happens. We wipe draft to clear the slate.
        localStorage.removeItem(DRAFT_KEY);
    });
});
</script>
@endpush
