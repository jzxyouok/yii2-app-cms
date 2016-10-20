<?php

namespace common\models\base;

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
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'status'], 'integer'],
            [['name', 'auth_item'], 'required'],
            [['name', 'route'], 'string', 'max' => 30],
            [['params'], 'string', 'max' => 255],
            [['auth_item'], 'string', 'max' => 64],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '菜单 ID',
            'parent_id' => '父级 ID',
            'name' => '名称',
            'route' => '路由',
            'params' => '参数',
            'auth_item' => '验证密钥',
            'status' => '状态',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Menu::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['parent_id' => 'id']);
    }
}
