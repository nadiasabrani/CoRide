<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trajet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('passager_id')->constrained('employes')->cascadeOnDelete();
            $table->enum('statut', ['en_attente', 'confirmee', 'refusee', 'annulee'])
                  ->default('en_attente');
            $table->timestamp('date_reservation')->useCurrent();
            $table->timestamps();

            $table->unique(['trajet_id', 'passager_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
