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

    public function run2($args) {
//        $parser = new KinopoiskParser('http://www.kinopoisk.ru/film/694051/');
//        $imdbParser = new ImdbParser('http://www.imdb.com/title/tt2293640/?ref_=hm_cht_t1');
//        $imdbParser->run();

        while (true) {
            $url = Yii::app()->cache->get('task');
            echo 'url: ' . $url . PHP_EOL;
            if ($url) {
                Yii::app()->cache->delete('task');
                $pid = pcntl_fork();
                if ($pid == -1) {
                    // error
                } elseif ($pid) {
                    // parent
                } else {
                    echo 'pid: ' . $pid . PHP_EOL;
                    if (strpos($url, 'kinopoisk.ru') !== false) {
                        $parser = new KinopoiskParser($url);
                    } elseif (strpos($url, 'imdb.com') !== false) {
                        $parser = new ImdbParser($url);
                    } else {
                        
                    }
                    $parser->run();
                    echo 'parsing done' . PHP_EOL;
                    exit;
                }
            }
            echo 'here';
            sleep(1 * 1000);
        }
        echo 'done';
    }

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
