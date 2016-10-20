<?php
namespace backend\widgets;


/**
 * 侧边栏组件
 *
 * User: Jony < jonneyless@163.com >
 * Date: 2016/10/9
 * Time: 9:29
 */

class Sidebar extends \yii\base\Widget
{
    public function run()
    {
        return $this->render('/widgets/sidebar');
    }
}