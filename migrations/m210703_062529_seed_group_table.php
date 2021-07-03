<?php

use yii\db\Migration;

/**
 * Class m210703_062529_seed_group_table
 */
class m210703_062529_seed_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    private $id = 1;

    public function safeUp() {
        $this->insertGroups();
    }
    
    private function insertGroups() 
    {
        $this->insertData($this->id, 'root', 0);
        for ($i = 1; $i < 4; $i++) {
            $parentIdLvlOne = $this->id;
            $this->insertData($this->id, "Group $i", 1);
            for ($j = 1; $j < 4; $j++) {
                $parentIdLvlTwo = $this->id;
                $this->insertData($this->id, "Group $i.$j", $parentIdLvlOne);
                for ($y = 1; $y < 4; $y++) {
                    $this->insertData($this->id, "Group $i.$j.$y", $parentIdLvlTwo);
                }
            }
        }
    }

    private function insertData(int $id, string $name, int $parentId)
    {
        $this->insert(
            'group',
            [
                'id' => $id,
                'name' => $name,
                'parent_id' => $parentId
            ]
        );
        $this->id++;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('group');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210703_062529_seed_group_table cannot be reverted.\n";

        return false;
    }
    */
}
