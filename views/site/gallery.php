<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use app\assets\AppAsset;
use yii\web\Request;
use yii\web\View;
use app\models\imgs;
use app\controllers\imgsController;
use yii\base\Component;
use yii\widgets\LinkPager;





// AppAsset::register($this);
Yii::$app->view->registerJsFile('\js\lightbox.js', [ /* ['yii\web\JqueryAsset'],  */ ['position' => \yii\web\View::POS_END]]);
Yii::$app->view->registerCssFile('\css\lightbox.css', [\yii\web\View::POS_HEAD]);

// Yii::$app->view->registerJsFile('\js\jquery.colorbox.js', [ /* ['yii\web\JqueryAsset'],  */ ['position' => \yii\web\View::POS_END]]);
// Yii::$app->view->registerCssFile('\css\colorbox.css', [\yii\web\View::POS_HEAD]);

// class Imgs extends ActiveRecord{}
//$this->beginPage();
?>
<html lang="<?php echo Yii::$app->language ?>">
<head>
<?php	//yii\web\View::renderAjax();
	
	$this->title = 'Галерея';
	$this->params['breadcrumbs'][] = $this->title;
	$this->registerMetaTag(['name' =>'http-equiv', 'content' => 'text/html; charset=utf-8']); 
?>

</head>

<body>

<div class="site-gallery">
    <p>

		<?php //$category = $categories['category']; ?>
		<?php $category = $categories['categories']; ?>
		<?php $items = $categories['items']; ?>
        <!-- Shell -->
		<div class="shell">
		
		<!-- Gallery -->
			<div class="wrapper">
				<div class="category">
										<?php foreach ($items as $key => $value) {
												$categories[]=$items[$key]['category']; 
												// echo $items[$key][name]."<br>";		 
											}  ?>
										<?php // $categories = array_unique($categories)	// выбираем уникальные названия категорий картинок из БД?>
										<h4><b>Навигация по категориям</b><br></h4>
										<?php echo  Html::tag('a', 'все категории', ['href' => Yii::$app->urlManager->createUrl('site/getcategories?category')]) ?>
										<?php 
										foreach ($categories['categories'] as $key => $value) { 	 
											echo "  /  ".Html::tag('a', Html::encode($value), ['href' => Yii::$app->urlManager->createUrl('site/getcategories?category=' . $value)]); 
										} ?>
										
										<!--<p class = "bg-custom"><span class = "glyphicon glyphicon-sort onclick="glyphiconSort()"></span> Порядок отображения</p>-->
										<p> <?php echo Html::a('<span class = "glyphicon glyphicon-sort"></span> Порядок отображения', ['site/getcategories', 'category' => isset($_GET['category']) ? $_GET['category']: '', 'sort' => isset($_GET['sort']) ? $_GET['sort'] : 'SORT_ASC'] /*, ['data-confirm' => 'Удалить?']*/); ?> </p>
				</div>
											
				<div class="gallery">
				<?php $items = ($_GET['sort']=='SORT_ASC') ? array_reverse($items): $items; //echo "<pre>"; var_dump($items);  echo "</pre>"; ?>
				
								<?php foreach ($items as $key => $value) {?>
					<div class="item">
						<div>
					    		<a data-lightbox="roadtrip" data-title="<?php echo $items[$key]['description'] ?>" data-alt="<?php echo $items[$key]['name'] ?>" href="<?php echo Yii::$app->request->baseUrl.'/web/uploads/'. $items[$key]['filepath'] ?>" title="<?php echo $items[$key]['name'] ?>">
									<img class="front" src="<?php echo yii\helpers\Url::to(Html::encode(Yii::$app->request->baseUrl.'/web/uploads/thumb/'.$items[$key]['filepath'])) ?>" alt="">
								</a>
							    	<!--<div class="image-hover">-->
							    		<h5><?$items[$key]['description'] ?></h5>
							    		<h6><?$items[$key]['category'] ?></h6>
							    	<!--</div>-->
						</div>	    
					</div>														
								<?php } ?>
				</div>														
			</div>
			<div class="gallery-b">&nbsp;</div>	
			<?php echo LinkPager::widget(['pagination' => $pagination]) // информация о пагинации, передается из action во view.?>
		<!-- End Gallery -->
		
		</div>
<!-- End Shell -->
    </p>
</div>

</body>
</html>
<script>
function glyphiconSort() {
  alert('Вы нажали на элемент "glyphicon-sort"');
}
$('#glyphicon-sort').click();
</script>