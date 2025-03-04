<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id()->comment('Primary Key: Unique customer ID');
            $table->string('name', 100)->comment('Full name of the customer');
            $table->string('email', 150)->unique()->comment('Unique email address of the customer');
            $table->string('contact_number', 25)->comment('Customer contact number');
            $table->string('address', 255)->comment('Customer address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
