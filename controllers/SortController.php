<?php
namespace app\controllers;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Imgs;
class SortController extends Controller
{
	public function actionSort()
	{
		$query = Imgs::find();
		$pagination = new Pagination([
			'defaultPageSize' => 8,
			'totalCount' => $query->count(),
			]);
		$imgList = $query->orderBy('category')
			->offset($pagination->offset)
			->limit($pagination->limit)
			->all();
		return $this->render('index', [
			'category' => $category,
			'pagination' => $pagination,
			]);
	}
}