<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCampaignEventDetailsTable.
 */
class CreateCampaignEventDetailsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campaign_event_details', function(Blueprint $table) {
            $table->increments('id');
            $table->string('job_id');
            $table->date('report_date');
            $table->dateTime('last_updated');
            $table->string('advertiser_id');
            $table->string('advertiser_name');
            $table->string('advertiser_code');
            $table->string('campaign_id');
            $table->string('campaign_name');
            $table->string('event_type_name');
            $table->string('event_type_id');
            $table->dateTime('event_time');
            $table->string('call_result');
            $table->string('call_target');
            $table->integer('call_duration');//en segundos
            $table->string('universal_ip');
            $table->string('tracking_code');
            $table->string('customer_name');
            $table->integer('customer_phone');
            $table->string('customer_email');
            $table->string('customer_address');
            $table->string('customer_city');
            $table->string('customer_state');
            $table->integer('customer_zip_code');
            $table->string('customer_country');
            $table->string('email_target');
            $table->string('web_event_id');
            $table->string('web_event_name');
            $table->string('web_event_submited');
            $table->string('web_event_url');
            $table->string('web_event_referent_url');
            $table->string('call_recording_url');
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
		Schema::drop('campaign_event_details');
	}
}
