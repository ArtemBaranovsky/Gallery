<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class UploadForm extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    // public $avatar_filename;

    public function rules()
    {
        return [
            [['avatar_filename'], 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'gif']],
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['registration_ip'], 'string', 'max' => 45],
			
        ];
    }
    
    public function upload()
    {
        // if ($this->validate()) {
        if ($this->load()) { //validate
            // $this->avatar_filename->saveAs('user/' . $this->avatar_filename->baseName . '.' . $this->avatar_filename->extension);
            $this->avatar_filename->saveAs('user/' . $_SESSION['filename']);
			echo "upload from models/uploadform"; die();
            return true;
        } else {
            return false;
        }
    }
}