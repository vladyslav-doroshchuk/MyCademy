<?php

use yii\db\Migration;

/**
 * Class m210703_062542_seed_user_table
 */
class m210703_062542_seed_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->insertUsers();
    }
    
    private function insertUsers() 
    {
        for ($i = 2; $i < 41; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $this->insertData($i);
            }
        }
    }

    private function insertData(int $groupId)
    {

        $faker = \Faker\Factory::create();
        $this->insert(
            'user',
            [
                'email' => $faker->email,
                'birth_date' => $faker->date(),
                'group_id' => $groupId
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210703_062542_seed_user_table cannot be reverted.\n";

        return false;
    }
    */
}
