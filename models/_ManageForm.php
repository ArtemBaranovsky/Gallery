<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\widgets\ActiveForm;		//+

$form = ActiveForm::begin([
	'id' => 'manage-form',
	'options' => ['class' => 'form-horizontal'],
	]) ?>
	<?= $form->field($model, 'name') ?>
	<?= $form->field($model, 'category') ?>
	<?= $form->field($model, 'description') ?>
	<?//= $form->field($model, 'password')->passwordInput() ?>
	<div class="form-group">
		<div class="col-lg-offset-1 col-lg-11">
			<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
		</div>
	</div>
<?php ActiveForm::end() ?>
<?
/**
 * ManageForm is the model behind the model form.
 */
/*class ManageForm extends Model
{
    public $name;
    public $category;
    public $description;
    //public $body;
    public $verifyCode;
*/

    /**
     * @return array the validation rules.
     */
/*    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'category', 'description'], 'required'],
            // email has to be a valid email address
            //['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

*/
}
