<?php

class m160725_112651_genre_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('genre', [
				'id' => 'pk',
				'name' => 'string NOT NULL'
		]);
	}

	public function down()
	{
		$this->dropTable('genre');
	}
}