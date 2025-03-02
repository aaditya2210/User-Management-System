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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('company_name', 150)->after('address')->comment('Company name of the supplier');
            $table->string('gst_number', 20)->nullable()->after('company_name')->comment('GST number of the supplier');
            $table->string('website', 150)->nullable()->after('gst_number')->comment('Website URL of the supplier');
            $table->string('country', 50)->after('website')->comment('Country of the supplier');
            $table->string('state', 50)->after('country')->comment('State of the supplier');
            $table->string('city', 50)->after('state')->comment('City of the supplier');
            $table->string('postal_code', 10)->after('city')->comment('Postal code of the supplier');
            $table->string('contact_person', 100)->nullable()->after('postal_code')->comment('Primary contact person at the supplier');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('contact_person')->comment('Supplier status: active/inactive');
            $table->date('contract_start_date')->nullable()->after('status')->comment('Contract start date');
            $table->date('contract_end_date')->nullable()->after('contract_start_date')->comment('Contract end date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn([
                'company_name', 
                'gst_number', 
                'website', 
                'country', 
                'state', 
                'city', 
                'postal_code', 
                'contact_person', 
                'status', 
                'contract_start_date', 
                'contract_end_date'
            ]);
        });
    }
};
