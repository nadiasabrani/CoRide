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
       Schema::create('trajets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('entreprise_id')->constrained()->cascadeOnDelete();
        $table->string('depart');
        $table->string('destination');
        $table->date('date_depart');
        $table->time('heure_depart');
        $table->decimal('prix', 8, 2);
        $table->integer('places');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trajets');
    }
};
