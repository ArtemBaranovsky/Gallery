<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\Session;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \yii2mod\user\models\SignupForm */
$this->title = 'Регистрация';
$session = Yii::$app->session;
// $this->title = Yii::t('SignupForm', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?php echo Html::encode($this->title) ?></h1>
    <p><b><?=$session->getFlash('alert') ?><br></b></p>

    <p><?php echo 'Пожалуйста заполните следущие поля для регистрации нового пользователя:'; ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'SignupForm'/*'form-signup'*/]); ?>
            <?php echo $form->field($model, 'username')->textInput() ?>
            <?php echo $form->field($model, 'email')->textInput()  ?>
            <?php echo $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?php echo Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                <?php /*echo Html::submitButton(Yii::t('SignupForm', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button'])*/ ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>