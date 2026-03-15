<style>
.login-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #18a9a1, #0f8f88);
}

.login-form {
    width: 100%;
    max-width: 380px;
    background: #ffffff;
    padding: 35px 30px;
    border-radius: 10px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.logo-box {
    text-align: center;
    margin-bottom: 15px;
}

.logo-box img {
    max-width: 160px;
}

.login-title {
    text-align: center;
    margin-bottom: 25px;
    font-weight: 600;
    color: #0f8f88;
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
}

.login-btn:hover {
    background: #0f8f88;
}

.register-text {
    margin-top: 15px;
    text-align: center;
    font-size: 14px;
}

.register-text a {
    color: #f4b400;
    font-weight: 600;
    text-decoration: none;
}

.register-text a:hover {
    text-decoration: underline;
}

.error-text {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}

.login-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #18a9a1, #0f8f88);
    padding: 20px; /* added mobile padding */
}

.login-container {
    width: 100%;
    max-width: 420px;
    margin: 40px auto; /* vertical breathing room */
}

.login-form {
    background: #ffffff;
    padding: 35px 25px; /* slightly tighter on mobile */
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    text-align: center;
}

/* LOGO */
.login-logo {
    margin-bottom: 20px;
}

.login-logo img {
    max-width: 180px; /* Reduced mass size for mobile */
    width: 100%;
    height: auto;
}

/* TITLE */
.login-title {
    margin-bottom: 25px;
    font-weight: 600;
    color: #0f8f88;
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
}

.login-btn:hover {
    background: #0f8f88;
}

.register-text {
    margin-top: 18px;
    font-size: 14px;
}

.register-text a {
    color: #f4b400;
    font-weight: 600;
    text-decoration: none;
}

.register-text a:hover {
    text-decoration: underline;
}

.error-text {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}

</style>
<div class="login-wrapper">
    <form method="POST" action="/user/login" class="login-form">
        <?php echo csrf_field(); ?>

          <!-- Logo -->
        <div class="login-logo">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Travelin Logo">
        </div>

        <div class="form-group">
            <input
                type="email"
                name="email"
                placeholder="Email address"
                value="<?php echo e(old('email')); ?>"
                required
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

        <div class="form-group">
            <input
                type="password"
                name="password"
                placeholder="Password"
                required
            >
            <div style="text-align: right; margin-top: 5px;">
                <a href="<?php echo e(route('frontend.password.request')); ?>" style="font-size: 13px; color: #f4b400; text-decoration: none;">Forgot Password?</a>
            </div>
        </div>

        <?php if(session('error')): ?>
            <p class="error-text"><?php echo e(session('error')); ?></p>
        <?php endif; ?>

        <button type="submit" class="login-btn">
            Login
        </button>

        <div class="form-group" style="margin-top: 15px;">
            <p style="font-size: 13px; color: #666; margin-bottom: 10px;">Or continue with</p>
            <a href="<?php echo e(route('frontend.google.redirect')); ?>" class="google-login-btn" style="display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 12px; background: #fff; color: #333; border: 1px solid #ddd; border-radius: 5px; text-decoration: none; font-size: 14px;">
                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.18 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.15 7.09-10.25 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
                Login with Google
            </a>
        </div>

        <p class="register-text">
            Don’t have an account?
            <a href="<?php echo e(route('frontend.register')); ?>">Register</a>
        </p>
    </form>
</div>
<?php /**PATH C:\new travel\resources\views/frontend/login.blade.php ENDPATH**/ ?>