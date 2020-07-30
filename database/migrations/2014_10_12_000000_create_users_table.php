<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user_type')->default(4);
            $table->string('email')->unique();
            $table->string('pro_pic');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('cv')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->string('activation_token');
            $table->boolean('active')->default(false);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
