<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>   

    <?php if (Yii::$app->session->hasFlash('login_success')): ?>
        <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('login_success')?></div>
    <?php else:?> 
        <?php if (Yii::$app->session->getFlash('login_error')): ?>
            <div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('login_error')?></div>
        <?php endif;?>
            
        <?= $message?>       
    
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'email', [
            //'options' => ['class' => 'col-sm-8 form-group'],
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('email'),            
            ],
        ])->input('email', ['autofocus' => true, 'value' => $value])->label(false) ?>  

        <div class="form-group">
            <?= Html::submitButton($button_text, ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>       
        </div>

        <?php ActiveForm::end(); ?>
            
    <?php endif; ?>
</div>