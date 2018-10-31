<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\assets\AppAsset;
use yii\web\Session;

/* @var $this yii\web\View */
/* @var $model app\models\User */

// AppAsset::register($this);

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?/*="<pre>"; */ session_cache_limiter("private"); session_start(); //var_dump($_SESSION); echo "</pre>"; // убрать ?></p>
	<p><?// echo "<pre>"; var_dump($_SESSION/*['filename']*/); echo "</pre>"; die();?></p>
	<p><? //echo "<pre>"; var_dump($session->getAllFlashes()); echo "</pre>"; die();?></p>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            // 'password_hash',
            // 'auth_key',
            // 'confirmed_at',
            // 'unconfirmed_email:email',
            // 'blocked_at',
            // 'registration_ip',
            // 'created_at',
            // 'updated_at',
            // 'flags',
            // 'last_login_at',
				[
                        'attribute'=>'Последний вход',
                        'value'=> date( 'D, d M Y H:i:s', $model->last_login_at),
                ], 
            // 'status',
			// 'avatar_filename',
                [
                        'attribute'=>'Аватарка пользователя',
                        // 'value'=>Html::encode(Yii::$app->homeUrl.'user/'./*$model->avatar_filename*/$_SESSION['filename']),
                        'value'=>Html::encode(Yii::$app->homeUrl.'user/'.$model->avatar_filename),
                        'format' => ['image',['width'=>'100','height'=>'100']],
                ], 
        ],
    ]) ?>

</div>
