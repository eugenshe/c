<?php

use mdbApi\ApiRequest\DiscoverRequest;

/**
 * Class SiteController
 */
class MovieController extends Controller
{
	public $layout='column1';

	/**
	 * @return array
	 */
	public function filters()
	{
		return array('accessControl');
	}

	/**
	 * @return array
	 */
	public function accessRules()
	{
		return array(
				array('deny',
						'users' => array('?'),
				)
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error = Yii::app()->errorHandler->error) {
			if(Yii::app()->request->isAjaxRequest) {
			    echo $error['message'];
			} else {
			    $this->render('error', $error);
			}
		}
	}

	/**
	 * @param null $type
	 */
	public function actionIndex($type = null)
	{
		 if (!$type) {
			$type = DiscoverRequest::DISCOVER_POPULAR;
		 }
		 $data = Yii::app()->mdbApi->discoverMovies($type);
		 $dataProvider = new CArrayDataProvider($data['results'], [
				'pagination' => [
						'pageSize' => 4,
				]
		 ]);

         $this->render('index', [
			'type'         => $type,
			'dataProvider' => $dataProvider
		 ]);
	}

	/**
	 * @param integer $id
	 */
	public function actionView($id)
	{
		$movieModel = MovieModel::model()->findByAttributes(['movieId' => $id]);
		if (!$movieModel) {
			$movieModel = new MovieModel();
			$movieModel->initMovie($id);
		}

		$apiKey = Yii::app()->user->getState('apiKey');
		$ratingModel = RateModel::model()->findByAttributes(['apiKey' => $apiKey, 'movieId' => $id]);
		$rating = 0;
		if ($ratingModel) {
			$rating = $ratingModel->rate;
		}

		$this->render('view', ['model' => $movieModel, 'rating' => $rating]);
	}

	/**
	 * @param integer $id
	 */
	public function actionDelete($id)
	{
		$movieModel = MovieModel::model()->findByAttributes(['movieId' => $id]);
		if ($movieModel) {
			MovieGenreModel::deleteMovie($movieModel->id);
			$movieModel->delete();
		}

		$this->redirect('index');
	}

	/**
	 * @param $id
	 */
	public function actionUpdate($id = null)
	{
		$model = MovieModel::model()->findByAttributes(['movieId' => $id]);
		if (!$model) {
			$model = new MovieModel();
			$model->initMovie($id);
		}

		if(isset($_POST['MovieModel'])) {
			$model->setScenario('update');
			$model->attributes = $_POST['MovieModel'];
			$model->image = CUploadedFile::getInstance($model,'image');
			if($model->save()) {
				$imgPath = $model->generateImgName($model->image->getName());
				$model->image->saveAs('img' . $imgPath);
				$model->setAttribute('imgPath', $imgPath);
				$model->update();

				$this->redirect(['view', 'id' => $model->movieId]);
			}
		}

		$this->render('update', ['model'=>$model]);
	}

	/**
	 * @return array
	 */
	public function actionRate()
	{
		if (!(isset($_POST['rate']) && isset($_POST['movieId']))) {
			return ['error' => true];
		}
		$movieId = $_POST['movieId'];
		$rate = $_POST['rate'];
		$apiKey = Yii::app()->user->getState('apiKey');
		$rating = RateModel::model()->findByAttributes(['apiKey' => $apiKey, 'movieId' =>$movieId]);
		if (!$rating) {
			$rating = new RateModel();
		}
		$rating->setAttributes(['apiKey' => $apiKey, 'movieId' => $movieId, 'rate' => $rate]);
		$rating->save();

		Yii::app()->mdbApi->rateMovie($movieId, $rate);
	}
}
