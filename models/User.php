<?php

namespace app\models;

use yii;
use app\models\User;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\db\ActiveRecord; 
use yii\data\ActiveDataProvider;
use yii2mod\comments\models\CommentModel;
use yii2mod\comments\models\search\CommentSearch;

class User extends yii\db\ActiveRecord implements \yii\web\IdentityInterface //, yii\db\ActiveRecordInterface
{
    
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $isGuest;



  	public function getAvatar()
    {
		if ($GLOBALS['commentCount']>0) { 
			$query = $GLOBALS['query'];
			for ($shift = $GLOBALS['commentCount']; $shift < count($GLOBALS['query'])+1; $shift++) {

			}
		} else {
			$GLOBALS['commentCount'] = 0;
			$GLOBALS['query'] = CommentModel::find()
				->where(['entityId' => $_GET['id']])
				->alias('c')
				// ->select(['c.createdBy', 'a.username'])
				->select(['c.createdBy'])
				// ->joinWith('author a')
				// ->groupBy(['c.createdBy', 'a.username'])
				// ->orderBy('a.username')
				->asArray()
				->all();
		}

		$result = User::find()
					->where(['id' => $GLOBALS['query'][$GLOBALS['commentCount']]['createdBy']])
					->select([avatar_filename])
					->all();
			
		echo yii\helpers\BaseHtml::img(yii\helpers\Url::base(true).'/user/'.$result[0][attributes][avatar_filename],
			['alt'=> User::findOne($GLOBALS['query'][$GLOBALS['commentCount']]['createdBy'])['username'], 'class'=>'avatar', 'style'=>'width:100%']);
		
		$GLOBALS['commentCount']++;

    } 
	
 	public function getUsername()
{		
		// echo \Yii::$app->user->identity->username;
}  
/**
	* {@inheritdoc}
	*/
    public static function tableName()
    {
        return 'user';
    }

    public static function primaryKey()
    {
        return ['id'];
    }
    
    /**
     * @inheritdoc
     */
     public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $usernameVirt
     * @return static|null
     */
    public static function findByUsername($usernameVirt)
    {
        return static::findOne(['username' => $usernameVirt, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
		* {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $passwordVirt password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($passwordVirt)
    {
        return Yii::$app->security->validatePassword($passwordVirt, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $passwordVirt
     */
    public function setPassword($passwordVirt)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($passwordVirt);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function rules()
    {
        return [
/*             ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This email address has already been taken.'],
//            ['password', 'required'],
//            ['password', 'string', 'min' => 6],
            [['registration_ip'], 'string', 'max' => 45],
            ['avatar_filename', 'file', 'extensions' => ['png', 'jpg', 'gif']],
            [['confirmed_at', 'blocked_at', 'created_at', 'updated_at', 'flags', 'last_login_at', 'status', 'age'], 'integer'], */
        ];
    }

	/**
	 * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID пользователя',
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'password_hash' => 'Хэш пароля',
            'auth_key' => 'Ключ авторизации',
            'confirmed_at' => 'Время подтверждения',
            'unconfirmed_email' => 'Флаг неподтвержденного Email',
            'blocked_at' => 'Время блокировки',
            'registration_ip' => 'Регистрационный Ip',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
            'flags' => 'Флаги',
            'last_login_at' => 'Последний вход',
            'status' => 'Статус',
            'avatar_filename' => 'Аватарка пользователя',
            'age' => 'Возраст пользователя',
        ];
    }

	public static function getUserAvatarById($user_id)
    {
        $sql = 'select avatar_filename from user where id = :'.$user_id;
        $bind = array('user_id' => $user_id);

        $result = self::fetchOne($sql, $bind, null, Db::FETCH_NUM);

        return $result[0];
    }
	
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

	    
    public function upload()
    {
        // if ($this->validate()) {
        $session = Yii::$app->session;
		// $_SESSION['filename'] = $this->avatar_filename->baseName . '.' . $this->avatar_filename->extension;
		if ($this->load()) {
            $this->avatar_filename->saveAs('user/' . $this->avatar_filename->baseName . '.' . $this->avatar_filename->extension);
			// echo "upload from models/user";
            return true;
        } else {
            echo $this->error();
			return false;
        }
    }

	
	
	
	
	
	
	/**
	 * @return \yii\db\ActiveQuery
     */
//    public function getCategories()
//    {
//        return $this->hasMany(Categories::className(), ['created_user_id' => 'id']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getProfile()
//    {
//        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialAccounts()
    {
        return $this->hasMany(SocialAccount::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getTokens()
//    {
//        return $this->hasMany(Token::className(), ['user_id' => 'id']);
//    }
	
}
