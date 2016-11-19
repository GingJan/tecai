<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
            $table->increments('id');
            $table->string('account',31)->unique();
            $table->string('username',31)->unique();//用户名/昵称
            $table->string('email',31)->unique()->default('');//->nullable() or ''
            $table->string('phone',11)->index()->default('');//在数据表是index，但是在模型检验时是唯一的
            $table->char('id_card',18)->default('');
            $table->unsignedTinyInteger('type')->default(10);//10：普通员工，20：企业法人
            $table->unsignedTinyInteger('status')->default(10);//账号状态，10：待审核，20：正常，30：审核不通过，40：禁止
            $table->string('last_login_at', 19)->default('');
            $table->char('last_login_ip',15)->default('');
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
		Schema::drop('clients');
	}

}
