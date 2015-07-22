<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebParser
 *
 * @author lex
 */
abstract class WebParser {
    
    protected $movie;
    protected $simpleHtml;
    protected $url;
    protected $html;
    
    protected abstract function extractTitle();
    protected abstract function extractCountry();
    protected abstract function extractDirector();
    protected abstract function extractImage();
    
    public function __construct($url) {
        $this->url = $url;
        $this->simpleHtml = new SimpleHTMLDOM();
    }
    
    // Start parsing
    public function run() {
        $this->html = $this->simpleHtml->file_get_html($this->url);
        $this->movie = new Movie();
        
        // TODO: throw exception if HTTP status is not 200
        
        // Extract data
        $this->extractTitle();
        $this->extractCountry();
        $this->extractDirector();
        $this->extractImage();
        
        // store movie
        $this->movie->save();
        
        echo "Movie {$this->movie->title} has been parsed" . PHP_EOL;
    }

}
