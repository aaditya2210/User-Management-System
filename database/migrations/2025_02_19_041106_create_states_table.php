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
        Schema::create('states', function (Blueprint $table) {
            $table->id()->comment('Primary key: Unique state ID');
            $table->string('name', 100)->comment('State name (max 100 characters)'); // Optimized size
            $table->timestamps(); // Includes created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
};
