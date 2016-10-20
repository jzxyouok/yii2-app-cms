<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    private static $_plugins = [
        'cookie',
    ];
    private $plugins = [
        'inspinia' => [
            'js' => 'js/inspinia.js',
        ],
        'metisMenu' => [
            'sourcePath' => '@vendor/onokumus/metisMenu/dist/',
            'js' => 'metisMenu.min.js',
        ],
        'slimscroll' => [
            'sourcePath' => '@bower/slimscroll/',
            'js' => 'jquery.slimscroll.min.js',
        ],
        'flot' => [
            'sourcePath' => '@bower/flot/',
            'js' => [
                'jquery.flot.js',
                'jquery.flot.resize.js',
                'jquery.flot.pie.js',
                'jquery.flot.symbol.js',
                'jquery.flot.time.js',
            ],
            'plugins' => [
                'js/plugins/flot/jquery.flot.tooltip.min.js',
                'js/plugins/flot/jquery.flot.spline.js',
            ],
        ],
        'peity' => [
            'sourcePath' => '@bower/peity/',
            'js' => 'jquery.peity.min.js',
            'demo' => 'js/demo/peity-demo.js',
        ],
        'pace' => [
            'sourcePath' => '@bower/pace/',
            'js' => 'pace.min.js',
        ],
        'jquery-ui' => [
            'sourcePath' => '@bower/jquery-ui/',
            'js' => 'jquery-ui.min.js',
        ],
        'gritter' => [
            'sourcePath' => '@bower/jquery.gritter/',
            'js' => 'js/jquery.gritter.min.js',
            'css' => 'css/jquery.gritter.css',
        ],
        'sparkline' => [
            'sourcePath' => '@bower/bower-jquery-sparkline/dist/',
            'js' => 'jquery.sparkline.retina.js',
            'demo' => 'js/demo/sparkline-demo.js',
        ],
        'chartJs' => [
            'sourcePath' => '@bower/chartjs/dist/',
            'js' => 'Chart.min.js',
        ],
        'toastr' => [
            'sourcePath' => '@bower/toastr/',
            'js' => 'toastr.min.js',
            'css' => 'toastr.min.css',
        ],
        'cookie' => [
            'sourcePath' => '@bower/jquery.cookie/',
            'js' => 'jquery.cookie.js',
        ],
    ];


    public static function register($view, $plugins = [])
    {
        self::$_plugins = array_merge(self::$_plugins, $plugins);
        return $view->registerAssetBundle(get_called_class());
    }

    public function init()
    {
        if ($this->sourcePath !== null) {
            $this->sourcePath = rtrim(Yii::getAlias($this->sourcePath), '/\\');
        }
        if ($this->basePath !== null) {
            $this->basePath = rtrim(Yii::getAlias($this->basePath), '/\\');
        }
        if ($this->baseUrl !== null) {
            $this->baseUrl = rtrim(Yii::getAlias($this->baseUrl), '/');
        }
        
        array_push($this->css, 'font-awesome/css/font-awesome.css');

        if(self::$_plugins !== null){
            foreach(self::$_plugins as $plugin){
                $basePath = '';
                $baseUrl = '';

                if(isset($this->plugins[$plugin])){
                    $plugin = $this->plugins[$plugin];

                    if(isset($plugin['sourcePath'])){
                        list($basePath, $baseUrl) = Yii::$app->getAssetManager()->publish($plugin['sourcePath'], $this->publishOptions);
                    }

                    $basePath = $this->basePath . $basePath;
                    $baseUrl = $this->baseUrl . $baseUrl;

                    if(isset($plugin['js'])){
                        if(is_array($plugin['js'])){
                            foreach($plugin['js'] as $js){
                                array_push($this->js, $baseUrl . "/". $js);
                            }
                        }else{
                            array_push($this->js, $baseUrl . "/". $plugin['js']);
                        }
                    }

                    if(isset($plugin['plugins'])){
                        if(is_array($plugin['plugins'])){
                            foreach($plugin['plugins'] as $js){
                                array_push($this->js, $this->baseUrl . "/". $js);
                            }
                        }else{
                            array_push($this->js, $this->baseUrl . "/". $plugin['plugins']);
                        }
                    }

                    if(isset($plugin['demo'])){
                        array_push($this->js, $this->baseUrl . "/". $plugin['demo']);
                    }

                    if(isset($plugin['css'])){
                        if(is_array($plugin['css'])){
                            foreach($plugin['css'] as $css){
                                array_push($this->css, $baseUrl . "/". $css);
                            }
                        }else{
                            array_push($this->css, $baseUrl . "/". $plugin['css']);
                        }
                    }
                }
            }
        }

        array_push($this->css, 'css/animate.css');
        array_push($this->css, 'css/style.css');
    }
}
