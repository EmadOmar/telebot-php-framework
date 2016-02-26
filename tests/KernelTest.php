<?php

use Telebot\Kernel;
use Telebot\Exceptions\InvalidUpdateInputException;

/**
 * Created by PhpStorm.
 * User: Emad Omar <emad2030@gmail.com>
 * Date: 2/26/2016
 * Time: 3:19 PM
 */
class KernelTest extends TestCase {

    protected $kernel;

    protected function setUp() {
        $botToken = $this->getVar('botToken');

        $this->kernel = new Kernel($botToken);
        $this->kernel->setErrorHandler(false);
    }

    public function testEmptyUpdateInput() {
        // When calling `Kernel#processUpdate()` with a null update (or with no arguments)
        // It'll attempt to get the update data from `php://input`.
        // Unfortunately, this cannot be mocked up, because `php://input` is read only.
        // Therefore we can only assert it's failure.
        $this->setExpectedException(InvalidUpdateInputException::class);

        $this->kernel->processUpdate();
    }

    public function testInvalidJsonData() {
        // Will be thrown due to the invalid json data string that is passed to `processUpdate()`
        $this->setExpectedException(InvalidUpdateInputException::class);

        $this->kernel->processUpdate(">_<");
    }

    public function testInvalidUpdateObject() {
        // Will be thrown due to the invalid update object that is passed to `processUpdate()`
        $this->setExpectedException(InvalidUpdateInputException::class);

        $this->kernel->processUpdate(new \StdClass);
    }

}