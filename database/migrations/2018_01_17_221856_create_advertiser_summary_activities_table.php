<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAdvertiserSummaryActivitiesTable.
 */
class CreateAdvertiserSummaryActivitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('advertiser_summary_activities', function(Blueprint $table) {
            $table->increments('id');
            $table->string('job_id');
            $table->string('advertiser_id');
            $table->string('advertiser_name');
            $table->string('advertiser_code');

            $table->float('campaign_spend');
            $table->float('campaign_adjustment');
            $table->float('campaign_fees');
            $table->integer('total_visits');
            $table->integer('total_impressions');
            $table->integer('total_calls');
            $table->integer('total_emails');
            $table->integer('total_coupons');
            $table->integer('total_web_links');
            $table->integer('total_web_events');
            $table->dateTime('last_updated');

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
		Schema::drop('advertiser_summary_activities');
	}
}
