<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;
use app\models\SortImg;

// use yii\rbac\UpdateOwnPostPermission;


class RbacController extends Controller
{
    public function actionInit()
    {

		//Назначение роли так же делается через authManager
		// $userRole = Yii::$app->authManager->getRole('isAuthor');
		// Yii::$app->authManager->assign($userRole, 51 /* $user->getId() */);
		
		// Важно то, что привязывать к пользователю можно не только роль, но и право.
		// $permit = Yii::$app->authManager->getPermission($permit);
		// Yii::$app->authManager->assign($permit, 51 /* $user->getId() */);

/*		// консольная комманда для ввода UserGroupRule в таблицу auth_rule
 		$auth = Yii::$app->authManager;

		$rule = new \app\rbac\UserGroupRule;
		$auth->add($rule);

		$author = $auth->createRole('author');
		$author->ruleName = $rule->name;
		$auth->add($author);
		// ... add permissions as children of $author ...

		$admin = $auth->createRole('admin');
		$admin->ruleName = $rule->name;
		$auth->add($admin);
		$auth->addChild($admin, $author); */
		
/*          $auth = Yii::$app->authManager;
		

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
		$auth->addChild($author, $updateOwnPost);  */
				
/* 		// добавляем разрешение "createPost"
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);
		
		// добавляем роль "author" и даём роли разрешение "createPost"
        $author = $auth->createRole('author');
        $auth->add($author);	
        $auth->addChild($author, $createPost);
		$auth->assign($author, 50); */
/*         //         // добавляем разрешение "createPost"
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
        $auth->assign($author, 2);
        $auth->assign($admin, 1); */
		
		// $auth = Yii::$app->authManager;
 
/* // добавляем правило
$rule = new \app\rbac\AuthorRule;
$auth->add($rule);
 
// добавляем право "updateOwnPost" и связываем правило с ним
$updateOwnPost = $auth->createPermission('updateOwnPost');
$updateOwnPost->description = 'Редактировать посты';
$updateOwnPost->ruleName = $rule->name;
$auth->add($updateOwnPost);
 
// "updateOwnPost" наследует право "updatePost"
$updatePost = Yii::$app->authManager->getPermission('updatePost');
$auth->addChild($updateOwnPost, $updatePost);
 
$author = Yii::$app->authManager->getRole('author');
// и тут мы позволяем автору редактировать свои посты
$auth->addChild($author, $updateOwnPost); */


/* // добавляем разрешение
$rule = new \app\rbac\UpdateOwnPostRule;
$auth->add($rule);
 
// добавляем разрешение "updateOwnPost" и связываем правило с ним
$updateOwnPost = $auth->createPermission('updateOwnPost');
$updateOwnPost->description = 'Редактировать свои посты';
$updateOwnPost->ruleName = $rule->name;
$bizRule='return (\Yii::$app->user->identity->attributes[username] == SortImg::findOne($_GET[id])->user)'; 
$rule=$auth->createTask('UpdateOwnPost','update own post',$bizRule);
// $rule->addChild('UserUpdate');
// $auth->createOperation($updateOwnPost);
// $task=$auth->createRule('updateOwnPost','редактирование своей записи',$bizRule);
$auth->add($updateOwnPost); */

$auth = Yii::$app->authManager;
$createPost = $auth->createPermission('createPost');
$createPost->description = 'Create a post';
$updatePost = $auth->createPermission('updatePost');
$updatePost->description = 'Update a post';
$deletePost = $auth->createPermission('deletePost');
$deletePost->description = 'Delete a post';
$readPost = $auth->createPermission('readPost');
$readPost->description = 'Read a post';
$authorRule = new \app\rbac\AuthorRule();
// add permissions
$auth->add($createPost);
$auth->add($updatePost);
$auth->add($deletePost);
$auth->add($readPost);
$auth->add($authorRule);
// add the "updateOwnPost" permission and associate the rule with it.
$updateOwnPost = $auth->createPermission('updateOwnPost');
$updateOwnPost->description = 'Update own post';
$updateOwnPost->ruleName = $authorRule->name;
$auth->add($updateOwnPost);
$auth->addChild($updateOwnPost, $updatePost);
// create Author role
$author = $auth->createRole('author');
$auth->add($author);
$auth->addChild($author, $createPost);
$auth->addChild($author, $updateOwnPost);
$auth->addChild($author, $readPost);
// create Admin role
$admin = $auth->createRole('admin');
$auth->add($admin);
$auth->addChild($admin, $updatePost);
$auth->addChild($admin, $deletePost);
$auth->addChild($admin, $author);
// assign roles
// $auth->assign($admin, User::findByUsername('legat')->id);
$auth->assign($author, 49);
echo "Done!\n";
 
    }
}