<?php echo $__env->make('frontend.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>
.password-wrapper {
    min-height: calc(100vh - 200px);
    padding: 40px 0;
    background: #f5f5f5;
}

.password-container {
    max-width: 600px;
    margin: 0 auto;
    background: #ffffff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.password-title {
    text-align: center;
    margin-bottom: 30px;
    color: #0f8f88;
    font-size: 28px;
    font-weight: 600;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 500;
    font-size: 14px;
}

.form-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.3s;
}

.form-group input:focus {
    border-color: #18a9a1;
    outline: none;
}

.error-text {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}

.success-message {
    background: #d4edda;
    color: #155724;
    padding: 12px;
    border-radius: 5px;
    margin-bottom: 20px;
    border: 1px solid #c3e6cb;
}

.error-message {
    background: #f8d7da;
    color: #721c24;
    padding: 12px;
    border-radius: 5px;
    margin-bottom: 20px;
    border: 1px solid #f5c6cb;
}

.btn-submit {
    width: 100%;
    padding: 12px;
    background: #18a9a1;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-submit:hover {
    background: #0f8f88;
}

.back-link {
    display: inline-block;
    margin-bottom: 20px;
    color: #18a9a1;
    text-decoration: none;
    font-size: 14px;
}

.back-link:hover {
    text-decoration: underline;
}
</style>

<div class="password-wrapper">
    <div class="password-container">
        <a href="<?php echo e(url('/')); ?>" class="back-link">
            <i class="fa fa-arrow-left"></i> Back to Home
        </a>

        <h2 class="password-title">Change Password</h2>

        <?php if(session('success')): ?>
            <div class="success-message">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="error-message">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('frontend.password.update')); ?>" class="no-prevent-default">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="current_password">Current Password <span style="color: #dc3545;">*</span></label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    required
                >
                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="error-text"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="password">New Password <span style="color: #dc3545;">*</span></label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    minlength="6"
                >
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="error-text"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <small style="color: #666; font-size: 12px; margin-top: 5px; display: block;">
                    Password must be at least 6 characters long.
                </small>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password <span style="color: #dc3545;">*</span></label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    minlength="6"
                >
            </div>

            <button type="submit" class="btn-submit">
                Change Password
            </button>
        </form>
    </div>
</div>

<?php echo $__env->make('frontend.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- *Scripts* -->
<script src="<?php echo e(asset('js/jquery-3.5.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/fontawesome.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/particles.js')); ?>"></script>
<script src="<?php echo e(asset('js/particlerun.js')); ?>"></script>
<script src="<?php echo e(asset('js/plugin.js')); ?>"></script>
<script src="<?php echo e(asset('js/main.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-swiper.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-nav.js')); ?>"></script>
<?php /**PATH C:\travel update website\working\resources\views/frontend/password/change.blade.php ENDPATH**/ ?>