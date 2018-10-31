<?php

// use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
// use common\components\Helper;
use yii\helpers\Url;
use yii\web\Session;
use yii\jui\Autocomplete;
use app\models\categories;
use yii\web\JsExpression;

use yii\db\ActiveRecord;
use app\assets\AppAsset;
use yii\web\Request;
use yii\web\View;
use app\models\imgs;
use app\controllers\imgsController;
use yii\base\Component;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
$session = Yii::$app->session;
$category = $categories['category'];
$items = $categories['items'];
?>


<p><?=$session->getFlash('alert') ?><br></p>
<h3>Загрузка изображений</h3>
<br>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<?= $form->field($model, 'name')->textInput() ?>
<?	// выводим список автозаполнения категори из БД только администратору !!!
	
	if ($userRole=="admin") { 
		echo $form->field($model, 'category')->widget(\yii\jui\AutoComplete::classname(), [
			'clientOptions' => [
				'source' => $model1,
				'minLength'=>'1', 
				'autoFill'=>true,
			],
		])->label('Категория')->textInput();
	}
	else echo $form->field($model, 'category')->dropDownList($data/*, ['prompt'=>'разное']*/); 		// 	выпадающий список для авторов	?> 

<?= $form->field($model, 'description')->textarea(['rows' => '6', 'maxlength' => true]) ?>

<?= $form->field($model, 'imageFile')->fileInput(['multiple' => true]) //'imageFile[]' для корректной загрузки файла, необходим параметр формы enctype. Метод fileInput() выведет тег <input type="file"> , позволяющий пользователю выбрать файл для загрузки. ?>

<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
<?/*= Html::tag('div', 'Всё получилось!', $options); */?>
<?php ActiveForm::end() ?>