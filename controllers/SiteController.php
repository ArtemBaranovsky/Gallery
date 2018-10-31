<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\web\Session;
use yii\web\User;
use app\models\LoginForm;
use app\models\SignupForm;  //
use app\models\ContactForm;
use app\models\ImgsForm;
use app\models\sortImg;
// use app\models\User;    //
use yii\imagine\Image;
use yii\rbac\Rule;
use yii\rbac\AuthorRule;
use yii\data\Pagination;
use app\models\categories;
// use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;
	
class SiteController extends Controller
{

	 public function __toString() {
        //return $this->firstName . ' ' . $this->lastName;
    }
	
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model2 = sortImg::find();
		$model1 = categories::find()
			// ->indexBy('name')
			// ->select(['name'])		
			->orderby(['title'=>SORT_ASC])
			->asArray()
			->all();
		
		$model = ArrayHelper::getColumn($model1, 'title');
		
		$pagination = new Pagination([
			'defaultPageSize' => 15,
			'totalCount' => $model2->count(),
			]);
		
		if ($model === null) {
			throw new NotFoundHttpException;
		} 
		
		return $this->render('index', [
			'model' => $model2,
			'data'  => $model,
			'pagination' => $pagination,
		]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //ПОЛЬЗОВАТЕЛЬ УСПЕШНО АВТОРИЗОВАН. ТУТ ПИШЕМ СВОЙ КОД
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
	
	public function actionGallery($category=NULL)
    {
        // echo $category;
		
		return $this->render('gallery', ['category' => Html::encode($category)]);	//
    }


    /**
     * Displays signup page.
     *
     * @return string
     */
    public function actionSignup()
    {
        $session = Yii::$app->session;
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        /*$model = new User();
        // $model = new SignupForm();
        // $user = new User();

        $postRequest = Yii::$app->request->post();

        $isValidate = false;
        if($model->load($postRequest)){
            // echo "<pre>"; print_r($model); echo "<pre>"; exit;    //

            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    $session->setFlash('alert', 'Вы успешно зарегистрированы!');
                    // найти identity с указанным username.
                    // замечание: также вы можете проверить и пароль, если это нужно
                    $identity = User::findOne(['username' => $model['username']]);
                    // логиним пользователя
                    Yii::$app->user->login($identity);
                    return $this->goHome();
                }
            }*/
/*            if($model->validate()){
                // \yii\helpers\VarDumper::dump($model, 10, true);             exit;
                // var_dump($model, true);     //
                $model->save(false);    // чтобы 2 раза не валидировалось если validate()  отдельно от save  
                $isValidate = true;
            }
        }*/

        return $this->render('signup', ['model' => $model/*, 'isValidate'=>$isValidate*/]);
    }

	/* public function sortImg($sortBy)
	{
		// foreach ($items as $key => $value){
			// $categories[]=$items[$key][category];
	} */ 
	

	public function actionImgs()
    {
        /*$model = new ImgsForm();
        if ($model->load(Yii::$app->request->post()) && $model->imgs(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('imgsFormSubmitted');

            return $this->refresh();
        }
        return $this->render('imgs', [
            'model' => $model,
        ]);*/

// временное действие по созданию миниатюр изображений
		// $files = scandir('W:\domains\localhost\yii2-app-basic\web\uploads');
		/*$files=\yii\helpers\FileHelper::findFiles('W:\domains\localhost\yii2-app-basic\web\uploads');
		foreach ($files as $file){
			// echo mb_substr(Html::encode($file),20, strlen(Html::encode($file)) )."<br>";
			// echo strpos($file, 'uploads')."<br>";
			
			if (strpos(iconv('windows-1251','utf-8',$file), 'thumb')) continue;
			$fileName = iconv('windows-1251','utf-8',(Yii::getAlias(mb_substr($file,mb_strpos($file,'uploads')+8,strlen($file)-mb_strpos($file,'uploads/')))));
			// echo 'uploads/thumb/'.$fileName;	
			// echo $fileName."<br>";	
			// echo $file."<br>";
			// if (!file_exists(iconv('windows-1251','utf-8',(Yii::getAlias('uploads/thumb/'.mb_substr($file,mb_strpos($file,'uploads')+8,strlen($file)-mb_strpos($file,'uploads/'))))))) continue;
			if (file_exists(Html::encode('W:\domains\localhost\yii2-app-basic\web\uploads\\'.$fileName))) continue;
			Image::thumbnail(iconv('utf-8','windows-1251','W:\domains\localhost\yii2-app-basic\web\uploads\\'.$fileName), 100, 100)->save(iconv('utf-8','windows-1251','uploads/thumb/'.$fileName), ['quality' => 80]);
			// echo iconv('windows-1251','utf-8',$file)."<br>";
		}
	*/	
		
		$session = Yii::$app->session;
        // echo $session->getFlash('alert');
		// var_dump(); die();
// var_dump(Yii::$app->user->getId()); die();
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
				return $this->redirect(['imgs']);		// поставить относительный редирект!!
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
		// var_dump($model4); die();

		
		// if (\Yii::$app->user->can('createPost'));
		
		// определяем роль пользователя
		// echo Yii::$app->user->id; die();
		$role = Yii::$app->db->createCommand('SELECT item_name FROM auth_assignment WHERE user_id='.Yii::$app->user->id)->queryOne();			
		// var_dump(Yii::$app->user->identity); die();

		return $this->render('imgs', [
			'data'  => $data,		// дублированный перечень категорий (2 одинаковых колонки)
			'model1' => $data1,	// перечень категорий
			'model' => $model,		// модель ImgsForm
			'userRole' => $role["item_name"]
		]);		
    
		
    }

/*    public function actionTest() {
        $cat = Yii::$app->request->get('category');//$_GET['category']
        $categories = new ImgsForm;
        $data = $categories->getData($cat);
        return $this->render('test', ['categories' => $data]);
    }*/

    public function actionGetcategories($category = NULL) {
        if (is_null($category)) {
			$query = \app\models\ImgsForm::find()/* ->where(['category' => $category]) */;
		} else {
			$query = \app\models\ImgsForm::find()->where(['category' => $category]);
		}
					// var_dump($query); die();
		$pagination = new Pagination([
			'defaultPageSize' => 15,
			'totalCount' => $query->count(),
		]);
		// $Images = $query->orderBy('id')
			// ->offset(($_GET['page'] - 1) * 15 + 1)	// ($_GET['page'] - 1) * itemsPerPage + 1
			// ->limit($pagination->limit)
			// ->all(); 
		// echo ($_GET['page'] - 1) * 15 + 1;
		$cat = Yii::$app->request->get('category'); //получаем название активной категории из представления $_GET['category']
        $categories = new ImgsForm;
        $data = $categories->getData($cat);     // получаем функцией getData из БД через модель models\ImgsForm.php параметры ['categories', 'items'] 
        // \yii\helpers\VarDumper::dump($data, 10, true);
        // exit;
/*        \yii\helpers\VarDumper::dump($data, 10, true);
        exit;*/
        // echo "<pre>"; var_dump ($data); echo "</pre>";
		
		// $dataProvider = new ActiveDataProvider([ 'query' => \app\models\ImgsForm::find()->orderBy('id DESC'), 'pagination' => array('pageSize' => 15), ]);
        return $this->render('gallery', [
			'categories' => $data, 			   //  передаем в вид gallery массив параметров $categories
			// 'dataProvider' => $dataProvider,
			'pagination' => $pagination]);
    }

    public function behaviors()     //  ACF 
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
				    'denyCallback' => function ($rule, $action) {
						throw new \Exception('У вас нет доступа к этой странице');
					},
                'only' => ['create', 'update'], 
                'rules' => [
                    [
                        'allow' => true,
						// 'only' => ['login', 'signup', 'view', 'error'], 	 // Параметр only указывает, что фильтр ACF нужно применять только перечисленным действиям 
                        'actions' => ['login', 'signup', 'view', 'error'],   // разрешенные действия, для которых применять гостевой фильтр 
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
						// 'only' => ['logout', 'view', 'create', 'update'],  
                        'actions' => ['logout', 'view'],
                        'roles' => ['@'],                   // разрешенные действия, для которых применять фильтр  аутентифицированных пользователей 
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin'],               // разрешенные действия, описанные в rbacController, для которых применять фильтр admin    
                    ],

                    // Если права на все CRUD операции выдаются вместе, то лучшее решение в этом случае — завести одно разрешение вроде managePost и проверять его в yii\web\Controller::beforeAction().                  
/*                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['managePost'],
                    ],*/
                    // [
                    //     'allow' => true,
                    //     'actions' => ['view'],
                    //     'roles' => ['viewPost'],
                    // ],
                    // [
                        // 'allow' => true,
                        // 'actions' => ['update'],
                        // 'roles' => ['isAuthor/*updatePost*/'],
                        // 'roleParams' => function() {
                            // return ['imgs' => Post::findOne(['id' => Yii::$app->request->get('id')])];
                        // },
                    // ],
                    // [
                        // 'allow' => true,
                        // 'actions' => ['delete'],
                        // 'roles' => ['deletePost'],
                    // ],
                ],
            ],
/*            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get', 'post'],
                ],
            ],*/
        ];
    }

