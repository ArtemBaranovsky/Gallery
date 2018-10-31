<?php
namespace app\views;
use yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\web\Session;

// https://github.com/Foliotek/Croppie
//upload.php
$session = Yii::$app->session;
session_start();
if(isset($_POST["image"]))
{
	 $data = $_POST["image"];

	 $image_array_1 = explode(";", $data);
	 $image_extention = explode("/", $image_array_1[0]);

	 $image_array_2 = explode(",", $image_array_1[1]);

	 $data = base64_decode($image_array_2[1]);

	 //var_dump($_SESSION);
	 $imageName = $session->getFlash('username').'.'.$image_extention[1];
		// echo Yii::$app->basePath.'\\web\\img\\avatar\\'.$imageName;
	 // file_put_contents('d:\\Program Files\\OpenServer\\domains\\gallery\\web\\img\\avatar\\'.$imageName, $data);
	 file_put_contents(__DIR__.'\\avatar\\'.$imageName, $data);

	 echo '<img src="'.$imageName.'" class="img-thumbnail" />';
}

?>

