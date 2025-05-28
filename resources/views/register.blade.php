@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrasi') }}</div>

                <div class="card-body">
                    <form id="registerForm">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control" name="email" required autocomplete="email">
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                            <div class="invalid-feedback" id="passwordError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">{{ __('Konfirmasi Password') }}</label>
                            <input id="confirm_password" type="password" class="form-control" name="confirm_password" required autocomplete="new-password">
                            <div class="invalid-feedback" id="confirmPasswordError"></div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Daftar') }}
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('login') }}">Sudah punya akun? Login</a>
                        </div>
                    </form>
                    <div id="registerMessage"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        const messageDiv = document.getElementById('registerMessage');

        // Reset error messages
        document.getElementById('emailError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        document.getElementById('confirmPasswordError').textContent = '';

        try {
            const response = await fetch('{{ route("register") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                // Simpan data user di localStorage
                localStorage.setItem('auth_token', result.data.token);
                localStorage.setItem('user_email', result.data.email);
                localStorage.setItem('user_role', result.data.role);
                
                messageDiv.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
                setTimeout(() => {
                    window.location.href = result.redirect;
                }, 1500);
            } else {
                // Tampilkan error validasi
                if (result.errors.email) {
                    document.getElementById('emailError').textContent = result.errors.email[0];
                }
                if (result.errors.password) {
                    document.getElementById('passwordError').textContent = result.errors.password[0];
                }
                if (result.errors.confirm_password) {
                    document.getElementById('confirmPasswordError').textContent = result.errors.confirm_password[0];
                }
                
                messageDiv.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
            }
        } catch (error) {
            console.error('Register error:', error);
            messageDiv.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat registrasi.</div>`;
        }
    });
</script>
@endsection