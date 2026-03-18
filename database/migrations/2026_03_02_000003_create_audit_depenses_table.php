<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_depenses', function (Blueprint $table) {
            $table->id();
            $table->string('type_action', 20); // Ajout, Modification, Suppression
            $table->timestamp('date_operation')->useCurrent();
            $table->unsignedInteger('n_depense');
            $table->string('nom_etab', 100);
            $table->decimal('ancien_depense', 15, 2)->default(0);
            $table->decimal('nouv_depense', 15, 2)->default(0);
            $table->string('utilisateur', 100)->default('system');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_depenses');
    }
};
