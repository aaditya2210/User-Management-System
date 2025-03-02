<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Creating users table
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('Primary Key: Unique User ID');
            $table->string('first_name', 50)->comment('User first name (Max: 50 chars)');
            $table->string('last_name', 50)->comment('User last name (Max: 50 chars)');
            $table->string('email', 100)->unique()->comment('User email (Unique & Max: 100 chars)');
            $table->string('contact_number', 15)->comment('User contact number (Max: 15 chars)');
            $table->string('postcode', 10)->comment('Postal code (Max: 10 chars)');
            $table->string('password', 255)->comment('User hashed password');
            $table->enum('gender', ['male', 'female'])->comment('Gender: male or female');
            $table->foreignId('state_id')->constrained()->cascadeOnDelete()->comment('Foreign key: State ID');
            $table->foreignId('city_id')->constrained()->cascadeOnDelete()->comment('Foreign key: City ID');
            $table->json('roles')->comment('User roles stored as JSON');
            $table->json('hobbies')->nullable()->comment('User hobbies stored as JSON');
            $table->json('uploaded_files')->nullable()->comment('User uploaded files stored as JSON');
            $table->timestamps();
        });

        // Creating password_reset_tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 100)->primary()->comment('Primary Key: User email');
            $table->string('token', 255)->comment('Password reset token');
            $table->timestamp('created_at')->nullable()->comment('Timestamp of token creation');
        });

        // Creating sessions table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 100)->primary()->comment('Primary Key: Session ID');
            $table->foreignId('user_id')->nullable()->index()->comment('Foreign Key: User ID');
            $table->string('ip_address', 45)->nullable()->comment('User IP address (Max: 45 chars)');
            $table->text('user_agent')->nullable()->comment('User agent details');
            $table->longText('payload')->comment('Session payload data');
            $table->integer('last_activity')->index()->comment('Last activity timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
