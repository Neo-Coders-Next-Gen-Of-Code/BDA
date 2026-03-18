<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->increments('n_depense');
            $table->unsignedInteger('n_etab');
            $table->decimal('depense', 15, 2);
            $table->timestamps();

            $table->foreign('n_etab')
                  ->references('n_etab')
                  ->on('etablissements')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('depenses');
    }
};
