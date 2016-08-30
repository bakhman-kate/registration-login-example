<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160829_094916_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name' => $this->string(55),
            'email' => $this->string(55)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull()->unique(),
            'access_token' => $this->string(32)->notNull()->unique(),
        ]);
        
        $this->insert('user', [
            'name' => 'Test User Name',
            'email' => 'user1@example.com',
            'auth_key' => 'OqeJuB3YoTIvo13g',
            'access_token' => '578FiZIb9kEcaCU3',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('user', ['id' => 1]);
        $this->dropTable('user');
    }
}
