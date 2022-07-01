<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('complete_name')->after('email')->nullable();
            $table->string('phone_number')->after('complete_name')->nullable();
            $table->string('instagram')->after('phone_number')->nullable();
            $table->string('gender')->after('instagram')->nullable();
            $table->string('main_address')->after('gender')->nullable();
            $table->string('living_address')->after('main_address')->nullable();
            $table->string('place_birth')->after('living_address')->nullable();
            $table->string('city')->after('place_birth')->nullable();
            $table->string('work')->after('city')->nullable();
            $table->string('church_membership')->after('work')->nullable();
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
