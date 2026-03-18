@extends('layouts.app')
@section('title', 'Modifier dépense')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">
        <i class="bi bi-pencil-square me-2 text-warning"></i>Modifier la dépense
        <span class="text-muted fw-normal">#{{ $depense->n_depense }}</span>
    </h5>
    <a href="{{ route('depenses.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card" style="max-width:480px">
    <div class="card-body p-4">
        <form action="{{ route('depenses.update', $depense->n_depense) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Établissement</label>
                <select name="n_etab" class="form-select @error('n_etab') is-invalid @enderror" required>
                    <option value="">— Sélectionner —</option>
                    @foreach($etablissements as $etab)
                        <option value="{{ $etab->n_etab }}"
                            {{ (old('n_etab', $depense->n_etab) == $etab->n_etab) ? 'selected' : '' }}>
                            {{ $etab->nom }}
                        </option>
                    @endforeach
                </select>
                @error('n_etab')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Montant (Ar)</label>
                <input type="number" step="0.01" name="depense"
                       class="form-control @error('depense') is-invalid @enderror"
                       value="{{ old('depense', $depense->depense) }}" required>
                @error('depense')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save me-1"></i> Mettre à jour
                </button>
                <a href="{{ route('depenses.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
