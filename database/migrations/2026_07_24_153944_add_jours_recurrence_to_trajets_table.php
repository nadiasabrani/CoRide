<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trajets', function (Blueprint $table) {
            // Stocké en JSON : ["lundi","mercredi","vendredi"] ou null si non récurrent
            $table->json('jours_recurrence')->nullable()->after('places');
        });
    }

    public function down(): void
    {
        Schema::table('trajets', function (Blueprint $table) {
            $table->dropColumn('jours_recurrence');
        });
    }
};
