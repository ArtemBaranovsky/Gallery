<?php

namespace app\controllers;
// namespace app\models;
// namespace yii\jui\autosearch;

use Yii;
use app\models\sortImg;
use app\models\ImgsForm;
use app\models\ImgsSearch;
use app\models\Country; //
use app\models\Categories; 
use app\models\User; 
// use app\controllers\categories;
use app\controllers\ImgsController; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\web\UploadedFile;
use yii\web\Session;
use yii\helpers\Html;
use yii\imagine\Image; 
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
// use yii2mod\comments\models\search\CommentSearch;
// use yii\db\BaseActiveRecord;
// use yii\jui\AutoComplete as JuiAutoComplete;


/**
 * ImgsController implements the CRUD actions for sortImg model.
 */

// public $categories;
class ImgsController extends Controller // Models
{
    public $enableCsrfValidation = false;
	
	public function behaviors()     //  ACF 
    {
        return [
        /*    'access' => [
                'class' => AccessControl::className(),
				// 'denyCallback' => function ($rule, $action) {	// переопределить поведение, когда у пользователя отсутствует доступ к текущему действию
					// throw new \Exception('У вас нет доступа к этой странице');
				// },
				// 'defaultRoles' => ['guest'],
                // 'only' => ['update',  'delete'],	// фильтр ACF нужно применять только к указанным действиям
                'rules' => [
					[
						'allow' => true,
						'actions' => ['update','delete'],
						'roles' => ['createPost', 'updatePost' , 'updateOwnPost', 'isAuthor'],
						// 'matchCallback' => function() {
							// return Yii::$app->user->can('updatePost', ['imgs' => $model]);
							// },
						// 'roles' => ['updateOwnPost' , 'isAuthor'],
                        // 'roleParams' => function() {
							// return ['imgs' => sortImg::findOne(['id' => Yii::$app->request->get('id')])];
							// },
						
					],
					
					// [
                        // 'allow' => true,
                        // 'actions' => ['create', 'update', 'delete'],
                        // 'roles' => ['admin'],               // разрешенные действия, описанные в rbacController, для которых применять фильтр admin    
                    // ],
                    // [
                    //     'allow' => true,
                    //     'actions' => ['view'],
                    //     'roles' => ['viewPost'],
                    // ],
                    // [
                        // 'allow' => true,
                        // 'actions' => ['create','update', 'delete', 'view', 'index'],
						// 'roles' => [ 'updatePost',  'isAuthor'],
						// 'roleParams' => ['id' => Yii::$app->request->get('id')],
						// 'matchCallback' => function() {
							// return Yii::$app->user->can('updatePost', ['imgs' => $imgs]);},
                        // 'roles' => ['isAuthor'],
                        // 'roleParams' => function() {
                            // return ['imgs' => Post::findOne(['id' => Yii::$app->request->get('id')])];
                        //},
                    // ],
                ],
            ], */
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * findModel() should be listed before the route actions, but after behaviors().
	 * Finds the sortImg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return sortImg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = sortImg::findOne($id)) !== null) {		//	возвращает один объект Active Record, заполненный первой строкой результата запроса.
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
    /**
     * Lists all sortImg models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImgsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
		]);		
    }

    /**
     * Displays a single sortImg model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // $searchModel = new \yii2mod\comments\models\search\CommentSearch();
		// $dataProvider = $searchModel->search(Yii::$app->request->get());
		$model1 = User::findOne(['id' => Yii::$app->user->identity->id]);
		$model = $this->findModel($id);
		$model['avatar_filename'] = yii\helpers\ArrayHelper::getValue($model1, 'attributes.avatar_filename');
		return $this->render('view', [
            'model' => $model,
			// 'dataProvider' => $dataProvider,
			// 'searchModel' => $searchModel,
            // 'model1' => yii\helpers\ArrayHelper::getValue($model1, 'attributes.avatar_filename'),
        ]);
    }

    /**
     * Creates a new sortImg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
/*         $model = new sortImg();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]); */
		
		
		$session = Yii::$app->session;
		$model = new ImgsForm();
		// модель заполнения атрибутов данными, вводимыми пользователем
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			//$model->attributes = \Yii::$app->request->post('ImgsForm');	//заполняет атрибуты модели путем присвоения входных данных непосредственно свойству [[yii\base\Model::$attributes]].
			$model->imageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');
			
			// INSERT (table name, column values)
			Yii::$app->db->createCommand()->insert('imgs', [
				'name' => $model->attributes['name'],
				'category' => $model->attributes['category'],	//->dropdownList([[$categories], ['Свой вариант' => $form->field($model, 'category')->textInput(['autofocus' => true])]]),['prompt'=>'Выберите категорию']
				'description' => $model->attributes['description'],
				'filepath' => /*'uploads/'.*/Html::encode($model->imageFile->baseName).'.'.$model->imageFile->extension,
				'user' => !Yii::$app->user->isGuest ? Yii::$app->user->identity[username] : 'guest',
				'user_id' => Yii::$app->user->identity['oldattributes']['id'],
				])->execute();
				
			if ($model->upload()) {
				// file is uploaded successfully
				// Image::thumbnail(Url::to('/uploads/'.Html::encode($model->imageFile->baseName).'.'.$model->imageFile->extension), 100, 100)->save(Yii::getAlias('/uploads/thumb/'.Html::encode($model->imageFile->baseName).'.'.$model->imageFile->extension), ['quality' => 80]);
				$imgFilePath=Yii::$app->basePath.'\\web\\uploads\\';
				$imgFile=iconv('utf-8','windows-1251',/*Html::encode(*/$model->imageFile->baseName).'.'.$model->imageFile->extension/*)*/;
				Image::thumbnail($imgFilePath.$imgFile, 100, 100)
					->save($imgFilePath.'\\thumb\\'.$imgFile, ['quality' => 80]);
                $session->setFlash('alert', 'Вы успешно добавили новое изображение.');
				return $this->redirect(['create']);		// поставить относительный редирект!!
			      // return $this->render('index', ['model'=>$model]);  
			}
		}
		
