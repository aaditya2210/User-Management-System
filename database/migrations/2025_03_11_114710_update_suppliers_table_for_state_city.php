<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            // Remove old state and city columns
            $table->dropColumn(['state', 'city']);

            // Add new state_id and city_id columns
            $table->unsignedBigInteger('state_id')->after('country')->nullable()->comment('Foreign Key: References states table');
            $table->unsignedBigInteger('city_id')->after('state_id')->nullable()->comment('Foreign Key: References cities table');

            // Add foreign key constraints
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            // Remove new columns
            $table->dropForeign(['state_id']);
            $table->dropForeign(['city_id']);
            $table->dropColumn(['state_id', 'city_id']);

            // Restore old columns
            $table->string('state', 100)->after('country')->nullable()->comment('State of supplier');
            $table->string('city', 100)->after('state')->nullable()->comment('City of supplier');
        });
    }
};
