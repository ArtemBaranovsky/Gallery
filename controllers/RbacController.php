<?php
namespace app\controllers;

use Yii;
use yii\controllers;
use yii\web\Controller;
use app\rbac\UserRoleRule;
use app\controllers\RbacController; 
// use app\controllers\Controller; 

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
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
    }
}