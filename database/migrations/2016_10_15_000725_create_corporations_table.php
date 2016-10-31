<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorporationsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('corporations', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('legal_person_id');//法人id
            $table->string('legal_person_name',7);//法人名
            $table->string('name', 15);//企业名
            $table->string('logo_img',127);//logo
            $table->string('city',63);//企业所在城市
            $table->string('address',15);//企业地址
            $table->string('business');//企业经营的服务
            $table->string('tag_name',63)->default('');//标签名
            $table->string('tag_id',63)->default('');//标签id
            $table->string('phone',16)->default('');//企业电话
            $table->string('email',31)->default('');//企业邮箱
            $table->string('official_website', 31)->default('');//官网
            $table->string('intro',1022)->default('');//简介
            $table->string('others',15)->default('');//其他
            $table->string('industry', 15);//行业
            $table->string('financing', 15);//融资,种子轮，天使轮，A，B，C，D，E轮，不需要融资
            $table->string('corporation_type',7);//企业类型：上市企业，大型企业，中小型企业，初创
            $table->boolean('is_listing')->default(0);//是否上市
            $table->boolean('is_authentication')->default(0);//企业是否被认证
            $table->boolean('is_shown')->default(1);//是否显示，由法人/企业员工决定
            $table->unsignedTinyInteger('status')->default(10);//当前状态,10：创建后-待审核，15：修改后-待审核，20：正常/审核通过，30：禁止（从正常转为禁止），40：审核不通过
            $table->unsignedMediumInteger('staff_num');//员工数
            $table->timestamps();

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
		Schema::drop('corporations');
	}

}
