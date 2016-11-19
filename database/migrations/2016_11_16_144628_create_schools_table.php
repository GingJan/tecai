<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schools', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name',15);
            $table->unsignedTinyInteger('level');//学校等级 985：10，211：20，重本：30，二本：40，三本：50
            $table->string('city',7);//所在城市
            $table->string('address', 15);//详细地址
            $table->string('shortname', 7);//英文/拼音 简写

            $table->engine = 'MyISAM';
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('schools');
	}

}