		$model2 = categories::find()
			// ->indexBy('name')
			->select(['title'])		
			->asArray()
			->orderby(['title'=>SORT_ASC])
			->all();
		$data1 = ArrayHelper::getColumn($model2, 'title'); 	// при формировании значений категорий <option value=""> будет также равнятья значению категорий 
		
		$data = ArrayHelper::map($model2, 'title', 'title'); 	// при формировании значений категорий <option value=""> будет также равнятья значению категорий 
		// определяем роль пользователя
		$role = Yii::$app->db->createCommand('SELECT item_name FROM auth_assignment WHERE user_id='.Yii::$app->user->id)->queryOne();			
		// var_dump(Yii::$app->user->identity); die();

		return $this->render('create', [
			'data'  => $data,		// дублированный перечень категорий (2 одинаковых колонки)
			'model1' => $data1,	// перечень категорий
			'model' => $model,		// модель ImgsForm
			'userRole' => $role["item_name"]
		]);		
    }

    /**
     * Updates an existing sortImg model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		$session = Yii::$app->session;
		// $session->setFlash('alert', 'Вы успешно обновили данные опубликованного изображения!');
		// echo $session->getFlash('alert');
		
		$model = $this->findModel($id);
		$oldmodel = $model;
		// echo "<br><pre>"; print_r($oldmodel[attributes]); echo "</pre>"; 

		
		$imgsAuthor = SortImg::find()	// получаем автора публикации изображения
				->where(['user' => Yii::$app->user->getId()])
				->asArray();

		$data1 = categories::find()	// получаем выборку категорий для дропдаунлиста
				// ->indexBy('name')
				// ->select(['name'])		
				->orderby(['title'=>SORT_ASC])
				->asArray()
				->all();
		$data = ArrayHelper::map($data1, 'title', 'title');
		
			if ($model->load(Yii::$app->request->post()) && $model->save() && $model->validate() ) {
				
				$model->imageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');
				// print_r($model->imageFile);
				// INSERT (table name, column values)
				
				// Вставить проферку изменения полей формы с данными из БД!!!!!!!!!
				// Вставить проферку изменения полей формы с данными из БД!!!!!!!!!
				// Вставить проферку изменения полей формы с данными из БД!!!!!!!!!
				// $checkImgsAttribFromDb = Yii::$app->db->createCommand('SELECT name, category, description, filepath, user FROM imgs WHERE id='.$id)	// ->bindValue(':id', $_GET['id'])
					// ->queryOne();
				// $changedAttribs=[];
				// $change = new yii\db\BaseActiveRecord;
				
				// foreach ($checkImgsAttribFromDb as $newAttr => $newAttrValue) {
					// if (!$newAttrValue == $oldmodel[attributes][$newAttr]) $changedAttribs[]=$newAttr;
					// echo ($newAttrValue.' '.$model[attributes][$newAttr].'<br>');
				// }
				// var_dump($oldmodel->dirtyAttributes);
				// echo "<br><pre>";  print_r($checkImgsAttribFromDb); echo "</pre>";
				
				// echo "<br><pre>"; print_r($model[attributes]); echo "</pre>";
				// echo "<br><pre>"; print_r($oldmodel[attributes]); echo "</pre>"; 
				// $changes = yii\db\ActiveRecord\getDirtyAttributes();

				// echo "<br><pre>"; print_r($changes); echo "</pre>";  
				// 	die();
				
				// echo "<br><pre>"; print_r($model[attributes]); echo "</pre>"; die();
				Yii::$app->db->createCommand()->insert('imgs', [
					'name' => $model->attributes['name'],
					'category' =>  $model->attributes['category'],	//$form->field($model, 'category')->dropDownList($data),
					'description' => $model->attributes['description'],
					'filepath' => $model->attributes['filepath'],	// /*'uploads/'.*/Html::encode($model->imageFile->baseName).'.'.$model->imageFile->extension,
					'user' => !Yii::$app->user->isGuest ? Yii::$app->user->identity[username] : 'guest',
					'user_id' => Yii::$app->user->getId(),
					// Yii::$app->db->createCommand('SELECT id FROM user WHERE username='.Yii::$app->user->identity[username])->queryOne(),
					])->execute();
				
				$session->setFlash('alert', 'Вы успешно обновили данные опубликованного изображения!');
						
				if ($model->upload()) {
					// file is uploaded successfully
					// Image::thumbnail(Url::to('/uploads/'.Html::encode($model->imageFile->baseName).'.'.$model->imageFile->extension), 100, 100)->save(Yii::getAlias('/uploads/thumb/'.Html::encode($model->imageFile->baseName).'.'.$model->imageFile->extension), ['quality' => 80]);
					$imgFilePath=Yii::$app->basePath.'\\web\\uploads\\';
					$imgFile=iconv('utf-8','windows-1251',/*Html::encode(*/$model->imageFile->baseName).'.'.$model->imageFile->extension/*)*/;
					Image::thumbnail($imgFilePath.$imgFile, 100, 100)
						->save($imgFilePath.'\\thumb\\'.$imgFile, ['quality' => 80]);
				}

				return $this->redirect(['view', 'id' => $model->id]);
			} //else 




			// $model = new ImgsForm();	// 
			// модель заполнения атрибутов данными, вводимыми пользователем
	/*		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
				//$model->attributes = \Yii::$app->request->post('ImgsForm');	//заполняет атрибуты модели путем присвоения входных данных непосредственно свойству [[yii\base\Model::$attributes]].
				$model->imageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');
				// echo $model->imageFile->baseName;
				print_r($model->imageFile);
				// INSERT (table name, column values)
				Yii::$app->db->createCommand()->insert('imgs', [
				'name' => $model->attributes['name'],
				'category' => $model->attributes['category'],
				'description' => $model->attributes['description'],
				'filepath' => /*'uploads/'.*//*Html::encode($model->imageFile->baseName).'.'.$model->imageFile->extension,
				'user' => !Yii::$app->user->isGuest ? Yii::$app->user->identity[username] : 'guest',
				])->execute();
				if ($model->upload()) {
					// file is uploaded successfully
					// Image::thumbnail(Url::to('/uploads/'.Html::encode($model->imageFile->baseName).'.'.$model->imageFile->extension), 100, 100)->save(Yii::getAlias('/uploads/thumb/'.Html::encode($model->imageFile->baseName).'.'.$model->imageFile->extension), ['quality' => 80]);
					$imgFilePath=Yii::$app->basePath.'\\web\\uploads\\';
					$imgFile=iconv('utf-8','windows-1251',/*Html::encode(*//*$model->imageFile->baseName).'.'.$model->imageFile->extension/*)*//*;
					Image::thumbnail($imgFilePath.$imgFile, 100, 100)
						->save($imgFilePath.'\\thumb\\'.$imgFile, ['quality' => 80]);
					$session->setFlash('alert', 'Вы успешно заменили данные изображения.');
					return $this->redirect(['imgs']);		// поставить относительный редирект!!

				}
			
			}*/
				
				
			return $this->render('update', [
				'model' => $model,		// $model = $this->findModel($id);
				'id' => $model->id,
				'data' => $data,		// перечень категорий
			
			]);
    }
	
    /**
     * Deletes an existing sortImg model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	    /**
     * Автокомплит для поиска
     */
