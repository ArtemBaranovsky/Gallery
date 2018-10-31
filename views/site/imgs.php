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
<? //$categories = categories::find()		//убрать в контроллер
// ->indexBy('name')
// ->orderby(['title'=>SORT_ASC])
//->select(['title as value'/* , 'title as label','id as id' */])		// разобраться
// ->asArray()
// ->all(); ?>

<? //foreach ($categories as $key => $value){
		//$categories['unic'][]=$categories[$key][category]; 
	// var_dump ($categories[$key]['title']);
	// var_dump($value); echo ' ';
		// $catName[]=$categories[$key]['title'];	
// } 
// ECHO implode($catName, '\'\'');
?>
<? //$categories = array_unique($categories['unic'])?>
<? //$categories[] = "yii\helpers\Html::textInput()" ?>
<?
	// $model1= new \app\models\categories;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<?= $form->field($model, 'name')->textInput() ?>
<?	// выводим список автозаполнения категори из БД только администратору !!!
	
	// echo "<pre>"; var_dump($model1); echo "</pre>"; die();
	
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
<?= $form->field($model, 'description')/*->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ])*/ ?>
<?= $form->field($model, 'imageFile')->fileInput(['multiple' => true]) //'imageFile[]' для корректной загрузки файла, необходим параметр формы enctype. Метод fileInput() выведет тег <input type="file"> , позволяющий пользователю выбрать файл для загрузки. ?>

<!--<button>Отправить</button>--><!-- погуглить о стилизации input type file -->
<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
<?/*= Html::tag('div', 'Всё получилось!', $options); */?>
<?php ActiveForm::end() ?>