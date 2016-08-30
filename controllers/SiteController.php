<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\UpdateNameForm;
use app\models\User;
use yii\helpers\Url;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),  
                'only' => ['logout', 'cabinet'],
                'rules' => [                   
                    [
                        'allow' => true,
                        'actions' => ['logout', 'cabinet'],
                        'roles' => ['@'],
                    ],
                ],                
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     * 
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');        
    }
    
    public function actionCabinet()
    {
        $model = new UpdateNameForm();
        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $result = false;
            $user = Yii::$app->user->identity;
            if($user->name != $model->name) {
                $user->name = $model->name;
                $result = $user->save(true, ['name']);
            }            
            
            if($result) {
                Yii::$app->session->setFlash('updatename_success', Yii::t('app', 'Имя пользователя успешно изменено.'));                
            }
            else {
                Yii::$app->session->setFlash('updatename_error', Yii::t('app', 'Имя пользователя не изменилось.'));
            }        
            
            return $this->refresh();            
        } 

        return $this->render('cabinet', [
            'model' => $model,
        ]);        
    }

    /**
     * Login action: registration and authentication
     * @param string $token
     * @return string
     */
    public function actionLogin($token="", $email="")
    {
        $model = new LoginForm();
        if(empty($token) && empty($email)) {
            $button_text = 'Регистрация'; 
            $message = '<p>Введите E-mail, на который будет отправлена одноразовая ссылка для входа:</p>';
            
            if($model->load(Yii::$app->request->post()) && $model->validate()) {
                $user = User::findByEmail($email);
                if(!$user) {
                    $user = new User();
                    $user->email = $model->email;
                    $user->generateAuthKey();
                    $user->generateAccessToken();                
                    $user->save();
                } 
                
                if($model->sendEmail($model->email, Url::to(['/login', 'email' => $user->email, 'token' => $user->access_token], true))) {                   
                    Yii::$app->session->setFlash('login_success', Yii::t('app', 'На Ваш E-mail отправлена одноразовая ссылка для входа на сайт - пожалуйста, проверьте почту.'));
                }
                else {
                    Yii::$app->session->setFlash('login_error', Yii::t('app', 'Произошла ошибка: пожалуйста, попробуйте войти на сайт позже.'));                   
                }
                
                return $this->refresh();        
            }           
        }
        else {
            $button_text = 'Войти';
            $message = ""; 
            $model->setAttributes(['email' => $email]);
                        
            if($model->validate()) { 
                $user = User::findByEmail($email);
                if($user && ($user->access_token == $token)) // Yii::$app->user->loginByAccessToken($token) || User::findIdentityByAccessToken($token)
                {                    
                    Yii::$app->session->setFlash('login_success', Yii::t('app', 'Вы зарегистрированы и можете перейти в <a href="/cabinet">личный кабинет</a>.'));
                    Yii::$app->user->login($user);                                 
                }
                else { 
                    $link = Yii::$app->getRequest()->getAbsoluteUrl();
                    Yii::$app->session->setFlash('login_error', Yii::t('app', 'Ссылка для входа '.$link.' неверна.'));
                    return $this->redirect(Url::to('/login'));
                } 
            }            
        }
        
        return $this->render('login', [
            'model' => $model,
            'value' => $email,
            'message' => $message,
            'button_text' => $button_text
        ]);       
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        // Обновить access_token для обеспечения уникальности ссылки входа
        Yii::$app->user->identity->generateAccessToken();
        Yii::$app->user->identity->save();
            
        Yii::$app->user->logout();
        return $this->goHome();
    }   
}
