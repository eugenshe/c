<?php

class m160725_112828_rate_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('rate', [
				'id' => 'pk',
				'movieId' => 'string NOT NULL',
				'apiKey' => 'string NOT NULL',
				'rate' => 'integer NOT NULL'
		]);
	}

	public function down()
	{
		$this->dropTable('rate');
	}
}