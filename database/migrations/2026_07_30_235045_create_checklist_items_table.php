<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auditoria_id')->constrained('auditorias')->onDelete('cascade');
            $table->foreignId('requisito_iso_id')->constrained('requisitos_iso')->onDelete('cascade');
            $table->enum('estado_cumplimiento', ['Conforme', 'No Conforme Mayor', 'No Conforme Menor', 'Oportunidad de Mejora', 'No Aplicable'])->default('No Aplicable');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_items');
    }
};
