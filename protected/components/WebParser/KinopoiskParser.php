<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KinopoiskParser
 *
 * @author lex
 */
class KinopoiskParser extends WebParser {
    
    protected function extractCountry() {
        
    }

    protected function extractDirector() {
        
    }

    protected function extractImage() {
        
    }

    protected function extractTitle() {     
        $elements = $this->html->find('h1.moviename-big');
        $this->movie->title = $elements[0]->innertext();
    }

}
