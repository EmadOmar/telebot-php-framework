<?php

/**
 * Created by PhpStorm.
 * User: Emad Omar <emad2030@gmail.com>
 * Date: 2/26/2016
 * Time: 3:18 PM
 */
abstract class TestCase extends PHPUnit_Framework_TestCase {

    protected function getVar($key) {
        $vars = [
            'botToken' => '198228604:AAH8GoUt8mfZT-_9h3ZRaMxVTpAkNRk8Y6c',
        ];

        return $vars[ $key ];
    }

}