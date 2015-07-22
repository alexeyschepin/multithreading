<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Redis
 *
 * @author lex
 */
class RedisCommand extends CConsoleCommand {
    
    public function actionSet($key, $value) {
        Yii::app()->cache->set($key, $value);
    }
    
    public function actionGet($key) {
        echo Yii::app()->cache->get($key) . PHP_EOL;
    }
    
}
