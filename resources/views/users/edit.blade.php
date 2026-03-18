@extends('layouts.app')
@section('title', 'Modifier le compte')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">
        <i class="bi bi-person-gear me-2 text-warning"></i>Modifier
        <span class="text-muted fw-normal">— {{ $user->name }}</span>
    </h5>
    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card" style="max-width:480px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nom complet</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Rôle</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required
                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    <option value="user"  {{ old('role', $user->role) === 'user'  ? 'selected' : '' }}>Utilisateur</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrateur</option>
                </select>
                @if($user->id === auth()->id())
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <div class="form-text text-warning small"><i class="bi bi-info-circle me-1"></i>Vous ne pouvez pas changer votre propre rôle.</div>
                @endif
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <hr class="my-3">
            <p class="text-muted small mb-2">Laisser vide pour conserver le mot de passe actuel.</p>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nouveau mot de passe</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="min. 6 caractères">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Confirmer</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save me-1"></i> Enregistrer
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
