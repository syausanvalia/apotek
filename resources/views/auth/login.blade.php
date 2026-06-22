@extends('layouts.app')

@section('title', 'Login - Apotek App')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4><i class="fas fa-clinic-medical"></i> Login Apotek</h4>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </div>
                </form>

                <hr>

                <div class="text-center">
                    <p class="mb-0">Belum punya akun?</p>
                    <a href="{{ route('signup') }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-user-plus"></i> Daftar sebagai Pelanggan
                    </a>
                </div>

                <div class="mt-3">
                    <small class="text-muted">
                        <strong>Demo Login:</strong><br>
                        Admin: admin@apotek.com / password<br>
                        Apoteker: apoteker@apotek.com / password
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
