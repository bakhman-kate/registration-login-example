<?php

namespace app\models;

use Yii;
use yii\base\Model;

class UpdateNameForm extends Model
{
    public $name;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'filter', 'filter' => 'trim'],            
            ['name', 'string', 'min' => 3, 'max' => 255], 
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Ваше имя'),
        ];
    }    
}
