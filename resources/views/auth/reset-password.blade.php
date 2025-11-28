<x-guest-layout>
    <div class="login-wrapper">
        <div class="login-card">

            <div class="login-header">
                <h1 class="login-title">Reset Password</h1>
                <p class="login-subtitle">Masukkan password baru Anda</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="login-form">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                            value="{{ old('email', $request->email) }}"
                            class="field-input"
                            placeholder="nama@email.com"
                            required
                            autofocus
                            autocomplete="username">
                    </div>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="password" class="field-label">Password Baru</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.8333 9.16667H4.16666C3.24619 9.16667 2.5 9.91286 2.5 10.8333V16.6667C2.5 17.5871 3.24619 18.3333 4.16666 18.3333H15.8333C16.7538 18.3333 17.5 17.5871 17.5 16.6667V10.8333C17.5 9.91286 16.7538 9.16667 15.8333 9.16667Z" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M5.83334 9.16667V5.83333C5.83334 4.72827 6.27232 3.66847 7.05372 2.88707C7.83512 2.10567 8.89493 1.66667 10 1.66667C11.1051 1.66667 12.1649 2.10567 12.9463 2.88707C13.7277 3.66847 14.1667 4.72827 14.1667 5.83333V9.16667" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="field-input"
                            placeholder="Minimal 8 karakter"
                            required
                            autocomplete="new-password">
                        <button type="button" class="toggle-password" onclick="togglePassword('password')">
                            <svg class="eye-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.833328 10C0.833328 10 4.16666 3.33334 9.99999 3.33334C15.8333 3.33334 19.1667 10 19.1667 10C19.1667 10 15.8333 16.6667 9.99999 16.6667C4.16666 16.6667 0.833328 10 0.833328 10Z" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="password_confirmation" class="field-label">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.8333 9.16667H4.16666C3.24619 9.16667 2.5 9.91286 2.5 10.8333V16.6667C2.5 17.5871 3.24619 18.3333 4.16666 18.3333H15.8333C16.7538 18.3333 17.5 17.5871 17.5 16.6667V10.8333C17.5 9.91286 16.7538 9.16667 15.8333 9.16667Z" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M5.83334 9.16667V5.83333C5.83334 4.72827 6.27232 3.66847 7.05372 2.88707C7.83512 2.10567 8.89493 1.66667 10 1.66667C11.1051 1.66667 12.1649 2.10567 12.9463 2.88707C13.7277 3.66847 14.1667 4.72827 14.1667 5.83333V9.16667" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="field-input"
                            placeholder="Ulangi password"
                            required
                            autocomplete="new-password">
                        <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                            <svg class="eye-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.833328 10C0.833328 10 4.16666 3.33334 9.99999 3.33334C15.8333 3.33334 19.1667 10 19.1667 10C19.1667 10 15.8333 16.6667 9.99999 16.6667C4.16666 16.6667 0.833328 10 0.833328 10Z" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="login-button">
                    Reset Password
                </button>
            </form>

            <div class="register-prompt">
                <span class="prompt-text">Ingat password?</span>
                <a href="{{ route('login') }}" class="register-link">Kembali ke login</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
</x-guest-layout>
