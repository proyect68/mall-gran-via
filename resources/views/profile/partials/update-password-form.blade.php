<section>
    <header class="profile-header">
        <h2>{{ __('Actualizar Contraseña') }}</h2>
        <p>{{ __('Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantenerla segura.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group-custom">
            <label for="update_password_current_password">{{ __('Contraseña Actual') }}</label>
            <div class="password-wrapper">
                <input type="password" id="update_password_current_password" name="current_password" class="form-control-custom @error('current_password', 'updatePassword') error @enderror" autocomplete="current-password">
                <button type="button" class="password-toggle" onclick="togglePassword('update_password_current_password', this)">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
            @error('current_password', 'updatePassword')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group-custom">
            <label for="update_password_password">{{ __('Nueva Contraseña') }}</label>
            <div class="password-wrapper">
                <input type="password" id="update_password_password" name="password" class="form-control-custom @error('password', 'updatePassword') error @enderror" autocomplete="new-password">
                <button type="button" class="password-toggle" onclick="togglePassword('update_password_password', this)">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
            @error('password', 'updatePassword')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group-custom">
            <label for="update_password_password_confirmation">{{ __('Confirmar Contraseña') }}</label>
            <div class="password-wrapper">
                <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-control-custom @error('password_confirmation', 'updatePassword') error @enderror" autocomplete="new-password">
                <button type="button" class="password-toggle" onclick="togglePassword('update_password_password_confirmation', this)">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation', 'updatePassword')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <i class="fas fa-key"></i> {{ __('Guardar Contraseña') }}
            </button>

            @if (session('status') === 'password-updated')
                <span class="status-message">{{ __('Contraseña actualizada.') }}</span>
            @endif
        </div>
    </form>
</section>

<script>
    function togglePassword(inputId, btnElement) {
        const passwordInput = document.getElementById(inputId);
        const passwordVisible = passwordInput.type === 'text';
        passwordInput.type = passwordVisible ? 'password' : 'text';
        btnElement.innerHTML = passwordVisible ? '<i class="fa-regular fa-eye"></i>' : '<i class="fa-regular fa-eye-slash"></i>';
    }
</script>
