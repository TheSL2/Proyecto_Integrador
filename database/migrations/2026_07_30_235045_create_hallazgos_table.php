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
        Schema::create('hallazgos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_item_id')->constrained('checklist_items')->onDelete('cascade');
            $table->foreignId('hallazgo_id')->nullable()->constrained('hallazgos')->onDelete('cascade');
            $table->string('titulo');
            $table->enum('tipo', ['No Conformidad Mayor', 'No Conformidad Menor', 'Observacion']);
            $table->text('descripcion');
            $table->date('fecha_notificacion')->nullable();
            $table->enum('estado_notificacion', ['Pendiente', 'Aceptado'])->default('Pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hallazgos');
    }
};
