<?php $__env->startSection('title', 'Edit Tour'); ?>

<?php $__env->startPush('styles'); ?>
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

/* ─── Image Previews ────────────────────────── */
.img-preview { width:60px; height:60px; object-fit:cover; border-radius:8px; border:2px solid #e2e8f0; }
.upload-zone {
    border:2px dashed #cbd5e0; border-radius:10px; padding:14px;
    text-align:center; cursor:pointer; transition:all .2s; background:#fafafa;
}
.upload-zone:hover { border-color:#4e73df; background:#f0f4ff; }
.upload-zone .upload-icon { font-size:24px; color:#a0aec0; }
.upload-zone small { display:block; color:#718096; margin-top:4px; font-size:12px; }
.upload-zone input[type=file] { display:none; }

/* ─── Misc ──────────────────────────────────── */
.flatpickr-input[readonly] { background:#fff; }
.form-label { font-weight:600; font-size:13px; color:#374151; margin-bottom:6px; }
.form-control, .form-select { border-radius:8px; font-size:14px; }
.form-control:focus { border-color:#4e73df; box-shadow:0 0 0 3px rgba(78,115,223,.12); }
.required { color:#e53e3e; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    /* Pre-compute reusable values */
    $priceIncludes = is_array($tour->price_includes)
        ? implode(',', $tour->price_includes)
        : (string)$tour->price_includes;

    $departures = is_array($tour->departure_return_location)
        ? implode(',', $tour->departure_return_location)
        : (string)$tour->departure_return_location;

    $daysVal = is_array($tour->day)
        ? implode(',', $tour->day)
        : (string)$tour->day;

    $expectVal = is_array($tour->what_to_expect)
        ? implode(',', $tour->what_to_expect)
        : (string)$tour->what_to_expect;

    $plans = is_array($tour->travel_plan)
        ? $tour->travel_plan
        : (json_decode($tour->travel_plan, true) ?? []);

    $schedType   = old('schedule_type', $tour->schedule_type ?? 'weekly');
    $schedDays   = old('schedule_days', $tour->schedule_days ?? [5]);
    $specDatesVal = old('specific_dates',
        is_array($tour->specific_dates ?? null) ? implode(',', $tour->specific_dates) : '');
    $blockedDatesVal = old('available_dates',
        is_array($tour->available_dates ?? null) ? implode(',', $tour->available_dates) : '');
?>

<div class="container-fluid pb-5">

    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Edit Tour</h4>
            <small class="text-muted">Update the tour details below. Fields marked <span class="required">*</span> are required.</small>
        </div>
        <a href="<?php echo e(route('tours.index')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back to Tours
        </a>
    </div>

    
    <?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
        <strong><i class="fa fa-exclamation-triangle me-2"></i>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2 ps-3">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="btn-close" data-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('tours.update', $tour->id)); ?>"
          enctype="multipart/form-data" onkeydown="return event.key !== 'Enter';">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="form-section-header">
                    <i class="fa fa-info-circle"></i>
                    <h6>Basic Information</h6>
                </div>

                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Tour Title <span class="required">*</span></label>
                        <input type="text" name="title" class="form-control <?php echo e($errors->has('title') ? 'is-invalid' : ''); ?>"
                               value="<?php echo e(old('title', $tour->title)); ?>" required>
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Location <span class="required">*</span></label>
                        <input type="text" name="location" class="form-control <?php echo e($errors->has('location') ? 'is-invalid' : ''); ?>"
                               value="<?php echo e(old('location', $tour->location)); ?>" required>
                        <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Language <span class="required">*</span></label>
                        <input type="text" name="language" class="form-control <?php echo e($errors->has('language') ? 'is-invalid' : ''); ?>"
                               value="<?php echo e(old('language', $tour->language)); ?>" required>
                        <?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Destination <span class="required">*</span></label>
                        <select id="category" name="category_id" class="form-control <?php echo e($errors->has('category_id') ? 'is-invalid' : ''); ?>" required>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id', $tour->category_id) == $cat->id ? 'selected' : ''); ?>>
                                    <?php echo e($cat->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Travel Type <span class="required">*</span></label>
                        <select id="subcategory" name="subcategory_id" class="form-control <?php echo e($errors->has('subcategory_id') ? 'is-invalid' : ''); ?>" required>
                            <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sub->id); ?>" <?php echo e(old('subcategory_id', $tour->subcategory_id) == $sub->id ? 'selected' : ''); ?>>
                                    <?php echo e($sub->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['subcategory_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tour Duration <span class="required">*</span></label>
                        <input type="text" name="tour_duration" class="form-control <?php echo e($errors->has('tour_duration') ? 'is-invalid' : ''); ?>"
                               value="<?php echo e(old('tour_duration', $tour->tour_duration)); ?>" placeholder="e.g. 3 Days / 2 Nights" required>
                        <?php $__errorArgs = ['tour_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Star Rating <span class="required">*</span></label>
                        <select name="star_rating" class="form-control <?php echo e($errors->has('star_rating') ? 'is-invalid' : ''); ?>" required>
                            <option value="">Select</option>
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e(old('star_rating', $tour->star_rating) == $i ? 'selected' : ''); ?>><?php echo e($i); ?> ★</option>
                            <?php endfor; ?>
                        </select>
                        <?php $__errorArgs = ['star_rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                                   <?php echo e(old('status', $tour->status) ? 'checked' : ''); ?>>
                            <label class="form-check-label fw-semibold" for="status">Publish Tour</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="form-section-header">
                    <i class="fa fa-images"></i>
                    <h6>Media & Documents</h6>
                </div>

                <div class="row g-3">
                    
                    <div class="col-md-4">
                        <label class="form-label">Main Cover Image</label>
                        <label class="upload-zone w-100 d-block" for="mainImageInput">
                            <div class="upload-icon">🖼️</div>
                            <div class="fw-semibold mt-1" style="font-size:13px;">Click to replace</div>
                            <small>Leave empty to keep current image</small>
                            <input type="file" id="mainImageInput" name="image" accept="image/*"
                                   onchange="showFileName(this, 'mainImageLabel')">
                        </label>
                        <small id="mainImageLabel" class="text-muted d-block mt-1"></small>
                        <?php if(!empty($tour->image)): ?>
                            <div class="mt-2 d-flex align-items-center gap-2">
                                <img src="<?php echo e(asset($tour->image)); ?>" alt="Current" class="img-preview">
                                <small class="text-muted">Current image</small>
                            </div>
                        <?php endif; ?>
                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="col-md-4">
                        <label class="form-label">Gallery Images</label>
                        <label class="upload-zone w-100 d-block" for="galleryInput">
                            <div class="upload-icon">📸</div>
                            <div class="fw-semibold mt-1" style="font-size:13px;">Select multiple</div>
                            <small>Replaces all existing gallery images on save</small>
                            <input type="file" id="galleryInput" name="gallery_images[]" accept="image/*" multiple
                                   onchange="showFileName(this, 'galleryLabel')">
                        </label>
                        <small id="galleryLabel" class="text-muted d-block mt-1"></small>
                        <?php if(!empty($tour->gallery_images) && is_array($tour->gallery_images)): ?>
                            <div class="mt-2 d-flex flex-wrap gap-2">
                                <?php $__currentLoopData = $tour->gallery_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gimg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <img src="<?php echo e(asset($gimg)); ?>" alt="Gallery" class="img-preview">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="col-md-4">
                        <label class="form-label">Tour Brochure PDF</label>
                        <label class="upload-zone w-100 d-block" for="pdfInput">
                            <div class="upload-icon">📄</div>
                            <div class="fw-semibold mt-1" style="font-size:13px;">Upload PDF</div>
                            <small>Leave empty to keep current file</small>
                            <input type="file" id="pdfInput" name="pdf" accept=".pdf"
                                   onchange="showFileName(this, 'pdfLabel')">
                        </label>
                        <small id="pdfLabel" class="text-muted d-block mt-1"></small>
                        <?php if(!empty($tour->pdf)): ?>
                            <small class="text-muted d-block mt-1">
                                📎 Current: <a href="<?php echo e(asset($tour->pdf)); ?>" target="_blank"><?php echo e(basename($tour->pdf)); ?></a>
                            </small>
                        <?php endif; ?>
                        <?php $__errorArgs = ['pdf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="form-section-header">
                    <i class="fa fa-tag"></i>
                    <h6>Pricing</h6>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Price Per Person <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" step="0.01" name="price" class="form-control <?php echo e($errors->has('price') ? 'is-invalid' : ''); ?>"
                                   value="<?php echo e(old('price', $tour->price)); ?>" required>
                        </div>
                        <small class="text-muted">GST is applied globally from Settings.</small>
                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Special Discount (%) <span class="required">*</span></label>
                        <div class="input-group">
                            <input type="number" name="special_discount" class="form-control <?php echo e($errors->has('special_discount') ? 'is-invalid' : ''); ?>"
                                   value="<?php echo e(old('special_discount', $tour->special_discount ?? 0)); ?>" min="0" max="100" required>
                            <span class="input-group-text">%</span>
                        </div>
                        <?php $__errorArgs = ['special_discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="status_discount" name="status_discount" value="1"
                                   <?php echo e(old('status_discount', $tour->status_discount) ? 'checked' : ''); ?>>
                            <label class="form-check-label fw-semibold" for="status_discount">Enable Discount</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="form-section-header">
                    <i class="fa fa-compass"></i>
                    <h6>Tour Details</h6>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Max Group Size <span class="required">*</span></label>
                        <input type="number" name="max_people" class="form-control <?php echo e($errors->has('max_people') ? 'is-invalid' : ''); ?>"
                               value="<?php echo e(old('max_people', $tour->max_people)); ?>" min="1" required>
                        <?php $__errorArgs = ['max_people'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Minimum Age <span class="required">*</span></label>
                        <input type="number" name="min_age" class="form-control <?php echo e($errors->has('min_age') ? 'is-invalid' : ''); ?>"
                               value="<?php echo e(old('min_age', $tour->min_age)); ?>" min="0" max="120" required>
                        <?php $__errorArgs = ['min_age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Stay Type <span class="required">*</span></label>
                        <input type="text" name="bedroom" class="form-control <?php echo e($errors->has('bedroom') ? 'is-invalid' : ''); ?>"
                               value="<?php echo e(old('bedroom', $tour->bedroom)); ?>" required>
                        <?php $__errorArgs = ['bedroom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Transportation <span class="required">*</span></label>
                        <input type="text" name="pickup" class="form-control <?php echo e($errors->has('pickup') ? 'is-invalid' : ''); ?>"
                               value="<?php echo e(old('pickup', $tour->pickup)); ?>" required>
                        <?php $__errorArgs = ['pickup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Things to Carry <span class="required">*</span></label>
                        <div class="tags-input" id="daysTags" onclick="document.getElementById('daysInput').focus()">
                            <input type="text" id="daysInput" placeholder="Type item & press Enter…" autocomplete="off">
                        </div>
                        <input type="hidden" name="day" id="daysHidden" value="<?php echo e($daysVal); ?>">
                        <?php $__errorArgs = ['day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">What to Expect <span class="required">*</span></label>
                        <div class="tags-input" id="expectTags" onclick="document.getElementById('expectInput').focus()">
                            <input type="text" id="expectInput" placeholder="Type item & press Enter…" autocomplete="off">
                        </div>
                        <input type="hidden" name="what_to_expect" id="expectHidden" value="<?php echo e($expectVal); ?>">
                        <?php $__errorArgs = ['what_to_expect'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Inclusions <span class="required">*</span></label>
                        <div class="tags-input" id="tagsInput" onclick="document.getElementById('tagInput').focus()">
                            <input type="text" id="tagInput" placeholder="Type item & press Enter…" autocomplete="off">
                        </div>
                        <input type="hidden" name="price_includes" id="tagsValue" value="<?php echo e($priceIncludes); ?>">
                        <?php $__errorArgs = ['price_includes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Exclusions <span class="required">*</span></label>
                        <div class="tags-input" id="departureTags" onclick="document.getElementById('departureInput').focus()">
                            <input type="text" id="departureInput" placeholder="Type item & press Enter…" autocomplete="off">
                        </div>
                        <input type="hidden" name="departure_return_location" id="departureHidden" value="<?php echo e($departures); ?>">
                        <?php $__errorArgs = ['departure_return_location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description <span class="required">*</span></label>
                        <textarea name="description" rows="4"
                                  class="form-control <?php echo e($errors->has('description') ? 'is-invalid' : ''); ?>"
                                  required><?php echo e(old('description', $tour->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="form-section-header">
                    <i class="fa fa-calendar-alt"></i>
                    <h6>Availability Schedule</h6>
                </div>
                <p class="text-muted mb-4" style="font-size:13px;">
                    Define <strong>when this tour runs</strong>. This directly controls which dates customers can pick on the booking page.
                </p>

                
                <label class="form-label">Schedule Type <span class="required">*</span></label>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <label class="sched-radio-card <?php echo e($schedType === 'weekly' ? 'active' : ''); ?>" for="sched_weekly" style="cursor:pointer;">
                        <input class="form-check-input me-2 mt-1" type="radio" name="schedule_type" id="sched_weekly"
                               value="weekly" <?php echo e($schedType === 'weekly' ? 'checked' : ''); ?>

                               onchange="switchSchedule('weekly')">
                        <div>
                            <div class="sched-icon">🗓</div>
                            <div class="sched-title">Weekly</div>
                            <div class="sched-desc">Runs on specific day(s) every week for the next 6 months</div>
                        </div>
                    </label>

                    <label class="sched-radio-card <?php echo e($schedType === 'specific' ? 'active' : ''); ?>" for="sched_specific" style="cursor:pointer;">
                        <input class="form-check-input me-2 mt-1" type="radio" name="schedule_type" id="sched_specific"
                               value="specific" <?php echo e($schedType === 'specific' ? 'checked' : ''); ?>

                               onchange="switchSchedule('specific')">
                        <div>
                            <div class="sched-icon">📌</div>
                            <div class="sched-title">Specific Dates</div>
                            <div class="sched-desc">Only listed dates are available — great for one-off trips</div>
                        </div>
                    </label>

                    <label class="sched-radio-card <?php echo e($schedType === 'open' ? 'active' : ''); ?>" for="sched_open" style="cursor:pointer;">
                        <input class="form-check-input me-2 mt-1" type="radio" name="schedule_type" id="sched_open"
                               value="open" <?php echo e($schedType === 'open' ? 'checked' : ''); ?>

                               onchange="switchSchedule('open')">
                        <div>
                            <div class="sched-icon">🌐</div>
                            <div class="sched-title">Open / Flexible</div>
                            <div class="sched-desc">Customer picks any future date — ideal for private/hire tours</div>
                        </div>
                    </label>
                </div>

                
                <div id="sched_weekly_opts" class="schedule-opts mb-3">
                    <label class="form-label">Days of the Week <span class="required">*</span></label>
                    <?php
                        $dayDefs = [
                            0 => ['abbr'=>'SUN', 'full'=>'Sunday'],
                            1 => ['abbr'=>'MON', 'full'=>'Monday'],
                            2 => ['abbr'=>'TUE', 'full'=>'Tuesday'],
                            3 => ['abbr'=>'WED', 'full'=>'Wednesday'],
                            4 => ['abbr'=>'THU', 'full'=>'Thursday'],
                            5 => ['abbr'=>'FRI', 'full'=>'Friday'],
                            6 => ['abbr'=>'SAT', 'full'=>'Saturday'],
                        ];
                    ?>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <?php $__currentLoopData = $dayDefs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $isChecked = in_array($idx, (array)$schedDays); ?>
                            <label class="day-badge <?php echo e($isChecked ? 'checked' : ''); ?>" for="day_<?php echo e($idx); ?>" id="badge_<?php echo e($idx); ?>" onclick="toggleDay(<?php echo e($idx); ?>)">
                                <input type="checkbox" name="schedule_days[]" id="day_<?php echo e($idx); ?>" value="<?php echo e($idx); ?>"
                                       <?php echo e($isChecked ? 'checked' : ''); ?>>
                                <span class="day-abbr"><?php echo e($info['abbr']); ?></span>
                                <span class="day-name"><?php echo e($info['full']); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        The booking calendar will show all matching days for the next 6 months.
                    </small>
                </div>

                
                <div id="sched_specific_opts" class="schedule-opts mb-3" style="display:none;">
                    <label class="form-label">Enabled Dates <span class="required">*</span></label>
                    <input type="text" id="specific_dates_picker" class="form-control" placeholder="Click to pick dates…" readonly style="cursor:pointer;">
                    <input type="hidden" name="specific_dates" id="specific_dates_hidden" value="<?php echo e($specDatesVal); ?>">
                    <small class="text-muted">Only these exact dates will be selectable on the booking page.</small>
                </div>

                
                <div id="sched_open_opts" class="schedule-opts mb-3" style="display:none;">
                    <div class="alert alert-info border-0 rounded-3 mb-0 py-3" style="background:#e8f4fd;">
                        <i class="fa fa-info-circle me-2 text-info"></i>
                        <strong>Open Schedule:</strong> Customers can select any future date. Use Blocked Dates below to close specific days.
                    </div>
                </div>

                
                <hr class="my-4">
                <label class="form-label">🚫 Blocked / Closed Dates <span class="text-muted fw-normal">(optional)</span></label>
                <input type="text" id="available_dates_picker" class="form-control" placeholder="Click to select dates to block…" readonly style="cursor:pointer;">
                <input type="hidden" name="available_dates" id="available_dates_hidden" value="<?php echo e($blockedDatesVal); ?>">
                <small class="text-muted">These dates will be greyed out on the booking calendar regardless of schedule type.</small>
            </div>
        </div>

        
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="form-section-header">
                    <i class="fa fa-route"></i>
                    <h6>Day-by-Day Travel Plan</h6>
                </div>

                <div id="qaWrapper">
                    <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-light" style="min-width:70px; font-size:12px;">Day <?php echo e($i + 1); ?></span>
                            <input type="text" name="question[]" class="form-control"
                                   value="<?php echo e($plan['question'] ?? ''); ?>" placeholder="Day title">
                            <input type="text" name="answer[]" class="form-control"
                                   value="<?php echo e($plan['answer'] ?? ''); ?>" placeholder="Description">
                            <?php if($i > 0): ?>
                                <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove(); reindexDays();">×</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-light" style="min-width:70px; font-size:12px;">Day 1</span>
                            <input type="text" name="question[]" class="form-control" placeholder="Day title">
                            <input type="text" name="answer[]" class="form-control" placeholder="Description">
                        </div>
                    <?php endif; ?>
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addQA()">
                    <i class="fa fa-plus me-1"></i> Add Day
                </button>
            </div>
        </div>

        
        <div class="d-flex justify-content-end gap-2 mt-2">
            <a href="<?php echo e(route('tours.index')); ?>" class="btn btn-outline-secondary px-4">Cancel</a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="fa fa-save me-2"></i> Save Changes
            </button>
        </div>

    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
// ── Category → Subcategory Ajax ─────────────────────────────────────────
$('#category').change(function () {
    let id = $(this).val();
    $('#subcategory').html('<option>Loading…</option>');
    $.get('/admin/get-subcategories/' + id, function (data) {
        $('#subcategory').html('<option value="">Select Travel Type</option>');
        const currentSub = '<?php echo e(old("subcategory_id", $tour->subcategory_id)); ?>';
        data.forEach(item => {
            $('#subcategory').append(
                `<option value="${item.id}" ${item.id == currentSub ? 'selected' : ''}>${item.name}</option>`
            );
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

// ── Tag Input (loads existing data) ─────────────────────────────────────
function initTagInput(inputId, boxId, hiddenId) {
    const input  = document.getElementById(inputId);
    const box    = document.getElementById(boxId);
    const hidden = document.getElementById(hiddenId);
    if (!input || !box || !hidden) return;

    let tags = hidden.value ? hidden.value.split(',').map(s => s.trim()).filter(Boolean) : [];

    // Render existing tags
    tags.forEach(val => {
        const tag = makeTag(val, tags, box, input, hidden);
        box.insertBefore(tag, input);
    });

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const val = input.value.trim().replace(/,$/, '');
            if (!val || tags.includes(val)) { input.value = ''; return; }
            tags.push(val);
            box.insertBefore(makeTag(val, tags, box, input, hidden), input);
            hidden.value = tags.join(',');
            input.value = '';
        }
    });
}

function makeTag(val, tags, box, input, hidden) {
    const tag = document.createElement('span');
    tag.className = 'tag';
    tag.innerHTML = `${val}<span class="remove-tag" data-val="${val}">×</span>`;
    tag.querySelector('.remove-tag').onclick = function () {
        const v = this.dataset.val;
        const idx = tags.indexOf(v);
        if (idx > -1) tags.splice(idx, 1);
        tag.remove();
        hidden.value = tags.join(',');
    };
    return tag;
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
function addQA() {
    const wrapper = document.getElementById('qaWrapper');
    const count   = wrapper.querySelectorAll('.input-group').length + 1;
    const div     = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <span class="input-group-text bg-light" style="min-width:70px;font-size:12px;">Day ${count}</span>
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
}

// ── Init all on DOMContentLoaded ─────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

    // Schedule type
    const initialType = document.querySelector('input[name="schedule_type"]:checked')?.value || 'weekly';
    switchSchedule(initialType);

    // Specific dates flatpickr
    flatpickr('#specific_dates_picker', {
        mode: 'multiple',
        dateFormat: 'Y-m-d',
        conjunction: ',',
        defaultDate: document.getElementById('specific_dates_hidden').value
            ? document.getElementById('specific_dates_hidden').value.split(',') : [],
        onChange: (_, dateStr) => { document.getElementById('specific_dates_hidden').value = dateStr; }
    });

    // Blocked dates flatpickr
    flatpickr('#available_dates_picker', {
        mode: 'multiple',
        dateFormat: 'Y-m-d',
        conjunction: ',',
        defaultDate: document.getElementById('available_dates_hidden').value
            ? document.getElementById('available_dates_hidden').value.split(',') : [],
        onChange: (_, dateStr) => { document.getElementById('available_dates_hidden').value = dateStr; }
    });

    // Tag inputs — loads existing data automatically
    initTagInput('daysInput',     'daysTags',     'daysHidden');
    initTagInput('expectInput',   'expectTags',   'expectHidden');
    initTagInput('tagInput',      'tagsInput',    'tagsValue');
    initTagInput('departureInput','departureTags','departureHidden');
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\new travel\resources\views/admin/tours/edit.blade.php ENDPATH**/ ?>