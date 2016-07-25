<?php

class m160725_113015_movie_genre_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('movie_genre', [
				'id' => 'pk',
				'movieId' => 'string NOT NULL',
				'genreId' => 'integer'

		]);
	}

	public function down()
	{
		$this->dropTable('movie_genre');
	}
}