<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsernameToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 64)->unique()->after('name');
//            $table->boolean('is_active')->default(config('setting.status.active'))->after('email');
            $table->string('profile_picture', 64)->nullable()->after('email');
            $table->boolean('gender')->default(config('basic.gender.male'))->comment('0: Male, 1:Female')->after('email');
            $table->string('contact', 16)->nullable()->unique()->after('email');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
