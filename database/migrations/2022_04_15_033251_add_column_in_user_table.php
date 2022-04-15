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
            $table->string('complete_name')->after('email');
            $table->string('phone_number')->after('complete_name');
            $table->string('instagram')->after('phone_number');
            $table->string('gender')->after('instagram');
            $table->string('main_address')->after('gender');
            $table->string('living_address')->after('main_address');
            $table->string('place_birth')->after('living_address');
            $table->string('city')->after('place_birth');
            $table->string('work')->after('city');
            $table->string('church_membership')->after('work');
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
