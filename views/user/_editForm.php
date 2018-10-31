<html>
<?php
 use yii\helpers\Html;
 use yii\widgets\ActiveForm;
 use yii\web\Session;
 use yii\web\UrlManager;
 use yii\helpers\Url;

?>
<body>  

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'age')->textInput(['maxlength' => true]) ?>

	<img src="<?= $model['oldAttributes']['avatar_filename'] ? 
		yii\helpers\Url::to(Url::home(true).'/web/user/'.$model['oldAttributes']['avatar_filename']) :
		yii\helpers\Url::to(Url::home(true).'/web/img/placeholder_avatar.png') ?>" alt="аватар">
	<?= $form->field($model, 'avatar_filename')->fileInput() ?>
        
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>
<?//= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</body>  
</html>

<div id="uploadimageModal" class="modal" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Загрузить и обрезать изображение</h4>
        </div>
        <div class="modal-body">
          <div class="row">
       <div class="col-md-8 text-center">
        <div id="image_demo" style="width:350px; margin-top:30px"></div>
       </div>
       <div class="col-md-4" style="padding-top:30px;">
        <br />
        <br />
        <br/>
        <button class="btn btn-success crop_image">Загрузить и обрезать</button>
     </div>
    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        </div>
     </div>
    </div>
</div>
<div class="demo"></div>





<script>  
// $(document).ready(function(){
	  // 'use strict';
$('.addfiles').on('click', function() { $('#upload_image').click();return false;});


jQuery(document).ready(function($) {
	// console.log($);
 $image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#user-avatar_filename').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"upload.php",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
          $('#uploaded_image').html(data);
        }
		});
    })
  });
  
  
 
});   
</script>
