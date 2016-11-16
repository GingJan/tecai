<?php

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
        //此表为用户基本信息表，用户的应聘简历信息在另外一张表
		Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('account',31)->unique();
            $table->string('username',31)->unique();//用户名/昵称
            $table->string('realname',7);//用户真实姓名
            $table->string('email',31)->unique()->default('');//->nullable() or ''
            $table->string('phone',11)->index()->default('');//在数据表是index，但是在模型检验时是唯一的
            $table->unsignedTinyInteger('age')->default(0);
            $table->boolean('sex')->default(0);
            $table->unsignedTinyInteger('school_level')->default(0);//学校等级/985 211 一本 ，二本A，二本B，三本/大专
            $table->string('school',31)->default('');
            $table->string('college',31)->default('');
            $table->string('major',15)->default('');//专业
            $table->char('id_card',18)->default('');
            $table->string('native',15)->default('');//籍贯
            $table->string('province', 5)->default('');//省份
            $table->string('city', 7)->default('');//城市
            $table->string('address',31)->default('');//目前住址
            $table->unsignedSmallInteger('wants_job_id')->default(0);//求职意向
            $table->string('wants_job_name',31)->default('');//求职意向名
            $table->string('attachment', 63);//附件
            $table->string('last_login_at', 19)->default('');
            $table->char('last_login_ip',15)->default('');
            $table->timestamps();

            //两种方式建立索引
            //$table->unique(['account','email','phone']);//复合索引，但这里我们并不是想要这种复合索引
//            $table->unique('account');
//            $table->unique('email');
//            $table->unique('phone');
//            $table->unique('username');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
