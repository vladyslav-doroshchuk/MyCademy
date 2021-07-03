<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group".
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 *
 * @property User[] $users
 */
class Group extends \yii\db\ActiveRecord
{
    public $oldest_user;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['group_id' => 'id']);
    }

    
    /**
     * getGoupInfo
     *
     * @param  mixed $id
     * @return void
     */
    public function getGoupInfo(int $id)
    {
        $users = \Yii::$app->getDb()->createCommand("
            SELECT
                `group`.*,
                (SELECT email
                FROM user
                WHERE birth_date = MAX(u.birth_date) LIMIT 1) AS youngest_user,
                (SELECT email
                FROM user
                WHERE birth_date = MIN(u.birth_date) LIMIT 1) AS oldest_user,
                FLOOR(AVG(DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), u.birth_date)), '%Y'))) AS avg_age
                FROM user u
                JOIN `group` ON `group`.`id` = u.group_id
                WHERE u.group_id IN
                    (SELECT id
                    FROM
                    (SELECT *
                        FROM `group`
                        ORDER BY parent_id, id) group_sorted,
                    (SELECT @pv := :id) initialisation
                    WHERE FIND_IN_SET(parent_id, @pv)
                    AND LENGTH(@pv := CONCAT(@pv, ',', id))
                    UNION SELECT :id)
                GROUP BY u.group_id", [':id' => $id])
            ->queryAll();

        $parentId = $this->getParentId($users, $id);

        return !empty($users) && $parentId ? $this->buildTree($users, $parentId) : [];
    }
    
    /**
     * buildTree
     *
     * @param  mixed $users
     * @param  mixed $parentId
     * @param  mixed $rootId
     */
    private function buildTree(array $users, int $parentId = 0, int $rootId = 0) {
        $usersInGroups = [];
        foreach ($users as $element) {
            if ($element['parent_id'] == $parentId) {
                unset($element['parent_id']);
                $children = $this->buildTree($users, $element['id'], $rootId);
                if ($children) {
                    $element['child_groups'] = $children;
                }
                $usersInGroups[] = $element;
            } 
        }
        return $usersInGroups;
    }
      
    /**
     * getParentId
     *
     * @param  mixed $users
     * @param  mixed $id
     */
    private function getParentId(array $users, int $id)
    {
        foreach ($users as $user) { 
            if ($user['id'] == $id) {
                return $user['parent_id'];
            }
        }
        return null;
    }

}
