<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP – Tripigo Tales</title>
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #18a9a1, #0f8f88);
            padding: 16px;
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
            height: auto;
        }

        .login-title {
            margin-bottom: 15px;
            font-weight: 600;
            color: #0f8f88;
            font-size: 1.3rem;
        }

        .instruction-text {
            margin-bottom: 25px;
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            word-break: break-word;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .login-form input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #cfdfe0;
            border-radius: 5px;
            font-size: 18px;
            letter-spacing: 6px;
            text-align: center;
            -webkit-appearance: none;
            appearance: none;
        }

        .login-form input[type="text"]:focus {
            border-color: #18a9a1;
            outline: none;
            box-shadow: 0 0 0 3px rgba(24,169,161,0.15);
        }

        .login-btn {
            width: 100%;
            padding: 13px;
            background: #18a9a1;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.3s;
            font-weight: 600;
            -webkit-tap-highlight-color: transparent;
        }

        .login-btn:hover,
        .login-btn:active {
            background: #0f8f88;
        }

        .resend-box {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .resend-btn {
            background: none;
            border: none;
            color: #f4b400;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            font-size: 14px;
            -webkit-tap-highlight-color: transparent;
        }

        .resend-btn:hover,
        .resend-btn:active {
            text-decoration: underline;
        }

        .error-text {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .success-text {
            color: #28a745;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        /* ── Mobile Styles ─────────────────────────── */
        @media (max-width: 480px) {
            .login-form {
                padding: 30px 20px;
                border-radius: 10px;
            }

            .login-logo img {
                max-width: 180px;
            }

            .login-title {
                font-size: 1.1rem;
            }

            .login-form input[type="text"] {
                font-size: 20px;
                letter-spacing: 8px;
                padding: 14px 8px;
            }

            .login-btn {
                padding: 14px;
                font-size: 16px;
            }
        }

        @media (max-width: 360px) {
            .login-wrapper {
                padding: 12px;
            }

            .login-form {
                padding: 24px 14px;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-container">
        <div class="login-form">
            <!-- Logo -->
            <div class="login-logo">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Tripigo Tales Logo">
            </div>

            <h1 class="login-title">Verify Your Email</h1>
            <p class="instruction-text">
                Please enter the 6-digit OTP sent to <strong><?php echo e($email); ?></strong>.
            </p>

            <form method="POST" action="<?php echo e(url('/user/verify-otp')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="email" value="<?php echo e($email); ?>">

                <div class="form-group">
                    <input
                        type="text"
                        name="otp"
                        placeholder="------"
                        maxlength="6"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        required
                        autofocus
                    >
                    <?php $__errorArgs = ['otp'];
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
                    Verify &amp; Login
                </button>
            </form>

            <div class="resend-box">
                Didn't receive the code?
                <form action="<?php echo e(route('frontend.otp.resend')); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="email" value="<?php echo e($email); ?>">
                    <button type="submit" class="resend-btn">Resend OTP</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<?php /**PATH C:\Omkar Dhamdhere\Tejas Project Frelance\TripigoTales\resources\views/frontend/verify_otp.blade.php ENDPATH**/ ?>