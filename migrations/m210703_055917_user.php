<?php

use yii\db\Migration;

/**
 * Class m210703_055917_user
 */
class m210703_055917_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255)->notNull(),
            'birth_date' => $this->dateTime(),
            'group_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-user-group_id',
            'user',
            'group_id',
            'group',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-unique-user-email',
            'user',
            'email',
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user-group_id','user');
        $this->dropIndex('idx-unique-user-email', 'user');
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210703_055917_user cannot be reverted.\n";

        return false;
    }
    */
}
