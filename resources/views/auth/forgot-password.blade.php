<x-guest-layout>
    <div class="login-wrapper">
        <div class="login-card">

            <div class="login-header">
                <h1 class="login-title">Lupa Password?</h1>
                <p class="login-subtitle">Masukkan email Anda untuk reset password</p>
            </div>

            <form method="POST" action="{{ route('password.email') }}" class="login-form">
                @csrf

                <div class="form-field">
                    <label for="email" class="field-label">Email</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.33333 3.33334H16.6667C17.5833 3.33334 18.3333 4.08334 18.3333 5.00001V15C18.3333 15.9167 17.5833 16.6667 16.6667 16.6667H3.33333C2.41666 16.6667 1.66666 15.9167 1.66666 15V5.00001C1.66666 4.08334 2.41666 3.33334 3.33333 3.33334Z" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18.3333 5L9.99999 10.8333L1.66666 5" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="field-input"
                            placeholder="nama@email.com"
                            required
                            autofocus>
                    </div>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="login-button">
                    Kirim Link Reset Password
                </button>
            </form>

            <div class="register-prompt">
                <span class="prompt-text">Ingat password?</span>
                <a href="{{ route('login') }}" class="register-link">Kembali ke login</a>
            </div>
        </div>
    </div>
</x-guest-layout>
