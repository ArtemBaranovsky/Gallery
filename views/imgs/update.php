<?php

use yii\helpers\Html;
use yii\web\ForbiddenHttpException;
use yii\base\Model;
// use kartik\detail\DetailView;
use yii\widgets\DetailView;
use app\models;	
use app\models\sortImg;	//
use yii\widgets\ActiveForm;
use yii\web\Session;
use yii\widgets\Pjax;
// use yii\rbac\CheckAccessInterface;

// use yii\web\IdentityInterface;	// delete!!!




/* @var $this yii\web\View */
/* @var $model app\models\sortImg */

$this->title = 'Обновить данные об изображении "'.$model->filepath.'"';
$this->params['breadcrumbs'][] = ['label' => 'Галерея', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
// $session = Yii::$app->session;
?>
<div class="sort-img-update">
<p><?//=$session->getFlash('alert') ?><br></p>
    <h1><?= Html::encode($this->title) ?></h1>
    <!-- правило updatePost принимает модель imgs, где updateOwnPost вызывает правило AuthorRule и запускает метод execute() -->

		<?php //$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
		<?//= $form->field($model, 'imageFile')->fileInput() ?>
		<!--<button>Submit</button>-->
		<?php //ActiveForm::end() ?>

		<?php Pjax::begin(); ?>

	<?  
	if ((Yii::$app->user->can('admin')) or (Yii::$app->user->identity->username == $model[user])) {
		// if (\Yii::$app->user->can('updateOwnPost' , ['imgs' => $model] )) {
	     // echo "<br><pre>"; print_r($model[attributes]); echo "</pre>";
		 echo $this->render('_formEdit', [
	        'model' => $model,
			'data' => $data,
			 // ['description'],
			'attributes' => [
				'user',
				// 'user_id'
				'description',
				'filepath',
				'timecreated',
				[
					'attribute'=>'photo',
					'value'=>Html::encode(Yii::$app->homeUrl.'uploads/'.$model->filepath),
					'format' => ['image',['width'=>'50%'/* ,'height'=>'50%', 'position' => 'relative'*/, 'margin' => 'auto']],
				], 
			],
	    ]); 
			
		} else throw new ForbiddenHttpException('У вас недостаточно прав для выполнения указанного действия'); ?>
    <?php Pjax::end(); ?>
</div>
