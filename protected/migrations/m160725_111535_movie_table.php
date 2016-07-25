<?php

class m160725_111535_movie_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('movies', [
				'id' => 'pk',
				'title' => 'string NOT NULL',
				'organicTitle' => 'string NOT NULL',
				'releaseDate' => 'string NOT NULL',
				'runtime' => 'string NOT NULL',
				'movieId' => 'string NOT NULL',
				'imgPath' => 'string NOT NULL',
				'overview' => 'text',
		]);
	}

	public function down()
	{
		$this->dropTable('movies');
		return false;
	}
}