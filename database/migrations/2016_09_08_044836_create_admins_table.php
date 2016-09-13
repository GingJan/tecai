<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function(Blueprint $table) {
            $table->increments('id');
            $table->string('account',31)->unique();
            $table->string('username',31)->unique();
            $table->string('email',31)->unique();
            $table->string('last_login_at', 19)->default('');
            $table->char('last_login_ip',15);
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
        Schema::drop('admins');
    }

}