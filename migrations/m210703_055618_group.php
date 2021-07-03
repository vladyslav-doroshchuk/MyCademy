<?php

use yii\db\Migration;

/**
 * Class m210703_055618_group
 */
class m210703_055618_group extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('group', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'parent_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('group');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210703_055618_group cannot be reverted.\n";

        return false;
    }
    */
}
