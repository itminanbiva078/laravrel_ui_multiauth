<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumerUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumer_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumer_id');
            $table->string('name', 128)->nullable();
            $table->string('username', 64)->unique();
            $table->string('email', 128)->nullable();
            $table->string('contact', 16)->nullable();
            $table->string('password', 64);
            $table->boolean('is_active')->default(config('setting.status.active'));
            $table->string('profile_picture', 64)->nullable();
            $table->boolean('gender')->default(config('basic.gender.male'))->comment('0: Male, 1:Female');
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumer_users');
    }
}
