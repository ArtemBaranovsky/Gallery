<?php

namespace app\rbac;

use Yii;
use yii\rbac\Rule;
use app\models\SortImg;

/**
 * Проверяем authorID на соответствие с пользователем, переданным через параметры
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user_id, $item, $params)
    {	// Правило проверяет, что imgs был создан $user
        // return isset($params['imgs']) ? $params['imgs'] == $user_id : false;
		// return isset($params['post']) ? $params['post']->createdBy == $user_id : false;
		// echo $model->name.'<br>';
		// echo '<pre>';  print_r($params); echo '</pre>'; exit;  
		// if (isset($params['imgs']) and ($params['imgs'] == $user_id)){
			// return true;
		// } else {
			// return false;
		// }
		// var_dump($user_id, $item, $params, $_GET, SortImg::findOne($_GET[id])->user_id);
		// var_dump($params['imgs']->user_id, $user_id);
		// echo $user.' isAuthor rule';
		// die();
		// return ($user_id == SortImg::findOne($_GET[id])->user_id) ? true : false;
		return isset($params['imgs']) ? $params['imgs']->user_id == $user_id : false;
    }
}
