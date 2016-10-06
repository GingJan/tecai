<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jobs', function(Blueprint $table) {
            $table->increments('id');
            $table->char('job_seq',13)->unique();
            $table->string('name',31);
            $table->unsignedInteger('click')->default(0);
            $table->unsignedInteger('company_id')->index();
            $table->string('company_name',31);
            $table->string('company_logo_url',127);
            $table->unsignedTinyInteger('type');//岗位类型，实习/校招/社招
            $table->string('salary',15);//岗位类型，实习/校招/社招
            $table->string('work_time',7)->default('');
            $table->string('work_city',63);
            $table->unsignedInteger('hr_id');//为发布该岗位的员工
            $table->text('intro')->default('');
            $table->boolean('is_shown')->default(0);
            $table->unsignedTinyInteger('status')->default(10);
            $table->timestamp('from_time');
            $table->timestamp('to_time');
            $table->string('industry',15);
            $table->unsignedInteger('module')->default(0);//岗位介绍等模块的id
            $table->timestamps();//created_at updated_at
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('jobs');
	}

}
