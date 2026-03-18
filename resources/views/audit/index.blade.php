@extends('layouts.app')
@section('title', 'Audit')

@section('content')

{{-- En-tête + stats inline --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h5 class="fw-bold mb-0"><i class="bi bi-clipboard-data me-2 text-primary"></i>Journal d'audit</h5>
    <div class="d-flex gap-2 flex-wrap">
        <span class="badge fs-6 px-3 py-2" style="background:#198754">
            <i class="bi bi-plus-circle me-1"></i>{{ $nbInsertions }} ajout{{ $nbInsertions > 1 ? 's' : '' }}
        </span>
        <span class="badge fs-6 px-3 py-2" style="background:#fd7e14">
            <i class="bi bi-pencil me-1"></i>{{ $nbModifications }} modif.
        </span>
        <span class="badge fs-6 px-3 py-2" style="background:#dc3545">
            <i class="bi bi-trash me-1"></i>{{ $nbSuppressions }} suppr.
        </span>
        <span class="badge fs-6 px-3 py-2 bg-secondary">
            Total : {{ $nbInsertions + $nbModifications + $nbSuppressions }}
        </span>
    </div>
</div>

{{-- Tableau --}}
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0" style="font-size:.88rem">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Date</th>
                        <th>N° Dép.</th>
                        <th>Établissement</th>
                        <th class="text-end">Ancien (Ar)</th>
                        <th class="text-end">Nouveau (Ar)</th>
                        <th>Utilisateur</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($audits as $a)
                    @php
                        $map = [
                            'Ajout'        => ['badge-ajout', 'plus-circle', 'Ajout'],
                            'Modification' => ['badge-modif', 'pencil',      'Modif.'],
                            'Suppression'  => ['badge-suppr', 'trash',       'Suppr.'],
                        ];
                        [$cls, $ico, $lbl] = $map[$a->type_action] ?? ['bg-secondary', 'question', $a->type_action];
                    @endphp
                    <tr>
                        <td>
                            <span class="badge {{ $cls }}">
                                <i class="bi bi-{{ $ico }} me-1"></i>{{ $lbl }}
                            </span>
                        </td>
                        <td class="text-nowrap text-muted">{{ \Carbon\Carbon::parse($a->date_operation)->format('d/m/Y H:i') }}</td>
                        <td>#{{ $a->n_depense }}</td>
                        <td>{{ $a->nom_etab }}</td>
                        <td class="text-end text-muted">{{ number_format($a->ancien_depense, 0, ',', ' ') }}</td>
                        <td class="text-end fw-semibold">{{ number_format($a->nouv_depense, 0, ',', ' ') }}</td>
                        <td class="text-muted"><i class="bi bi-person me-1"></i>{{ $a->utilisateur }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>Aucune opération enregistrée.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
