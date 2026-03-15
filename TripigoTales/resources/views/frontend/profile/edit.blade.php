@include('frontend.partials.header')

<style>
.profile-wrapper {
    min-height: calc(100vh - 200px);
    padding: 40px 20px;
    background: #f5f5f5;
}

.profile-container {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    background: #ffffff;
    padding: 30px 20px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.profile-title {
    text-align: center;
    margin-bottom: 25px;
    color: #0f8f88;
    font-size: 24px;
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

@media (max-width: 575px) {
    .profile-wrapper {
        padding: 20px 15px;
    }
    .profile-container {
        padding: 25px 15px;
    }
    .profile-title {
        font-size: 20px;
    }
}
</style>

<div class="profile-wrapper">
    <div class="profile-container">
        <a href="{{ url('/') }}" class="back-link">
            <i class="fa fa-arrow-left"></i> Back to Home
        </a>

        <h2 class="profile-title">Edit Profile</h2>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('frontend.profile.update') }}" class="no-prevent-default">
            @csrf

            <div class="form-group">
                <label for="name">Name <span style="color: #dc3545;">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                >
                @error('name')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email <span style="color: #dc3545;">*</span></label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                >
                @error('email')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    placeholder="Enter phone number"
                >
                @error('phone')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea
                    id="address"
                    name="address"
                    rows="3"
                    placeholder="Enter your address"
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; transition: border-color 0.3s; resize: vertical;"
                >{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input
                    type="text"
                    id="city"
                    name="city"
                    value="{{ old('city', $user->city) }}"
                    placeholder="Enter city"
                >
                @error('city')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="pincode">Pincode</label>
                <input
                    type="text"
                    id="pincode"
                    name="pincode"
                    value="{{ old('pincode', $user->pincode) }}"
                    placeholder="Enter pincode"
                    maxlength="10"
                >
                @error('pincode')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                Update Profile
            </button>
        </form>
    </div>
</div>

@include('frontend.partials.footer')

<!-- *Scripts* -->
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/fontawesome.min.js') }}"></script>
<script src="{{ asset('js/particles.js') }}"></script>
<script src="{{ asset('js/particlerun.js') }}"></script>
<script src="{{ asset('js/plugin.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/custom-swiper.js') }}"></script>
<script src="{{ asset('js/custom-nav.js') }}"></script>
