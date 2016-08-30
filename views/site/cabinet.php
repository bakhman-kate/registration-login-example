<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\UpdateNameForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;?>

<div class="site-index">
    <div class="jumbotron">
        <h1><?= Html::encode($this->title) ?></h1>        
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-xs-12">                
                <h4>Данные Вашей учетной записи:</h4>                              
                <p>E-mail: <?= Yii::$app->user->identity->email?></p>
                
                <?php if (Yii::$app->session->hasFlash('updatename_success')): ?>
                    <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('updatename_success')?></div>
                <?php else:?> 
                    <?php if (Yii::$app->session->getFlash('updatename_error')): ?>
                        <div class="alert alert-warning" role="alert"><?= Yii::$app->session->getFlash('updatename_error')?></div>
                    <?php endif;?>
                <?php endif; ?>
                        
                <?php $form = ActiveForm::begin(['id' => 'update-name-form']); ?>

                <?= $form->field($model, 'name', [
                    'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('name'),            
                    ],                        
                ])->textInput(['value' => Yii::$app->user->identity->name]) ?>  

                <div class="form-group">
                    <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary', 'name' => 'update-name-button']) ?>       
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>    
</div>
