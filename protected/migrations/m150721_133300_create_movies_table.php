<?php

class m150721_133300_create_movies_table extends CDbMigration {
    
    public function up() {
        $this->createTable('tbl_movies', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
            'country' => 'string NOT NULL',
            'director' => 'string NOT NULL',
            'image' => 'string NOT NULL',
        ));
    }

    public function down() {
        $this->dropTable('tbl_news');
    }
    
}