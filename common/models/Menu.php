<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $route
 * @property string $params
 * @property string $auth_item
 * @property integer $status
 *
 * @property Menu $parent
 * @property Menu[] $menus
 */
class Menu extends namespace\base\Menu
{
}
