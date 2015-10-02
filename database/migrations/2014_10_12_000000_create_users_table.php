<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
		   $table->increments('id');
           $table->string('name');
           $table->string('email');
           $table->boolean('active');
           $table->string('avatar');
           $table->string('provider');
           $table->string('provider_id');
           $table->string('username')->nullable();
		   $table->rememberToken();
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
		Schema::drop('users');
	}

}
