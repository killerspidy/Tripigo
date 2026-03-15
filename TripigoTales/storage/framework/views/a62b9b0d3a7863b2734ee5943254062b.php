<?php $__env->startSection('content'); ?>
<style>
    :root {
        --primary-color: #18a9a1;
        --primary-hover: #138781;
        --bg-color: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
        --input-bg: #f8fafc;
    }

    .auth-section {
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-color);
        padding: 30px 15px;
        min-height: 70vh;
    }

    .auth-card {
        width: 100%;
        max-width: 420px;
        background: var(--card-bg);
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border-color);
    }

    .auth-logo {
        text-align: center;
        margin-bottom: 20px;
    }

    .auth-logo img {
        max-width: 140px;
        height: auto;
    }

    .auth-header {
        text-align: center;
        margin-bottom: 25px;
    }

    .auth-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 8px;
    }

    .auth-subtitle {
        color: var(--text-muted);
        font-size: 14px;
    }

    .auth-form-group {
        margin-bottom: 18px;
    }

    .auth-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 6px;
    }

    .auth-input-wrapper {
        position: relative !important;
        display: block !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .auth-icon {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        bottom: 0 !important;
        width: 45px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        z-index: 10 !important;
        pointer-events: none !important;
        margin: 0 !important;
        padding: 0 !important;
        background: transparent !important;
        border: none !important;
    }

    .auth-icon i {
        color: var(--text-muted) !important;
        font-size: 16px !important;
        transition: color 0.3s ease !important;
        margin: 0 !important;
        padding: 0 !important;
        line-height: 1 !important;
    }

    .auth-input {
        width: 100% !important;
        padding-top: 12px !important;
        padding-bottom: 12px !important;
        padding-right: 16px !important;
        padding-left: 45px !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 10px !important;
        font-size: 14px !important;
        background: var(--input-bg) !important;
        color: var(--text-main) !important;
        transition: all 0.3s ease !important;
        height: 48px !important;
        line-height: normal !important;
        margin-bottom: 0 !important;
        box-shadow: none !important;
    }

    .auth-input:focus {
        background: #ffffff !important;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(24, 169, 161, 0.1) !important;
        outline: none !important;
    }

    .auth-input-wrapper:focus-within .auth-icon i {
        color: var(--primary-color) !important;
    }

    .auth-forgot-link {
        font-size: 12px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .auth-forgot-link:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }

    .auth-btn {
        width: 100%;
        padding: 12px !important;
        background: var(--primary-color) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 10px !important;
        font-size: 15px !important;
        font-weight: 600 !important;
        cursor: pointer;
        transition: all 0.3s ease !important;
        margin-top: 8px;
    }

    .auth-btn:hover {
        background: var(--primary-hover) !important;
    }

    .auth-divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 20px 0;
        color: var(--text-muted);
        font-size: 13px;
        font-weight: 500;
    }

    .auth-divider::before, .auth-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid var(--border-color);
    }

    .auth-divider:not(:empty)::before { margin-right: 15px; }
    .auth-divider:not(:empty)::after { margin-left: 15px; }

    .auth-google-btn {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 10px !important;
        width: 100% !important;
        padding: 12px !important;
        background: #ffffff !important;
        color: var(--text-main) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 10px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
    }

    .auth-google-btn:hover {
        background: #f8fafc !important;
        border-color: #cbd5e0 !important;
    }

    .auth-footer {
        margin-top: 25px;
        text-align: center;
        font-size: 14px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .auth-footer a {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
        margin-left: 4px;
    }

    .auth-footer a:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }

    .auth-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #ef4444;
        padding: 12px 14px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 13px;
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    .auth-field-error {
        color: #ef4444;
        font-size: 12px;
        margin-top: 4px;
        margin-left: 2px;
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    .auth-field-error i {
        font-size: 11px;
        margin-right: 4px;
    }

    @media (max-width: 480px) {
        .auth-card {
            padding: 30px 20px;
            border-radius: 16px;
        }
        .auth-title {
            font-size: 22px;
        }
    }
</style>

<div class="auth-section">
    <div class="auth-card">
        <!-- Logo -->
        <div class="auth-logo">
            <a href="/">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Travelin Logo">
            </a>
        </div>

        <div class="auth-header">
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Please enter your details to sign in</p>
        </div>

        <?php if(session('error')): ?>
            <div class="auth-alert-error">
                <i class="fas fa-exclamation-circle me-2"></i> <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="/user/login">
            <?php echo csrf_field(); ?>

            <div class="auth-form-group">
                <label class="auth-label">Email Address</label>
                <div class="auth-input-wrapper">
                    <span class="auth-icon"><i class="far fa-envelope"></i></span>
                    <input
                        type="email"
                        name="email"
                        class="auth-input"
                        placeholder="name@example.com"
                        value="<?php echo e(old('email')); ?>"
                        required
                        autofocus
                    >
                </div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="auth-field-error"><i class="fas fa-info-circle"></i> <?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="auth-form-group">
                <label class="auth-label">
                    <span>Password</span>
                    <a href="<?php echo e(route('frontend.password.request')); ?>" class="auth-forgot-link">Forgot password?</a>
                </label>
                <div class="auth-input-wrapper">
                    <span class="auth-icon"><i class="fas fa-lock"></i></span>
                    <input
                        type="password"
                        name="password"
                        class="auth-input"
                        placeholder="••••••••"
                        required
                    >
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="auth-field-error"><i class="fas fa-info-circle"></i> <?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit" class="auth-btn">
                Sign In
            </button>

            <div class="auth-divider">or continue with</div>

            <a href="<?php echo e(route('frontend.google.redirect')); ?>" class="auth-google-btn">
                <svg width="22" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-1 .67-2.28 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.66l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Sign In with Google
            </a>
        </form>

        <p class="auth-footer">
            Don't have an account? <a href="<?php echo e(route('frontend.register')); ?>">Create one</a>
        </p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\travel update website\working\resources\views/frontend/login.blade.php ENDPATH**/ ?>