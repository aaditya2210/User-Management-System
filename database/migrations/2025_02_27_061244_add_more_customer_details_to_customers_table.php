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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('company_name', 150)->nullable()->after('address')->comment('Company name associated with the customer');
            $table->string('job_title', 100)->nullable()->after('company_name')->comment('Job title of the customer');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('job_title')->comment('Gender of the customer');
            $table->date('date_of_birth')->nullable()->after('gender')->comment('Date of birth of the customer');
            $table->string('nationality', 50)->nullable()->after('date_of_birth')->comment('Nationality of the customer');
            $table->enum('customer_type', ['Regular', 'VIP', 'Corporate'])->nullable()->after('nationality')->comment('Type of customer classification');
            $table->text('notes')->nullable()->after('customer_type')->comment('Additional notes about the customer');
            $table->enum('preferred_contact_method', ['Phone', 'Email', 'SMS'])->nullable()->after('notes')->comment('Preferred method of communication');
            $table->boolean('newsletter_subscription')->default(false)->after('preferred_contact_method')->comment('Indicates if the customer is subscribed to the newsletter');
            $table->decimal('account_balance', 10, 2)->default(0.00)->after('newsletter_subscription')->comment('Customer’s account balance in financial transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'job_title',
                'gender',
                'date_of_birth',
                'nationality',
                'customer_type',
                'notes',
                'preferred_contact_method',
                'newsletter_subscription',
                'account_balance',
            ]);
        });
    }
};
