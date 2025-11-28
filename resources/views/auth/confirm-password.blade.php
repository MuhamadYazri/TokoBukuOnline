<x-guest-layout>
    <div class="login-wrapper">
        <div class="login-card">

            <div class="login-header">
                <h1 class="login-title">Konfirmasi Password</h1>
                <p class="login-subtitle">Area aman. Silakan konfirmasi password Anda</p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="login-form">
                @csrf

                <div class="form-field">
                    <label for="password" class="field-label">Password</label>
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
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password">
                        <button type="button" class="toggle-password" onclick="togglePassword()">
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

                <button type="submit" class="login-button">
                    Konfirmasi
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
</x-guest-layout>
