<?php

namespace app\controllers;

use Yii;
// use App\Models\User;
use app\models\UserSearch;
use app\models\UploadForm;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\web\Session;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    // public $layout = 'mainmin.php';	//  использование шаблона @app/views/layouts/mainmin.php с минимальным набором assets
	/**
     * {@inheritdoc}
     */
/*    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }*/

    /**
     * Lists all User models.
     * @return mixed
     */
	 
	 public function actionIndex()
    {
        $searchModel = new UserSearch();
		// ob_start();
		// User::getAvatar();
		// $avatar = substr(ob_get_contents(), strpos (ob_get_contents(), 'http'), strlen(ob_get_contents())-strpos(ob_get_contents(), "alt") -1).'.png';
		// ob_end_clean();
		// var_dump($avatar);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//echo "<pre>"; var_dump($data); echo "</pre>";  die();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			// 'avatar' => $avatar,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $GLOBALS['commentCount'] = 0;
		return $this->render('view', [
            'model' => $this->findModel($id),
			]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		// $session = Yii::$app->session;
		// $session->open();
              
		// Yii::$app->assetManager->bundles = [
				// 'yii\web\JqueryAsset' => [
					// 'js'=>[]
				// ],
				// 'yii\bootstrap\BootstrapPluginAsset' => [
					// 'js'=>[]
				// ],
				// 'yii\bootstrap\BootstrapAsset' => [
					// 'css' => [],
				// ],
				// 'yii\web\YiiAsset' => [
					// 'js' => [],
				// ],
				// 'yii\validators\Validator' => [
					// 'js' => [],
				// ],
				// 'yii\widgets\ActiveFormAsset' => [
					// 'js' => [],
				// ]
			
		// ];
		
		$model = $this->findModel($id);
		session_start();
		$model->avatar_filename = $_SESSION['filename'];
//        $model =  UploadForm::findOne($id);
//        $model = $this->findUploadModel($id);
        // $model->save();     //
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// var_dump($session->getAllFlashes());
            return $this->redirect(['view', 'id' => $model->id]);
        }
		// var_dump($_SESSION);
/* 		if (Yii::$app->request->isPost) {
           // var_dump($_POST);
            $model->avatar_filename = $_SESSION['filename']; //UploadedFile::getInstance($model, 'avatar_filename');
			$model->avatar_filename = UploadedFile::getInstance($model, 'avatar_filename');
				var_dump($model);

            if ($model->avatar_filename 
				// && $model->validate()
				) {                
                $model->avatar_filename->saveAs('user/' . $model->avatar_filename->baseName . '.' . $model->avatar_filename->extension);
            }
            if ($model->upload()) {
                // file is uploaded successfully
	                Yii::$app->db->createCommand()->insert('user', [
						'name' => $model->attributes['name'],
						'category' =>  $model->attributes['category'],  //$form->field($model, 'category')->dropDownList($data),
						'description' => $model->attributes['description'],
						'filepath' => $model->attributes['filepath'],   
						//'uploads/'.
						Html::encode($model->imageFile->baseName).'.'.$model->imageFile->extension,
						'user' => !Yii::$app->user->isGuest ? Yii::$app->user->identity[username] : 'guest',
						'user_id' => Yii::$app->user->getId(),
						// Yii::$app->db->createCommand('SELECT id FROM user WHERE username='.Yii::$app->user->identity[username])->queryOne(),
						// 'username' => 'Имя пользователя',
						// 'email' => 'Email',
						// 'avatar_filename' => 'Аватарка пользователя',
						// 'age' => 'Возраст пользователя',
						])->execute();
				// echo($model->attributes);
                $session->setFlash('alert', 'Вы успешно обновили данные опубликованного изображения!');
                $session = Yii::$app->session;
                $session->addFlash('alerts', 'Вы успешно добавили новую аватарку.');
                return;
            }
        } */
        if (Yii::$app->request->isPost) {
       // echo "<pre>"; var_dump($model); echo "</pre>";
       // echo "<pre>"; var_dump(Yii::$app->request->isPost); echo "</pre>";
            //$model->avatar_filename = UploadedFile::getInstance($model, 'avatar_filename');
                

            if ($model->avatar_filename && $model->validate()) {                
                $model->avatar_filename->saveAs('user/' . $model->avatar_filename/* ->baseName . '.' . $model->avatar_filename->extension */);
                // вставить имя файла напрямую в БД
            }
        }
        // $model->avatar_filename = $_SESSION['filename'];
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->avatar_filename = UploadedFile::getInstance($model, 'avatar_filename');
            if ($model->upload()) {
                // file is uploaded successfully
                return;
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
    
    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findUploadModel($id)
    {
        if (($model = app\models\UploadForm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

// class UserName extends yii\db\ActiveRecord
// {
    // public function getId()
    // {
        // return $this->hasOne(Id::className(), ['username' => 'id']);
    // }
// }

// class Id extends yii\db\ActiveRecord
// {
    // public function getUserName()
    // {
        // return $this->hasOne(User::className(), ['id' => 'username']);
    // }
// }
