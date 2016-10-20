<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">IN+</h1>

        </div>
        <h3>Welcome to IN+</h3>
        <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
            <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
        </p>
        <p>Login in. To see it in action.</p>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'm-t'],
        ]); ?>
            <?= $form->field($model, 'username')->label(false)->textInput(['autofocus' => true, 'placeholder' => 'Username']) ?>
            <?= $form->field($model, 'password')->label(false)->passwordInput(['placeholder' => 'Password']) ?>
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>

            <a href="#"><small>Forgot password?</small></a>
            <p class="text-muted text-center"><small>Do not have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>
        <?php ActiveForm::end(); ?>
        <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
    </div>
</div>
