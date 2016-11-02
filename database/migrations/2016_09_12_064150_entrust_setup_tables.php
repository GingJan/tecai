<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 31)->unique();
            $table->string('display_name', 63)->nullable()->default('');
            $table->string('description', 255)->nullable()->default('');
            $table->timestamps();

        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('account_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->primary(['account_id', 'role_id']);

        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 31)->unique();
            $table->string('verb',10);//对应资源的动作GET、POST、PUT/PATCH、DELETE
            $table->string('uri', 255);//对应资源的uri
            $table->unsignedTinyInteger('type');//私有，角色，公有
            $table->boolean('status')->default(0);//该 资源/权限 是否暂时关闭访问
            $table->string('display_name', 63)->default('');
            $table->string('description', 255)->default('');
            $table->timestamps();

            $table->unique(['verb', 'uri'], 'verb_uri_unique');
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->integer('permission_id')->unsigned();

            $table->primary(['permission_id', 'role_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('role_user');
        Schema::drop('roles');
    }
}
