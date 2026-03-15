<style>
.login-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #18a9a1, #0f8f88);
}

.login-container {
    width: 100%;
    max-width: 420px;
}

.login-form {
    background: #ffffff;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    text-align: center;
}

.login-logo {
    margin-bottom: 20px;
}

.login-logo img {
    max-width: 230px;
    width: 100%;
}

.login-title {
    margin-bottom: 15px;
    font-weight: 600;
    color: #0f8f88;
}

.instruction-text {
    margin-bottom: 25px;
    font-size: 14px;
    color: #666;
}

.form-group {
    margin-bottom: 15px;
}

.login-form input {
    width: 100%;
    padding: 12px;
    border: 1px solid #cfdfe0;
    border-radius: 5px;
    font-size: 14px;
}

.login-form input:focus {
    border-color: #18a9a1;
    outline: none;
}

.login-btn {
    width: 100%;
    padding: 12px;
    background: #18a9a1;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
    font-weight: 600;
}

.login-btn:hover {
    background: #0f8f88;
}

.back-to-login {
    margin-top: 20px;
    font-size: 14px;
}

.back-to-login a {
    color: #f4b400;
    font-weight: 600;
    text-decoration: none;
}

.back-to-login a:hover {
    text-decoration: underline;
}

.error-text {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}

.success-text {
    color: #28a745;
    font-size: 13px;
    margin-top: 5px;
}
</style>

<div class="login-wrapper">
    <div class="login-container">
        <div class="login-form">
            <!-- Logo -->
            <div class="login-logo">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Tripigo Tales Logo">
            </div>

            <h3 class="login-title">Forgot Password</h3>
            <p class="instruction-text">
                Enter your email address and we'll send you a 6-digit code to reset your password.
            </p>

            <form method="POST" action="<?php echo e(route('frontend.password.email')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <input
                        type="email"
                        name="email"
                        placeholder="Email address"
                        required
                        autofocus
                        value="<?php echo e(old('email')); ?>"
                    >
                    <?php $__errorArgs = ['email'];
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

                <?php if(session('error')): ?>
                    <p class="error-text"><?php echo e(session('error')); ?></p>
                <?php endif; ?>
                <?php if(session('success')): ?>
                    <p class="success-text"><?php echo e(session('success')); ?></p>
                <?php endif; ?>

                <button type="submit" class="login-btn">
                    Send Reset Code
                </button>
            </form>

            <div class="back-to-login">
                Remembered your password?
                <a href="<?php echo e(route('frontend.login')); ?>">Back to Login</a>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\travel update website\working\resources\views/frontend/forgot_password.blade.php ENDPATH**/ ?>