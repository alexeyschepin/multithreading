<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ParserException
 *
 * @author lex
 */
class ParserException extends CException {

    public function __construct($message = null, $code = 0) {
        parent::__construct($message, $code);
    }

}
