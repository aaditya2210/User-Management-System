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
            $table->string('name', 80)->comment('Full name of the customer'); // Reduced to 80 as names rarely exceed this length
            $table->string('email', 100)->unique()->comment('Unique email address of the customer'); // 100 is sufficient for most emails
            $table->string('contact_number', 15)->comment('Customer contact number'); // 15 supports international formats
            $table->string('address', 200)->comment('Customer address'); // Slightly reduced to 200, still sufficient
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
