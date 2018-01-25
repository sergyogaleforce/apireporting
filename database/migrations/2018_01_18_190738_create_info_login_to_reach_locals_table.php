<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateInfoLoginToReachLocalsTable.
 */
class CreateInfoLoginToReachLocalsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('info_login_to_reach_locals', function(Blueprint $table) {
            $table->increments('id');
            $table->string('client_id');
            $table->string('client_secret');
            $table->string('grant_type');
            $table->string('username');
            $table->string('password');
            $table->string('refresh_token');
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
		Schema::drop('info_login_to_reach_locals');
	}
}
