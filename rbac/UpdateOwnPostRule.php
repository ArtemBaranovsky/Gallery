<?php

namespace app\rbac;

use Yii;
use yii\rbac\Rule;
use app\models\Imgs;
use app\models\SortImg;

/**
 * Проверяем authorID на соответствие с пользователем, переданным через параметры
 */
class UpdateOwnPostRule extends Rule
{
    public $name = 'updateOwnPost';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user_id, $item, $params)
    {	// Правило проверяет, что imgs был создан $user
        
		var_dump(SortImg::findOne($user_id)->user);
		// var_dump($imgs_author);
		echo $user.' updateOwnPost';
		// die();
		return isset($params['post']) ? $params['post']->createdBy == $user : false;
		// return (isset($params)? $params["imgs_author"] == $params["user"]: false) ? true : false;
        // return (\Yii::$app->user->identity->attributes[username] == SortImg::findOne($_GET[id])->user) ? true : false;
    }
}
