<section>
    <header class="profile-header">
        <h2>{{ __('Información del Perfil') }}</h2>
        <p>{{ __("Actualiza la información de tu cuenta y dirección de correo electrónico.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group-custom">
            <label for="name">{{ __('Nombre') }}</label>
            <input type="text" id="name" name="name" class="form-control-custom @error('name') error @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group-custom">
            <label for="apellido_paterno">{{ __('Apellido Paterno') }}</label>
            <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control-custom @error('apellido_paterno') error @enderror" value="{{ old('apellido_paterno', $user->apellido_paterno) }}" required autocomplete="family-name">
            @error('apellido_paterno')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group-custom">
            <label for="apellido_materno">{{ __('Apellido Materno') }}</label>
            <input type="text" id="apellido_materno" name="apellido_materno" class="form-control-custom @error('apellido_materno') error @enderror" value="{{ old('apellido_materno', $user->apellido_materno) }}" required autocomplete="family-name">
            @error('apellido_materno')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group-custom">
            <label for="email">{{ __('Correo Electrónico') }}</label>
            <input type="email" id="email" name="email" class="form-control-custom @error('email') error @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" readonly style="background-color: #f0f1f6; color: #6c7190; cursor: not-allowed;" title="El correo electrónico no se puede modificar">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 10px;">
                    <p style="font-size: 0.9rem; color: #46486b;">
                        {{ __('Tu dirección de correo electrónico no está verificada.') }}

                        <button form="send-verification" style="background: none; border: none; color: #3735af; text-decoration: underline; cursor: pointer; padding: 0; font-size: 0.9rem;">
                            {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="font-size: 0.9rem; color: #248b54; font-weight: 600; margin-top: 8px;">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> {{ __('Guardar') }}
            </button>

            @if (session('status') === 'profile-updated')
                <span class="status-message">{{ __('Guardado.') }}</span>
            @endif
        </div>
    </form>
</section>
