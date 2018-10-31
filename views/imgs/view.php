<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\web\ForbiddenHttpException;
// use kartik\detail\DetailView;
use app\models;	
use app\models\User;	
use yii\widgets\ActiveForm;
use yii\i18n\Formatter;
use yii\web\Session;
use yii2mod\comments\models\CommentModel;




/* @var $this yii\web\View */
/* @var $model app\models\sortImg */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sort Imgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
// setup your attributes 
$attributes = [ 
                'attributes' => [
                    'id',
                    'name',
                    // 'category',
					// 'description',
                        // ['attribute' => 'category',
                        // 'format' => 'raw' , 
                        // 'type' =>DetailView::INPUT_TEXTAREA,
                        // 'updateMarkup' => function($form, $widget) {
                                // $model = $widget->model;
                                // return $form->field($model, 'id') . '<br>' .
                                        // $form->field($model, 'name') . '<br>' .
                                        // $form->field($model, 'description') . '<br>' .
                                        // $form->field($model, 'category');
                                // }
						// ],
                        // 'attribute',
                        // [
                                // 'attribute'=>'id',
                                // 'format'=>'raw',
                                // 'value'=>Html::a('John Steinbeck', '#', ['class'=>'kv-author-link']),
                                // 'type'=>DetailView::INPUT_SELECT2, 
                                // 'widgetOptions'=>[
                                        // 'data'=>ArrayHelper::map($model::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                                        // 'options'=>['placeholder'=>'Select ...'],
                                        // 'pluginOptions'=>['allowClear'=>true]
                                // ],
                                // 'inputWidth'=>'40%',
                        // ],
				],
			];
?>
<div class="sort-img-view">
<p><?=$session->getFlash('alert') ?><br></p>
    <h1><?= Html::encode($this->title) ?></h1>
    <!--<h1>Пользователь №<?//= Yii::$app->user->id ?>(<?//=Yii::$app->user->identity->username?>). (Рисунок <?//=Yii::$app->request->get('id')?>)</h1>-->
    <h4><? //echo "<pre>"; print_r($model[user]);  echo "</pre>"; ?></h4>
	<?php if /* ((Yii::$app->user->can('admin')) or (Yii::$app->user->identity->username == $model[user])) */ (!Yii::$app->user->isGuest)
	{ ?>
                <?php //if (Yii::$app->user->can('updateOwnPost', ['author_id' => $model->user->id]))?>

                <?php $form = ActiveForm::begin([
					'action' => ['index'],
					'method' => 'get',
				]); ?>

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                        ]) ?>
                        <?//= Html::submitButton('update', ['class' => 'btn btn-primary']) ?>
            </p>

            <?=DetailView::widget([
                //'mode'	=> 'edit',
                'model' => $model,
				// 'attributes' => $attributes,
				'attributes' => [
					'user',
					'description',
					'filepath',
					'timecreated',
					[
						'attribute'=>'Изображение',
						'value'=>/* Html::encode() */Yii::$app->homeUrl.'uploads/'.$model->filepath,
						'format' => ['image',['width'=>'100%'/* ,'height'=>'50%' */]],
					],
					// [
						// 'attribute'=>'Комментарии',
						// 'value'=> Comments::widget(['model' => $pageKey]),
					// ],
					// Formatter::asImage(),
				],
				/*[
					'attribute' => $model->name,
					'value' => Yii::$app->homeUrl.'uploads/'.$model->filepath,
									'id' => $model->id,
									//'photo:image',
									'format' => ['image'/* ,['width'=>'100','height'=>'100'] *//*],
				],*/
			
			]); 
		} else throw new ForbiddenHttpException('У вас недостаточно прав для выполнения указанного действия'); ?>
                <?/*=DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'category',
                    'description',
                    'user',
                    'filepath',
                    'timecreated',
                ],
            ])  */?>
                <?php ActiveForm::end(); ?>
				<?//=Comments::widget(['model' => $pageKey])?>
				<?//$model['author']['avatar_filename']=Yii::$app->user->identity->id; ?>
				<?php //yii\helpers\VarDumper::dump(/* 'http://gallery/user/'. */$model,10,true); ?>
				<?//=User::getAvatar(); ?>
				<?//='User ' . \Yii::$app->user->identity->username . ' commented on the page ' . \yii\helpers\Url::current()?>
				<?//=yii\helpers\VarDumper::dump($model,10,true);//->author['avatar_filename']?>
				<?//=yii\helpers\VarDumper::dump($model1,10,true);?>
				<?//yii\helpers\VarDumper::dump($model,10,true);?>
				<? //$GLOBALS['commentCount']= 0 ?>
				<?php echo \yii2mod\comments\widgets\Comment::widget([
					  'model' => $model,
					  // 'dataProvider' => $dataProvider,
					  // 'searchModel' => $searchModel,
					  'relatedTo' => 'User ' . \Yii::$app->user->identity->username . ' commented on the page ' . \yii\helpers\Url::current(),
					  'maxLevel' => 2,
					  'dataProviderConfig' => [
						  'pagination' => [
							  'pageSize' => 10
						  ],
					  ],
					  // 'listViewConfig' => [
						  // 'emptyText' => Yii::t('app', 'No comments found.'),
					  // ],
				]);
				unset($GLOBALS['query']); ?>
				
				
				<?php /* echo \yii2mod\comments\widgets\Comment::widget([
					'model' => $model,
					// 'relatedTo' => 'User ' . \Yii::$app->user->identity->username . ' commented on the page ' . \yii\helpers\Url::current(),
					// 'listViewConfig' => [
						// 'emptyText' => Yii::t('app', 'No comments found.'),
					// ],
				]);*/ ?>
				
				<?php /* echo \yii2mod\comments\widgets\Comment::widget([
				  'model' => $model,
				  'commentView' => '@app/views/site/comments/index' // path to your template
				]);  */?>
</div>