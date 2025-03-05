<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id()->comment('Primary Key: Unique supplier ID');
            $table->string('name',150)->comment('Supplier name');
            $table->string('email', 150)->unique()->comment('Unique email address');
            $table->string('contact_number', 20)->comment('Contact number');
            $table->string('gst_number', 15)->unique()->nullable()->comment('GST Number (if applicable)');
            $table->text('address')->comment('Supplier address');
            $table->string('company_name', 255)->nullable()->comment('Company Name');
            $table->string('website', 255)->nullable()->comment('Company website URL');
            $table->string('country', 100)->comment('Country of supplier');
            $table->string('state', 100)->comment('State of supplier');
            $table->string('city', 100)->comment('City of supplier');
            $table->string('postal_code', 10)->comment('Postal Code');
            $table->string('contact_person', 150)->comment('Primary contact person');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Supplier status');
            $table->date('contract_start_date')->nullable()->comment('Contract start date');
            $table->date('contract_end_date')->nullable()->comment('Contract end date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};
