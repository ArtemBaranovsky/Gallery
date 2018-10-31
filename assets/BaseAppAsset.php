<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BaseAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
		// 'css/style.css',
		// 'css/lightbox.css',
		// 'css/cropper.css',
		// 'css/bootstrap.min.css'
		// 'css/prettyCheckboxes.css',
		// 'css/customScroller.css',
    ];
    public $js = [
		// 'js/jquery.js',
/*		'js/jquery-1.4.2.js',
		'js/prettyCheckboxes.js',
		'js/jquery.customScroller-1.2.js',
		'js/js-func.js',*/
		// 'js/lightbox-2.6.min.js',
		// 'js/lightbox.js',
		// 'js/cropper.js',
    ];
    public $depends = [	//	массив полностью определённых имён классов, котарые должны считаться пакетами материалов и быть зарегистрированными ранее этого пакета
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
		// '\yii\jquery\JqueryAsset::class',
    ];
	
	public $images = [
        // 'css/images/',
    ];
	
	    public function init()
    {
	parent::init();	// корректировки, сделанные внутри yii\web\AssetBundle::init() или над зарегистрированным объектом bundle, будут иметь приоритет над конфигурацией AssetManager
        // resetting BootstrapAsset to not load own css files
        // \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            // 'css' => [],
            // 'js' => []
        // ];
    }
}
