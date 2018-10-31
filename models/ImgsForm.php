<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\validators\ImageValidator;
use yii\helpers\Html;
use yii\data\Pagination;

/**
 * This is the model class for table "imgs".
 *
 * @property int $id
 * @property string $name
 * @property string $category
 * @property string $description
 * @property string $user
 */
 
class ImgsForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	
	const SORT_ID = 'sort_id';
	
	public $imageFile;		//@var UploadedFile
	public $name;
	public $category;
	public $description;
	public $user;

	//public $categories = getCategories();		//  массив наименований уникальных категорий 
	//public $items = categoryFilter();				// 	массив свойств опубликованных картинок, отфильтрованных по категории 

    
	
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
			// [['imageFile'], 'required'],		// атрибут imageFile используется для хранения экземпляра загруженного файла.
			// [['imageFile'], 'image'],
			//[['file'], 'file', 'maxFiles' => 5],
			// [['imageFile'], 'file', 'skipOnEmpty' => false, /*false,*/ 'extensions' => 'jpg, jpeg, png, gif'],	//Валидатор file позволяет проверять расширение, размер, тип MIME и другие параметры загруженного файла.
            // [['imageFile'], 'each', 'rule' => ['file', 'skipOnEmpty' => false, 'extensions' => 'jpg, jpeg, png, gif', 'maxFiles' => 5]],
			[['name', 'category', 'user'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 1000],
        ];
    }
	
	// выполняет валидацию и сохраняет загруженный файл на сервере.
	public function upload()
	{
		// echo 'uploads/'.Html::encode($this->imageFile->baseName).'.'.$this->imageFile->extension;
		if ($this->validate()) {
			if ($this->imageFile->saveAs('uploads/'.iconv('utf-8','windows-1251',Html::encode($this->imageFile->baseName)).'.'.$this->imageFile->extension)){
				//$this->imagerisize('uploads/', $this->imageFile->baseName.'.'.$this->imageFile->extension, $module);
                return true;
			}
				// echo '/uploads/'.$this->imageFile->baseName.'.'.$this->imageFile->extension;
				// echo "<pre>";
				// print_r($this->imageFile);	//
				// echo "</pre>";
			return true;
		} else {
			// return false;
			return var_dump($this->getErrors());
				}
	}
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'category' => 'Категория',
            'description' => 'Описание',
            'user' => 'Пользователь',
			'imageFile' => 'Файл',
        ];
    }


    public static function getCategories()
    {
									// $items = ImgsForm::find()
										 //// ->where(['category' => !is_null($categories) ? $categories : NULL ])
											// ->indexBy('id')
											// ->asArray()
											// ->all();
									// foreach ($items as $key => $value){
												// $categories[]=$items[$key][category]; 		 
											// } 
									//// echo $this->render('gallery', array_unique($categories));

									// return array_unique($categories);
		$categories = Categories::find()
				->indexBy('id')
				->asArray()
				->all();										
		return array_column($categories,'title');
    }
    
    public static function categoryFilter($category=NULL)
    {
    	$items = ImgsForm::find()
			->where(['category' => $category]);
		$pagination = new Pagination([
			'defaultPageSize' => 15,
			'totalCount' => $items->count(),
		]);
		// $items->on(ImgsForm::SORT_ID, function (){
			$sortType = (!isSet($sortType))? "SORT_ASC" :
				($sortType == "SORT_ASC") ? "SORT_DESC" : "SORT_ASC";
		// });
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		if (!is_null($category)) {
												$items = ImgsForm::find()
												->where(['category' => $category ])
												->orderBy(
													['id' => $sortType //	выбор типа сортировки изображений убыв/возр id
													])		
												->indexBy('id')										
												->asArray()
												->offset(($page - 1) * 15 + 1)
												->limit($pagination->limit)
												->all();
											}
				else {
												$items = ImgsForm::find()
												->indexBy('id')
												->orderBy(
													['id' => $sortType //	выбор типа сортировки изображений убыв/возр id
													])		
												->asArray()
												->limit($pagination->limit)
												->offset(($page - 1) * 15 + 1)
												->all();
											}
			return  $items;

    }
	
	// функция для передачи параметров ['categories', 'items'] в site/Getcategories
    public function getData($category=NULL)
    {
			return [					//	передаем две переменные виду gallery 
			    'categories' => $this->getCategories(),
			    'items' => $this->categoryFilter(!$category==NULL? $category: NULL),
			];
		}


}
	