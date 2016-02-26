<?php
/**
 * Created by PhpStorm.
 * User: Emad Omar <emad2030@gmail.com>
 * Date: 2/26/2016
 * Time: 11:19 AM
 */

namespace Telebot;


class Kernel {

    protected $botToken;

    public function __construct($botToken) {
        
    }

    /**
     * @param null|string|json|Update $update
     */
    public function processUpdate($update = null) {

    }

}