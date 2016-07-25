<?php

/**
 * @property integer $id
 * @property integer $genreId
 * @property integer $movieId
 */
class MovieGenreModel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return static the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'movie_genre';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('genreId, movieId', 'required')
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'movies' => array(self::BELONGS_TO, 'MovieModel', 'movieId', 'condition'=>'movie_genre.movieId=movie.id'),
				'genre' => array(self::BELONGS_TO, 'GenreModel', 'genreId', 'condition'=>'movie_genre.genreId=genre.id'),
		);
	}

	/**
	 * @param string $id
	 * @throws CDbException
	 */
	public static function deleteMovie($id)
	{
		$movieGenre = MovieGenreModel::model()->findAllByAttributes((['movieId' => $id]));
		if ($movieGenre) {
			foreach ($movieGenre as $item) {
				$item->delete();
			}
		}
	}
}