<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\eoffice_eolm\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAssetEolm extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
        'web_eolm/js/thaibath.js',
//        'js/app.js',
    ];
    public $depends = [
       // 'justinvoelker\awesomebootstrapcheckbox\Asset',
    ];

//    public $jsOptions=['position'=>\yii\web\View::POS_HEAD];
}
