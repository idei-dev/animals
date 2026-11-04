<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('animal_events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('animal_id')
                ->constrained('animals')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('event_date');

            $table->enum('event_type', [
                'consulta',
                'vacunación',
                'tratamiento',
                'cirugía',
                'laboratorio',
                'hospitalización',
                'venta',
                'otro',
            ]);

            $table->text('description');

            $table->decimal('amount', 12, 2)
                ->nullable();

            $table->timestamps();

            $table->index(
                ['animal_id', 'event_date'],
                'animal_events_animal_date_index'
            );

            $table->index('event_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animal_events');
    }
};
