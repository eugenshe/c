<?php
/**
 * @property integer $id
 * @property string $movieId
 * @property string $title
 * @property string $organicTitle
 * @property string $releaseDate
 * @property string $runtime
 * @property string $overview
 * @property string $imgPath
 */
class MovieModel extends CActiveRecord
{
	const IMG_URL         = 'http://image.tmdb.org/t/p/w500';
	const IMG_FOLDER_PATH = 'img';

	public $image;

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
		return 'movies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('title, organicTitle, releaseDate, runtime, overview, movieId, imgPath', 'required'),
				array('image', 'file', 'types' => 'jpg, gif, png', 'on' => 'update'),
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
				'genresAll' => array(self::HAS_MANY, 'MovieGenreModel', 'movieId'),
				'genre' => array(self::HAS_MANY, 'GenreModel', 'genreId', 'through' => 'genresAll'),
		);
	}

	/**
	 *
	 */
	public function afterSave()
	{
		if ($this->isNewRecord) {
			$imgUrl = self::IMG_URL . $this->imgPath;
			$img = file_get_contents($imgUrl);
			file_put_contents($this->getFilePath($this->imgPath), $img);
		}
	}

	/**
	 * @return string
	 */
	public function getGenres()
	{
		$result = [];
		foreach ($this->genre as $genre) {
			$result[] = $genre->name;
		}

		return implode(', ', $result);
	}

	/**
	 * @param string $imgName
	 * @return string
	 */
	public function getFilePath($imgName)
	{
		return self::IMG_FOLDER_PATH . $imgName;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return '/' . $this->getFilePath($this->imgPath);
	}

	/**
	 * @param integer $id
	 */
	public function initMovie($id)
	{
		$data = Yii::app()->mdbApi->movieDetails($id);
		$this->setAttributes(
				[
						'movieId'      => $data['id'],
						'title'        => $data['title'],
						'organicTitle' => $data['original_title'],
						'releaseDate'  => $data['release_date'],
						'runtime'      => $data['runtime'],
						'overview'     => $data['overview'],
						'imgPath'      => $data['poster_path']
				]
		);
		$this->save();

		foreach ($data['genres'] as $genre) {
			$genreExist = GenreModel::model()->findByAttributes(['name' => $genre['name']]);
			if (!$genreExist) {
				$genreModel = new GenreModel();
				$genreModel->setAttributes(['name' => $genre['name']]);
				$genreModel->save();
				$genreId = $genreModel->getId();
			} else {
				$genreId = $genreExist->getId();
			}

			$movieGenre = new MovieGenreModel();
			$movieGenre->setAttributes(['movieId' => $this->id, 'genreId' => $genreId]);
			$movieGenre->save();
		}
	}

	/**
	 * @param string $imgName
	 * @return string
	 */
	public function generateImgName($imgName)
	{
		return '/' . md5($imgName) . '.jpg';
	}
}