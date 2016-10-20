<?php

use common\models\User;
use common\models\Menu;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->bigPrimaryKey()->comment('用户 ID'),
            'username' => $this->string(24)->notNull()->unique()->comment('登录名称'),
            'password_hash' => $this->string(64)->notNull()->comment('登录密码'),
            'password_reset_token' => $this->string(64)->notNull()->defaultValue('')->comment('密码重置 Token'),
            'auth_key' => $this->string(32)->notNull()->comment('登录保持密钥'),
            'email' => $this->string(60)->notNull()->defaultValue('')->comment('电子邮箱'),
            'mobile' => $this->string(13)->notNull()->defaultValue('')->comment('手机号码'),
            'created_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('注册时间'),
            'updated_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('更新时间'),
            'signup_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('登录时间'),
            'signup_ip' => $this->string(15)->notNull()->defaultValue('0.0.0.0')->comment('登录 IP'),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('状态'),
        ], $tableOptions);

        $user = new User();
        $user->username = 'admin';
        $user->setPassword('123456');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->save();

        $this->createTable('{{%menu}}', [
            'id' => $this->bigPrimaryKey()->comment('菜单 ID'),
            'parent_id' => $this->bigInteger(20)->notNull()->defaultValue(0)->comment('父级 ID'),
            'name' => $this->string(30)->notNull()->comment('名称'),
            'route' => $this->string(30)->notNull()->defaultValue('')->comment('路由'),
            'params' => $this->string(255)->notNull()->defaultValue('')->comment('参数'),
            'auth_item' => $this->string(64)->notNull()->comment('验证密钥'),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('状态'),
        ], $tableOptions);

        $this->addForeignKey('parent', '{{%menu}}', 'parent_id', '{{%menu}}', 'id', null, 'CASCADE');

        $menu = new Menu();
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%menu}}');
    }
}
