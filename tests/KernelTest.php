<?php
use Telebot\Kernel;

/**
 * Created by PhpStorm.
 * User: Emad Omar <emad2030@gmail.com>
 * Date: 2/26/2016
 * Time: 3:19 PM
 */
class KernelTest extends TestCase {

    public function testKernel() {
        $botToken = $this->getVar('botToken');

        $kernel = new Kernel($botToken);

        $this->assertInstanceOf(Kernel::class, $kernel);
    }

}