/*     public function actionAutocomplete() {
        $term = addcslashes(Yii::app()->getRequest()->getParam('term'), '%_'); //экранировать LIKE специальные символы
        if (Yii::app()->request->isAjaxRequest && $term) {
            $model = Posts::model()->findAll(
                array('condition' => 'postName LIKE :term', 'params' => array(':term' => "%$term%"))
            );
            $result = array();
            foreach ($model as $value) {
                $label = $value['postName'];
                $result[] = array('id' => $value['id'], 'label' => $label, 'value' => $label, 'href' => '/' . $value['url']);
            }
            echo CJSON::encode($result);
            Yii::app()->end();
        }
    } */
	

	    /**	https://github.com/yii-dream-team/yii2-upload-behavior/blob/master/src/FileUploadBehavior.php#L88
     * Before save event.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeSave()
    {
        if ($this->file instanceof UploadedFile) {
            if (true !== $this->owner->isNewRecord) {
                /** @var ActiveRecord $oldModel */
                $oldModel = $this->owner->findOne($this->owner->primaryKey);
                $behavior = static::getInstance($oldModel, $this->attribute);
                $behavior->cleanFiles();
            }
            $this->owner->{$this->attribute} = implode('.',
                array_filter([$this->file->baseName, $this->file->extension])
            );
        } else {
            if (true !== $this->owner->isNewRecord && empty($this->owner->{$this->attribute})) {
                $this->owner->{$this->attribute} = ArrayHelper::getValue($this->owner->oldAttributes, $this->attribute,
                    null);
            }
        }
    }
	
/*
	
	public function afterSave($insert, $changedAttributes)
	{
		var_dump(afterSave);
					die();
		parent::afterSave($insert, $changedAttributes);
		if(!$insert && !empty($changedAttributes['text'])) {
			$historyModel = new HistoryModel();
			$historyModel->article_id = $this->id;
			$historyModel->text = $changedAttributes['text'];
			$historyModel->save();
		}
	} */
	
	// public function beforeValidate() {
			// var_dump($model);
			// die();
			// return parent::beforeValidate();
    // }
}
