<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->id()->comment('Primary Key: Unique ID for role-user mapping');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->comment('Foreign Key: References users table');
            $table->foreignId('role_id')
                ->constrained('roles')
                ->cascadeOnDelete()
                ->comment('Foreign Key: References roles table');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_user');
    }
};
