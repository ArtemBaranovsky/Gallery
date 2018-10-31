<?php
namespace app\models;

use yii\helpers\Html;
use yii\web\View;
use app\models\User;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\Session;
use app\assets\AppAsset;
use yii;

// Yii::$app->assetManager->bundles['yii\web\JqueryAsset'] = false;
// Yii::$app->assetManager->bundles['yii\web\YiiAsset'] = false;
//Yii::$app->view->registerJsFile('\web\js\jquery.min.js', ['position' => self::POS_HEAD]);
//Yii::$app->view->registerJsFile('\web\js\bootstrap.min.js', ['position' => self::POS_HEAD]);
//Yii::$app->view->registerJsFile('\web\js\croppie.js', ['position' => self::POS_HEAD]);
//Yii::$app->view->registerCssFile('\web\css\bootstrap.min.css', [\yii\web\View::POS_HEAD]);
//Yii::$app->view->registerCssFile('\web\css\croppie.css', [\yii\web\View::POS_HEAD]);
 // Yii::$app->view->registerJsFile('\web\js\jquery.min.js', ['language'=> "JavaScript", 'type'=>"text/javascript", 'position' => \yii\web\View::POS_BEGIN]); 
 Yii::$app->view->registerJsFile('\web\js\bootstrap.min.js', ['language'=> "JavaScript", 'type'=>"text/javascript", 'position' => \yii\web\View::POS_BEGIN]);
 Yii::$app->view->registerCssFile('\web\css\croppie.css', [\yii\web\View::POS_HEAD]);
 Yii::$app->view->registerJsFile('\web\js\croppie.js', ['language'=> "JavaScript", 'type'=>"text/javascript", 'position' => \yii\web\View::POS_END]); 
 // Yii::$app->view->registerCssFile('\web\css\bootstrap.min.css', [\yii\web\View::POS_HEAD]);
 
/* @var $this yii\web\View */
/* @var $model app\models\User */
//$this->beginPage();
Yii::$app->assetManager->bundles = [
				// 'yii\jui\JuiAsset' => [
					// 'css' => [],
				// 'yii\web\JqueryAsset' => [
					// 'js'=>[]
				// ],
				'yii\bootstrap\BootstrapPluginAsset' => [
					'js'=>[]
				],
				// 'yii\bootstrap\BootstrapAsset' => [
					// 'css' => [],
				// ],
    // ],
];



$this->title = 'Редактирование данных пользователя: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$session = Yii::$app->session;
?>
<div class="user-update">
<? session_start(); ?>
<p><?=$session->getFlash('alerts') ?><br></p>
    <h1><?= Html::encode($this->title) ?></h1>

    <? $model->avatar_filename=$_SESSION['filename']; ?>
    <!--$_SESSION['username']= $model->username;-->
    <!--$session->setFlash('username', $model->username); ?>-->
	
    <?=$this->render('_editForm', [
        'model' => $model,
        'data' => $data,
         // ['description'],
        'attributes' => [
                'username',
                'email',
                'age',
				[
                        'attribute'=>'Последний вход',
                        'value'=> date( 'D, d M Y H:i:s', $model->last_login_at),
                ], 
                'avatar_filename',
                [
                        'attribute'=>'photo',
                        'value'=>Html::encode(Yii::$app->homeUrl.'user/'.$model->avatar_filename/*$_SESSION['filename']*/),
                        'format' => ['image',['width'=>'50%','height'=>'100%']],
                ], 
        ],
    ]) ?>
<?//=Html::encode(/*Yii::$app->homeUrl .'user/'. *//*$model->avatar_filename*/$_SESSION['filename']);?>
</div>
<? //$this->endPage(); ?>