<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddForeignKeysToRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ratings', function(Blueprint $table)
		{
			$table->foreign('user_id')->references('id')->on('users')
				->onUpdate('cascade')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ratings', function(Blueprint $table)
		{
			$table->dropForeign('ratings_user_id_foreign');
		});
	}

}
