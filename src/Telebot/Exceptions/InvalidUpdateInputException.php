<?php
/**
 * Created by PhpStorm.
 * User: Emad Omar <emad2030@gmail.com>
 * Date: 2/26/2016
 * Time: 4:39 PM
 */

namespace Telebot\Exceptions;

/**
 * Class InvalidUpdateInputException
 * @package Telebot\Exceptions
 */
class InvalidUpdateInputException extends Exception {

    public function __construct($message = "", Exception $previous = null) {
        parent::__construct($message, 403, $previous);
    }

}