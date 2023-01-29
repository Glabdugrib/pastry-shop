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
   public $baseUrl = '';
   public $css = [
      'https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta16/dist/css/tabler.min.css',
      'https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css'
      // 'css/site.css',
   ];
   public $js = [
      'https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta16/dist/js/tabler.min.js',
      'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.map'
      // 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js'
   ];
   public $jsOptions = array(
      'position' => \yii\web\View::POS_HEAD
  );
   public $depends = [
      'yii\web\YiiAsset',
      'yii\bootstrap5\BootstrapAsset'
   ];
}
