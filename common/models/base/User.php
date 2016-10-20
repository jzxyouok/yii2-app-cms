<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $email
 * @property string $mobile
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $signup_at
 * @property string $signup_ip
 * @property integer $status
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'auth_key'], 'required'],
            [['created_at', 'updated_at', 'signup_at', 'status'], 'integer'],
            [['username'], 'string', 'max' => 24],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 64],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 60],
            [['mobile'], 'string', 'max' => 13],
            [['signup_ip'], 'string', 'max' => 15],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户 ID',
            'username' => '登录名称',
            'password_hash' => '登录密码',
            'password_reset_token' => '密码重置 Token',
            'auth_key' => '登录保持密钥',
            'email' => '电子邮箱',
            'mobile' => '手机号码',
            'created_at' => '注册时间',
            'updated_at' => '更新时间',
            'signup_at' => '登录时间',
            'signup_ip' => '登录 IP',
            'status' => '状态',
        ];
    }
}
