<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddForeignKeysToCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('comments', function(Blueprint $table)
		{
			$table->foreign('product_id')->references('id')->on('products')
				->onUpdate('cascade')->onDelete('cascade');
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
		Schema::table('comments', function(Blueprint $table)
		{
			$table->dropForeign('comments_product_id_foreign');
			$table->dropForeign('comments_user_id_foreign');
		});
	}

}
