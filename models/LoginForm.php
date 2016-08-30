<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $email;  
    public $rememberMe = true;
    private $_user = false;    

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],  
            ['rememberMe', 'boolean'],
        ];
    } 
    
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Ваш E-mail')                       
        ];
    }    

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
    
    /**
     * Sends an email with login link to the specified email address.
     *
     * @param string $email the target email address
     * @param string $link the login link
     * @return boolean whether the email was sent
     */
    public function sendEmail($email, $link)
    {
        $message = "Здравствуйте!";
        $message .= "<br />Для входа на сайт, пожалуйста, воспользуйтесь следующей ссылкой: <a href='".$link."' target='_blank'>".$link.".";
        $message .= "<br />Обратите внимание, что ссылка действительна только для одного сеанса работы: после выхода из учетной записи потребуется получить новую ссылку для входа на сайт.";
        $message .= "<br />Если Вы не отправляли данный запрос, в целях безопасности не переходите по ссылке, указанной в письме.";
                
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom(Yii::$app->params['adminEmail'])            
            ->setCharset('utf-8')
            ->setSubject('Запрос ссылки для входа на сайт')
            ->setHtmlBody($message)
            ->send();      
    }
}
