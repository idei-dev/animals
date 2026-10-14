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
        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn('species');
            $table->foreignId('species_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->string('species');
            $table->dropForeign(['species_id']);
            $table->dropColumn('species_id');
        });
    }
};
