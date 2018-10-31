<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ImgsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$model=$dataProvider->getModels();
$this->title = 'Редактирование данных об изображениях';
$this->params['breadcrumbs'][] = $this->title;

?>



<div class="sort-img-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php // echo "<pre>"; forEach($model as $key=>$value) {var_dump($value['user_id']);}; echo "</pre>"; ?>

    <p>
        <?= Html::a('Добавить изображения', ['create'], ['class' => 'btn btn-success']) ?>

    </p>
<? //yii\helpers\VarDumper::dump($dataProvider->keys[0],10,true)?>
<? //yii\helpers\VarDumper::dump($model[$dataProvider->keys[0]],10,true)?>
<?=$data?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'category',
            // 'description',
			[
				'attribute' => 'description',
				'headerOptions' => ['style' => 'width:50%'],
				// 'contentOptions' =>['style' => 'width:50%'],
				'content'=>function($data){
					return ($data["description"]);
				}
			],
            'user',
            //'filepath',
            //'timecreated',
			// [
				// 'attribute'=>'Изображение',
				// 'value'=> Html::encode(Yii::$app->homeUrl.'uploads/thumb/'.$data["filepath"]),
/* 				'content'=>function($data){
					return ($data["filepath"]);
				}, */
				// 'format' => ['image',['width'=>'100%'/* ,'height'=>'50%' */]],
			// ],
			[
				'label' => 'Превью изображения',
				'format' => 'raw',
				'value' => function($data){
					if (!$data['filepath']) return ;
					return Html::img(yii\helpers\Url::to(Html::encode(Yii::$app->request->baseUrl.'/web/uploads/thumb/'.$data['filepath'])),[
						'alt'=> 'картинка для превью',
						'style' => 'width:60px; display: block; margin: auto;'
					]);
				},
			],
            [
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'width:70px;'],
				'template' => '{view} {delete} {update}',
				'controller' => 'imgs',
				'visibleButtons' => [
					'view' => true,				
					'delete' => function ($model) {
						return \Yii::$app->user->can('UpdatePost') || Yii::$app->user->identity->attributes['id'] == $model->user_id; },
					'update' => function ($model) {
						return \Yii::$app->user->can('UpdateOwnPost') || Yii::$app->user->identity->attributes['id'] == $model->user_id; },
				],
			],
            // ['class' => 'yii\grid\ActionColumn'],	// выводит кастомные иконки
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
