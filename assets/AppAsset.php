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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
	public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
	
    public $css = [
        // 'css/site.css',
		'css/style.css',
		// 'css/lightbox.css',
		// 'css/cropper.css',
		'css/bootstrap.min.css'
		// 'css/prettyCheckboxes.css',
		// 'css/customScroller.css',
    ];
    public $js = [
		'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js',
		// 'js/jquery.js',
		// 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js',
/*		'js/jquery-1.4.2.js',
		'js/prettyCheckboxes.js',
		'js/jquery.customScroller-1.2.js',
		'js/js-func.js',*/
		// 'js/lightbox-2.6.min.js',
		// 'js/lightbox.js',
		// 'js/cropper.js',
    ];
    public $depends = [	//	Массив полностью определённых имён классов, которые должны считаться пакетами материалов и быть зарегистрированными ранее этого пакета
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
		// '\yii\jquery\JqueryAsset::class',
    ];
	
	public $images = [
        // 'css/images/',
    ];
	
}
