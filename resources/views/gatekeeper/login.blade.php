@extends('layouts.gatekeeper')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="glass-card text-center">
                <div style="width:70px;height:70px;border-radius:50%;background:rgba(212,168,67,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="fas fa-shield-alt" style="font-size:1.8rem;color:var(--gold);"></i>
                </div>
                <h3 style="font-weight:800;">Login Petugas</h3>
                <p style="color:var(--text-secondary);margin-bottom:2rem;">Masuk untuk memvalidasi tiket pengunjung</p>

                @if(session('error'))
                <div class="alert" style="background:rgba(239,68,68,0.15);color:var(--danger);border:1px solid rgba(239,68,68,0.2);border-radius:12px;">
                    {{ session('error') }}
                </div>
                @endif

                <form action="{{ route('gatekeeper.login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3 text-start">
                        <label class="form-label" style="color:var(--text-secondary);font-weight:500;">Username</label>
                        <input type="text" name="username" class="form-control form-control-dark" placeholder="Username" required>
                    </div>
                    <div class="mb-4 text-start">
                        <label class="form-label" style="color:var(--text-secondary);font-weight:500;">Password</label>
                        <input type="password" name="password" class="form-control form-control-dark" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-gold w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection