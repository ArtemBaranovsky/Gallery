<?php
use yii\web\Session;
use yii\widgets\ActiveForm;
use yii\jui\Autocomplete;

$session = Yii::$app->session;


/* @var $this yii\web\View */

$this->title = 'Домашняя страница галереи';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Сайт-галерея</h1>

        <p class="lead">САЙТ НАХОДИТСЯ В РЕЖИМЕ РАЗРАБОТКИ, ТЕСТИРОВАНИЯ И НАПОЛНЕНИЯ.</p>

        <p><a class="btn btn-lg btn-success" href=<?=\yii\helpers\Url::to('/site/getcategories') ?>>Начать</a></p>
    </div>

    <div class="body-content">
      <p><?=$session->getFlash('alert') ?><br></p>
 <? 
		// echo "<pre>"; var_dump(Yii::$app->user->identity); echo "</pre>"; 
	// $model = \app\models\Country::findOne($id);
	$form = ActiveForm::begin();
	// echo $form->field($model, 'username'/* , ['enableAjaxValidation' => true] */);
	// echo $form->field($model, 'name')
	// ->widget(AutoComplete::classname(), [
		// 'clientOptions' => [
			// 'source' => ['USA', 'RUS'],
		// ],
	// ]);
	
	// $model = new \app\models\Country;
	// echo $form->field($model, 'name')->widget(AutoComplete::classname(), [
		// 'clientOptions' => [
			// 'source' => $data,
		// ],
	// ]);
 	// echo Html::dropDownList('list', NULL, $model);
/*	echo $form->field($model, 'country')->dropdownList(
		country::find()
			->select(['name'])
			->indexBy('name')
			// ->column()
		// ['prompt'=>'Select Country']
	); */
	
// echo AutoComplete::widget([
    // 'model' => $model,
    // 'attribute' => 'country',
    // 'clientOptions' => [
        // 'source' => ['USA', 'RUS', 'GONDURAS', 'GONKONG'],
    // ],
// ]);
?>
<?//= $form->field($model, 'name')->textInput() ?>
<?php ActiveForm::end(); ?>
    </div>
</div>
<div>
	<? //var_dump(Yii::$app->user->identity->isAdmin) ?>
	<p>Для просмотра изображений регистрация не требуется.<br></p>
	<p>Для загрузки изображений требуется авторизация.</p>
	
</div>