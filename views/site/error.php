<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;?>

<div class="site-error">
    <?php switch($exception->statusCode)
    {
        case 404: $this->title = 'Ошибка 404'; $alert_class = 'alert-warning'; $message = 'Запрошенный URL не существует.'; break;
        case 403: $this->title = 'Ошибка 403'; $message = 'Доступ к данной странице запрещен - необходимо выполнить вход/регистрацию.'; $alert_class = 'alert-info'; break;
        default: $this->title = $name;  $alert_class = 'alert-danger'; 
    }?>
    
    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="alert <?=$alert_class?>">
        <?= nl2br(Html::encode($message)) ?>
    </div>    
</div>