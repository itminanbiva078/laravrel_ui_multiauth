<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumers', function (Blueprint $table) {
            $table->id();
            $table->string('username',64)->unique();
            $table->string('email',128);
            $table->string('contact',16);
            $table->string('password',64);
            $table->boolean('is_active')->default(0)->comment('0=Inactive,1=active');
            $table->boolean('is_verified')->default(0)->comment('0=NotVerified,1=Verified');
            $table->boolean('is_approved')->default(0)->comment('0=notApproved,1=Approved');
            $table->foreignId('approved_by')->nullable()->comment('last approved by');
            $table->foreignId('created_by')->nullable()->comment('created_by');
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
        Schema::dropIfExists('consumers');
    }
}
