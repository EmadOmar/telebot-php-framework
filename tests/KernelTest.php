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

    /**
     * @var Kernel
     */
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

    public function testValidUpdate() {
        $this->kernel->setHandlers([
            'command' => function ($update) {
                throw new \Exception("A command received");

                return [];
            },
        ]);

        $this->setExpectedException(\Exception::class, 'A command received');

        $this->kernel->processUpdate(
            json_encode($this->genUpdate(
                ['message' => ['text' => '/start']]
            ))
        );
    }

    public function testTextUpdate() {
        $this->kernel->setHandlers([
            'text' => function ($update) {
                throw new \Exception("A text received");

                return [];
            },
        ]);

        $this->setExpectedException(\Exception::class, 'A text received');

        $this->kernel->processUpdate(
            json_encode($this->genUpdate(
                ['message' => ['text' => 'Hello World!']]
            ))
        );
    }

    public function testMediaUpdate() {
        $this->kernel->setHandlers([
            'media' => function ($update) {
                throw new \Exception("A media received");

                return [];
            },
        ]);

        $this->setExpectedException(\Exception::class, 'A media received');

        $this->kernel->processUpdate(
            json_encode($this->genUpdate([
                'message' => [
                    'photo' => [
                        ["file_id" => uniqid(), "file_size" => 1053, "width" => 90, "height" => 90,],
                    ],
                ],
            ]))
        );
    }

    protected function genUpdate($data) {
        $update = [
            "update_id" => rand(10, 99999),
            "message" => [
                "message_id" => rand(10, 99),
                "from" => [
                    "id" => rand(10, 999),
                    "first_name" => "Some",
                    "last_name" => "One",
                    "username" => "SomeOne",
                ],
                "chat" => [
                    "id" => rand(10, 99999),
                    "first_name" => "Some",
                    "last_name" => "One",
                    "username" => "SomeOne",
                    "type" => "private",
                ],
                "date" => time(),
            ],
        ];

        return array_merge_recursive($update, $data);
    }

}