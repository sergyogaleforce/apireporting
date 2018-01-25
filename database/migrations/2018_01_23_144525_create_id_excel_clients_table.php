<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateIdExcelClientsTable.
 */
class CreateIdExcelClientsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('id_excel_clients', function(Blueprint $table) {
            $table->increments('id');

            $table->string('user_id');
            $table->string('campaign_summary_activity');
            $table->string('campaign_daily_activity');
            $table->string('advertiser_summary_activity');
            $table->string('campaign_status_metrics');
            $table->string('campaign_event_detail');



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
		Schema::drop('id_excel_clients');
	}
}
