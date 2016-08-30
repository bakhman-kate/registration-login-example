<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $auth_key
 * @property string $access_token
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'auth_key', 'access_token'], 'required'],
            [['name', 'email'], 'string', 'max' => 55],
            [['auth_key', 'access_token'], 'string', 'max' => 32],
            [['auth_key', 'access_token'], 'unique'],            
            [['email'], 'unique', 'message' => 'Указанный E-mail уже занят.'], 
            ['email', 'email'], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Имя'),
            'email' => Yii::t('app', 'E-mail'),
            'auth_key' => Yii::t('app', 'Ключ для проверки cookie'),
            'access_token' => Yii::t('app', 'Токен доступа'),
        ];
    }
       
   /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    
    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);         
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    } 

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }   

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    } 
    
    /**
     * Generates authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    
    /**
     * @return string current user auth key
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }
    
    /**
     * Generates access token
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }    
}
