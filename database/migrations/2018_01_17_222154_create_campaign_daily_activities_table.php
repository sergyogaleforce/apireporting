<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCampaignDailyActivitiesTable.
 */
class CreateCampaignDailyActivitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campaign_daily_activities', function(Blueprint $table) {
            $table->increments('id');
            $table->string('job_id');
            $table->dateTime('report_date');
            $table->string('advertiser_id');
            $table->string('advertiser_name');
            $table->string('advertiser_code');
            $table->string('campaign_id');
            $table->string('campaign_name');
            $table->float('campaign_spend');
            $table->float('campaign_adjustment');
            $table->float('campaign_fees');
            $table->integer('visits');
            $table->integer('impressions');
            $table->integer('calls');
            $table->integer('emails');
            $table->integer('coupons');
            $table->integer('web_links');
            $table->integer('web_events');
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
		Schema::drop('campaign_daily_activities');
	}
}
