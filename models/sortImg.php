<?php

namespace app\models;

use Yii;	//
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * This is the model class for table "imgs".
 *
 * @property int $id
 * @property string $name
 * @property string $category
 * @property string $description
 * @property string $user
 * @property string $filepath
 * @property string $timecreated
 */
class sortImg extends \yii\db\ActiveRecord
{
	/**
	* @var UploadedFile
	*/
	public $imageFile;
	public $avatar_filename;
	// public $createdBy;	//

    /**
     * @inheritdoc
     */
	
	public static function tableName()
    {
        return 'imgs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'category', 'description', 'user'/*, 'filepath'*/], 'required'],
            [['timecreated'], 'safe'],
            [['name', 'category', 'user'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 1000],
            [['filepath'], 'string', 'max' => 255],
			// [['imageFile'], 'image'/*, 'file'*/, 'skipOnEmpty' => true, 'extensions' => 'gif, png, jpg, jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'category' => 'Категория',
            'description' => 'Описание',
            'user' => 'Пользователь',
            'filepath' => 'Путь к файлу',
            'timecreated' => 'Время создания',
        ];
    }

/* 	public function update(SortImg $model)
    {
       
        $model->title = $this->title;
        $model->description = $this->description;
        return $model->save(false);
    } */
	public function upload()
    {
		if ($this->validate() and !is_null(($this->imageFile))) {
        // var_dump($this->imageFile); die();
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
