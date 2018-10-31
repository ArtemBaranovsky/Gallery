<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\BaseAppAsset;

// BaseAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
	

</head>
<body>
<?php $this->beginBody() ?>
<p></p>
<div class="wrap">
    <?php
		
        $menuItems=[
				Yii::$app->user->isGuest ? 
					['label' => 'Галерея', 'url' => ['/site/getcategories']] 
					: 
						['label' => 'Галерея',
							// 'url' => ['/site/getcategories?category'],
							'options'=>['class'=>'dropdown'],
							'template' => '<a href="{url}" class="url-class">{label}</a>',
							'items' => [
								['label' => 'Галерея', 'url' => ['/site/getcategories']],
								['label' => 'Добавить изображения', 'url' => ['/site/imgs']],
								['label' => 'Управление галереей', 'url' => ['/imgs/index']],
							]
						],
				['label' => 'Домой', 'url' => ['/site/index']],
                ['label' => 'О нас', 'url' => ['/site/about']],
                ['label' => 'Контакты', 'url' => ['/site/contact']],
            ];

            if (Yii::$app->user->isGuest)
            {
                $menuItems[]=['label' => 'Зарегистрироваться', 'url' => ['/site/signup']];
                $menuItems[]=['label' => 'Войти', 'url' => ['/site/login']];
            } else {
                $menuItems[]=
				'<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout', 'style' => 'margin-top: 8px']
                )
                . Html::endForm() . '</li>';
            }
    NavBar::begin([
        'brandLabel' => 'Проект галереи',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems
        ]
    );
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <p><?//='Вы зашли как '.Yii::$app->user->identity[username] ?><br></p>
        <? //echo '<pre>'; print_r(Yii::$app->user); echo '</pre>'; ?>
        <?= $content ?>

    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
