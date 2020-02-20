<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('mobile_no')->unique();
            $table->string('email')->unique();
            $table->integer('allotted_casual_leaves')->nullable();
            $table->integer('allotted_sick_leaves')->nullable();
            $table->integer('allotted_privilage_leaves');
            $table->integer('allowted_leave_without_pay');
            $table->string('password');
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
        Schema::dropIfExists('users');
    }
}
