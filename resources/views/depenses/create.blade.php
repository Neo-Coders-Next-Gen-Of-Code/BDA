@extends('layouts.app')
@section('title', 'Nouvelle dépense')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Nouvelle dépense</h5>
    <a href="{{ route('depenses.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card" style="max-width:480px">
    <div class="card-body p-4">
        <form action="{{ route('depenses.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Établissement</label>
                <select name="n_etab" class="form-select @error('n_etab') is-invalid @enderror" required>
                    <option value="">— Sélectionner —</option>
                    @foreach($etablissements as $etab)
                        <option value="{{ $etab->n_etab }}" {{ old('n_etab') == $etab->n_etab ? 'selected' : '' }}>
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
                       value="{{ old('depense') }}" placeholder="Ex: 500 000" required>
                @error('depense')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Enregistrer
                </button>
                <a href="{{ route('depenses.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
