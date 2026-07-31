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
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('objetivo')->nullable();
            $table->text('alcance')->nullable(); 
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->foreignId('auditor_lider_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['Borrador', 'Planificada', 'En Ejecución', 'En Revisión', 'Cerrada'])->default('Borrador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};
