<?php

namespace app\controllers;

use app\models\User;
use yii\data\ActiveDataProvider;
use Codeception\Lib\Generator\Group;

/**
 * GroupController
 */
class GroupController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Group';
    
    /**
     * actionInfo
     *
     * @param  int $id
     */
    public function actionInfo(int $id) {
        $group = new $this->modelClass();
        return $this->asJson(
            $group->getGoupInfo($id)
        );
    }
}
