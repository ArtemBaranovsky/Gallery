<?php
namespace app\rbac;

use yii\rbac\Rule;
use app\models\Imgs;

//правило будет следить за тем что, является ли авторм данного поста администратор.
class AdminRule extends Rule
{
    public $name = 'isAdmin';

    /**
     * @param string|integer $user ID пользователя.
     * @param Item $item роль или разрешение с которым это правило ассоциировано
     * @param array $params параметры, переданные в ManagerInterface::checkAccess(), например при вызове проверки
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
		if (isset($params['user']) and ($params['user'] == $user_id)){
			return true;
		} else {
			return false;
		}
		// return isset($params['imgs']) ? $params['imgs']->createdBy == $user : false;
        // return isset($params['news']) ? $params['news']->createdBy == $user : false;
    }
}