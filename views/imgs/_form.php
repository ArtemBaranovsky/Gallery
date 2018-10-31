<html>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $model app\models\sortImg */
/* @var $form yii\widgets\ActiveForm */


/* Yii::$app->view->registerJsFile('//andreyex.ru/wp-content/themes/sunrain/js/cropper/jquery.min.js', [\yii\web\View::POS_HEAD]);
Yii::$app->view->registerJsFile('//andreyex.ru/wp-content/themes/sunrain/js/cropper/bootstrap.min.js', [\yii\web\View::POS_HEAD]);
Yii::$app->view->registerJsFile('//andreyex.ru/wp-content/themes/sunrain/js/cropper/cropper.min.js', [\yii\web\View::POS_HEAD]);
Yii::$app->view->registerJsFile('//andreyex.ru/wp-content/themes/sunrain/js/cropper/main.js', [\yii\web\View::POS_HEAD]);
Yii::$app->view->registerCssFile('//andreyex.ru/wp-content/themes/sunrain/css/cropper/cropper.min.css', [\yii\web\View::POS_HEAD]);
Yii::$app->view->registerCssFile('//andreyex.ru/wp-content/themes/sunrain/css/cropper/main.css', [\yii\web\View::POS_HEAD]);
 */
// Yii::$app->view->registerCssFile('//andreyex.ru/wp-content/themes/sunrain/css/cropper/bootstrap.min.css', [\yii\web\View::POS_HEAD]);
// Yii::$app->view->registerCssFile('//andreyex.ru/wp-content/themes/sunrain/css/cropper/cropper.css', [\yii\web\View::POS_HEAD]);
?>

<body> 
	<div class="sort-img-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => '6', 'maxlength' => true]) ?>
	
    <?//= $form->field($model, 'filepath')->textInput(['maxlength' => true])->fileInput(['multiple' => true]) ?>
	<?= $form->field($model, 'filepath')->fileInput(['multiple' => true]) ?>

	
	
	<div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	</div>
</body>
</html>
<!-- Wrap the image or canvas element with a block element (container) -->

  <!--img id="image" src="/web/uploads/RBAC.jpg"-->

<!--<div class="container" id="crop-avatar"> -->
<!-- Current avatar --> 
<!--<div class="avatar-view" title="Смена аватара"> -->
<!--	<img src="/web/img/placeholder_avatar.png" align="center" alt="Аватар"> -->
<!--</div>-->
<!-- Обрезка --> 
<!--<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1"> -->
<!--<div class="modal-dialog modal-lg"> -->
<!--
	<div class="modal-content"> 
		<form class="avatar-form" action="//andreyex.ru/wp-content/themes/sunrain/crop.php" enctype="multipart/form-data" method="post"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button> 
				<h4 class="modal-title" id="avatar-modal-label">Изменить аватар</h4> 
			</div> 
			<div class="modal-body"> 
				<div class="avatar-body"> 
-->
				<!-- Загрузка изображения и данных --> 
<!--
				<div class="avatar-upload"> 
					<input type="hidden" class="avatar-src" name="avatar_src"> 
					<input type="hidden" class="avatar-data" name="avatar_data"> 
					<label for="avatarInput">Локальная загрузка</label> 
					<input type="file" class="avatar-input" id="avatarInput" name="avatar_file"> 
				</div> 
-->
				<!-- Кадрирование и просмотр --> 
<!--
					<div class="row"> 
						<div class="col-md-9"> 
							<div class="avatar-wrapper">
							</div> 
						</div> 
						<div class="col-md-3"> 
							<div class="avatar-preview preview-lg">
							</div> 
								<div class="avatar-preview preview-md">
								</div> 
								<div class="avatar-preview preview-sm">
								</div> 
							</div> 
						</div> 
						<div class="row avatar-btns"> 
							<div class="col-md-9"> 
								<div class="btn-group"> 
								<button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">Поворот налево</button> 
								<button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-15 град</button> 
								<button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-30 град</button> 
								<button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-45 град</button> 
							</div> 
							<div class="btn-group"> 
								<button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees">Поворот направо</button> 
								<button type="button" class="btn btn-primary" data-method="rotate" data-option="15">15 град</button> 
								<button type="button" class="btn btn-primary" data-method="rotate" data-option="30">30 град</button> 
								<button type="button" class="btn btn-primary" data-method="rotate" data-option="45">45 град</button> 
							</div> 
						</div> 
						<div class="col-md-3"> 
							<button type="submit" class="btn btn-primary btn-block avatar-save">Готово</button> 
						</div> 
					</div> 
-->
<!--
				</div> 
			</div> 
		</form> 
	</div> 
</div> 
</div>
-->
	<!-- /.modal --> 




