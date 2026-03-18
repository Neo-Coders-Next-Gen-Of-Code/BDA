@extends('layouts.app')
@section('title', 'Modifier établissement')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">
        <i class="bi bi-pencil-square me-2 text-warning"></i>Modifier l'établissement
        <span class="text-muted fw-normal">— {{ $etablissement->nom }}</span>
    </h5>
    <a href="{{ route('etablissements.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card" style="max-width:480px">
    <div class="card-body p-4">
        <form action="{{ route('etablissements.update', $etablissement->n_etab) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nom</label>
                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                       value="{{ old('nom', $etablissement->nom) }}" required autofocus>
                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Budget (Ar)</label>
                <input type="number" step="0.01" name="montant_budget"
                       class="form-control @error('montant_budget') is-invalid @enderror"
                       value="{{ old('montant_budget', $etablissement->montant_budget) }}" required>
                @error('montant_budget')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save me-1"></i> Mettre à jour
                </button>
                <a href="{{ route('etablissements.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
