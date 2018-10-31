<?php
// namespace console\controllers;
namespace app\commands;

use Yii;
use yii\console\Controller;
use common\components\rbac\UserRoleRule;

class RbacController extends Controller
{
    public function actionInit()
    {
/*         $auth = Yii::$app->authManager;
        $auth->removeAll(); //������� ������ ������

        //�������� ��� ������� ����� ��� ������� � �������
        $dashboard = $auth->createPermission('adminPanel');
        $dashboard->description = '����� ������';
        $auth->add($dashboard);

        //��������� ����
        $user = $auth->createRole('user');
        $user->description = '������������';
        $auth->add($user);

        $moder = $auth->createRole('moder');
        $moder->description = '���������';
        $auth->add($moder);

        //��������� ��������
        $auth->addChild($moder, $user);
        $auth->addChild($moder, $dashboard);

        $admin = $auth->createRole('admin');
        $admin->description = '�������������';
        $auth->add($admin);
        $auth->addChild($admin, $moder);
		 */

		 
 		        $auth = Yii::$app->authManager;

        // ��������� ���������� "createPost"
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        // $auth->add($createPost);

        // ��������� ���������� "updatePost"
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        // $auth->add($updatePost);

        // ��������� ���� "author" � ��� ���� ���������� "createPost"
        $author = $auth->createRole('author');
        // $auth->add($author);
        $auth->addChild($author, $createPost);

        // ��������� ���� "admin" � ��� ���� ���������� "updatePost"
        // � ����� ��� ���������� ���� "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        // ���������� ����� �������������. 1 � 2 ��� IDs ������������ IdentityInterface::getId()
        // ������ ����������� � ������ User.
        // $auth->assign($author, 50);
        // $auth->assign($admin, 49);

 
		$auth = Yii::$app->authManager;

// add the rule
$rule = new \app\rbac\AuthorRule;
$auth->add($rule);

// ��������� ���������� "updateOwnPost" � ����������� � ���� �������.
$updateOwnPost = $auth->createPermission('updateOwnPost');
$updateOwnPost->description = 'Update own post';
$updateOwnPost->ruleName = $rule->name;
$auth->add($updateOwnPost);

// "updateOwnPost" ����� �������������� �� "updatePost"
$auth->addChild($updateOwnPost, $updatePost);

// ��������� "������" ��������� ��� �����
$auth->addChild($author, $updateOwnPost);

		}
}