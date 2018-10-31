<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление пользователями';
$this->params['breadcrumbs'][] = $this->title;
$model=$dataProvider->getModels();
// var_dump(Yii::$app->user->identity->attributes['id'], $model->id); die();
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		// 'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'id',
				 'value' => function ($data) {
                                        return $data[attributes][id];
				 },
			],
            'username',
            'email:email',
			'age',
            // 'password_hash',
            // 'auth_key',
            //'confirmed_at',
            //'unconfirmed_email:email',
            //'blocked_at',
            //'registration_ip',
            //'created_at',
            //'updated_at',
            //'flags',
            //'last_login_at',
            //'status',
			// 'avatar_filename:image',
			[
				'label' => 'Аватарка',
				'format' => 'raw',
				'value' => function($data){
					if (!$data->avatar_filename) return ;
					return Html::img(yii\helpers\Url::toRoute($data->avatar_filename),[
						'alt'=>'yii2 - картинка в gridview',
						'style' => 'width:60px; display: block; margin: auto;'
					]);
				},
			],
            [
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'width:70px;'],
				'template' => '{view} {delete} {update}',
				'controller' => 'user',
				'visibleButtons' => [
					'view' => true,				
					'delete' => function ($model) {
						return \Yii::$app->user->can('UpdatePost') || Yii::$app->user->identity->attributes['id'] == $model->id; },
					'update' => function ($model) {
						return \Yii::$app->user->can('UpdateOwnPost') || Yii::$app->user->identity->attributes['id'] == $model->id; },
				],
			],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
