<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ParseCommand
 *
 * @author lex
 */
class ParseCommand extends CConsoleCommand {
    
    const MAX_CHILD_PROCESSES = 10;
    const DELAY = 5; // seconds
    
    protected $stopServer = false;

    public function run($args) {
        $childProcesses = array();

        while (!$this->stopServer) {
            // get task with url from redis
            $url = Yii::app()->cache->get('task');
            Yii::app()->cache->delete('task');
            
            // if task exists, server runs, etc.
            if ($url && !$this->stopServer && (count($childProcesses) < self::MAX_CHILD_PROCESSES)) {
                $pid = pcntl_fork();
                if ($pid == -1) {
                    // TODO: throw exception
                } elseif ($pid) {
                    // store $child pid
                    $childProcesses[$pid] = true;
                } else {
                    $pid = getmypid();
                    
                    if (strpos($url, 'kinopoisk.ru') !== false) {
                        $parser = new KinopoiskParser($url);
                    } elseif (strpos($url, 'imdb.com') !== false) {
                        $parser = new ImdbParser($url);
                    } else {
                        // no parser
                    }
                    $parser->run();
                    exit;
                }
            } else {
                sleep(self::DELAY);
            }
            // check if child is dead
            while ($signaledPid = pcntl_waitpid(-1, $status, WNOHANG)) {
                if ($signaledPid == -1) {
                    // no children
                    $childProcesses = array();
                    break;
                } else {
                    unset($childProcesses[$signaledPid]);
                }
            }
        }
    }

}
