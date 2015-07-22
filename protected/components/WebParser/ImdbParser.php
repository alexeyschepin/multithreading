<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImdbParser
 *
 * @author lex
 */
class ImdbParser extends WebParser {
    
    protected function extractCountry() {
        $elements = $this->html->find('#titleDetails')[0]->children(3)->find('a');
        $this->movie->country = $elements[0]->innertext();
    }

    protected function extractDirector() {
        $elements = $this->html->find('div[itemprop="director"] a span');
        $this->movie->director = $elements[0]->innertext();
    }

    protected function extractImage() {
        $elements = $this->html->find('#img_primary .image img');
        $this->movie->image = $elements[0]->src;
    }

    protected function extractTitle() {
        $elements = $this->html->find('h1 span.itemprop');
        $this->movie->title = $elements[0]->innertext();
    }

}
