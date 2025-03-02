<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id()->comment('Primary key: Unique city ID');
            $table->string('name', 100)->comment('City name (max 100 characters)'); // Optimized size
            $table->foreignId('state_id')
                ->constrained()
                ->cascadeOnDelete()
                ->comment('Foreign key: References states table'); // Ensures referential integrity
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
