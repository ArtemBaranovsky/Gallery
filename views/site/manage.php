<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Управление';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-manage">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Эта страница прдназначена для управления контентом галлереи.
        </div>

        <p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <? /*$=form->field($model, 'email')*/ ?>

                    <?= $form->field($model, 'category') ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
					
					<? // поддерживает загрузку нескольких файлов: ?>
					<?= $form->field($model, 'uploadFile[]')->fileInput(['multiple'=>'multiple']) ?>
					<!--// поддерживает выбор нескольких значений: >>
					<?= $form->field($model, 'items[]')->checkboxList(['1' => 'Визитка', '2' => 'Лендинг', '3' => 'Блог']) ?>

                    <?//=$form->field($model, 'verifyCode')->widget(Captcha::className(), ['template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>


    <code><?= __FILE__ ?></code>
</div>

