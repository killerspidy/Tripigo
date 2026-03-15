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
    text-align: left;
}

.form-group label {
    display: block;
    font-size: 13px;
    color: #333;
    margin-bottom: 5px;
    font-weight: 500;
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

.otp-input {
    letter-spacing: 5px;
    text-align: center;
    font-size: 18px !important;
    font-weight: bold;
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
                <img src="{{ asset('images/logo.png') }}" alt="Tripigo Tales Logo">
            </div>

            <h3 class="login-title">Reset Password</h3>
            <p class="instruction-text">
                Enter the 6-digit code sent to <strong>{{ $email }}</strong> and choose a new password.
            </p>

            <form method="POST" action="{{ route('frontend.password.update.otp') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group">
                    <label>Verification Code</label>
                    <input
                        type="text"
                        name="otp"
                        class="otp-input"
                        placeholder="______"
                        maxlength="6"
                        required
                        autofocus
                    >
                    @error('otp')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Min 6 characters"
                        required
                    >
                    @error('password')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Repeat new password"
                        required
                    >
                </div>

                @if(session('error'))
                    <p class="error-text">{{ session('error') }}</p>
                @endif

                <button type="submit" class="login-btn">
                    Update Password
                </button>
            </form>
        </div>
    </div>
</div>
