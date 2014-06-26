<?php

use yii\db\Schema;

class m140626_091530_translation_message extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('source_message', [
            'id'    => Schema::TYPE_PK,
            'category'  => Schema::TYPE_STRING,
            'message'   => Schema::TYPE_TEXT
        ]);
        $this->createTable('message', [
            'id'    => Schema::TYPE_PK,
            'language'  => Schema::TYPE_STRING,
            'translation'   => Schema::TYPE_TEXT
        ]);
        $this->addForeignKey('fk_message_source_message', 'message', 'id', 'source_message', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_message_source_message', 'message');
        $this->dropTable('message');
        $this->dropTable('source_message');

        return true;
    }
}