/*    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        } else {
            return false;
        }
    }*/
 
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
 
        return $this->_user;
    }

    public function actionRole()
    {
        $auth = Yii::$app->authManager;
		$admin = Yii::$app->authManager->createRole('admin');   // создаем роль админа
        $admin->description = 'Администратор';
        // Yii::$app->authManager->add($admin);


        $content = Yii::$app->authManager->createRole('content');   // создаем роль content manager
        $content->description = 'Контент  менеджер';
        // Yii::$app->authManager->add($content);

        $author = Yii::$app->authManager->createRole('author');
        $author->description = 'Автор';
        // Yii::$app->authManager->add($author);

        $ban = Yii::$app->authManager->createRole('banned');
        $ban->description = 'Заблокированный пользователь';
        // Yii::$app->authManager->add($ban);
		// $auth->addChild($admin, $canAdmin);
		

		            // add the rule
            $rule = new \app\rbac\AuthorRule;
            // $auth->add($rule);
			
            $rule = new \app\rbac\AdminRule;
            // $auth->add($rule);


			// $auth = Yii::$app->authManager;

             // добавляем разрешение "updateOwnPost" и привязываем к нему правило.
            $updateOwnPost = $auth->createPermission('updateOwnPost');
            $updateOwnPost->description = 'Update own post';
            $updateOwnPost->ruleName = $rule->name;
            // $auth->add($updateOwnPost);

			$updatePost = $auth->createPermission('updatePost');
			$updatePost->description = 'Update post';
			// $auth->add($updatePost);
            // "updateOwnPost" будет использоваться из "updatePost"
            // $auth->addChild($updateOwnPost, $updatePost);
			
			// $updatePost->ruleName = $rule->name;
			
            // разрешаем "автору" обновлять его посты
            // $auth->addChild($author, $updateOwnPost);
 
/*        $userRole = Yii::$app->authManager->getRole('admin');
		Yii::$app->authManager->assign($userRole, 42);*/

		return 12345;
    }

	public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем разрешение "createPost"
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // добавляем разрешение "updatePost"
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // добавляем роль "author" и даём роли разрешение "createPost"
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        $auth->assign($author, 50);
        $auth->assign($author, 48);
        $auth->assign($admin, 49);
		
		// add the rule
		$rule = new \app\rbac\AuthorRule;
		$auth->add($rule);

		// добавляем разрешение "updateOwnPost" и привязываем к нему правило.
		$updateOwnPost = $auth->createPermission('updateOwnPost');
		$updateOwnPost->description = 'Update own post';
		$updateOwnPost->ruleName = $rule->name;
		$auth->add($updateOwnPost);

		// "updateOwnPost" будет использоваться из "updatePost"
		$auth->addChild($updateOwnPost, $updatePost);

		// разрешаем "автору" обновлять его посты
		$auth->addChild($author, $updateOwnPost);
    }
}

/*use yii\filters\AccessControl;
public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::className(),
            'only' => ['create', 'update'],
            'rules' => [
            // разрешаем аутентифицированным пользователям
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            // всё остальное по умолчанию запрещено
            ],
        ],
    ];

}*/
