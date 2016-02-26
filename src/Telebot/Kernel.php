<?php
/**
 * Created by PhpStorm.
 * User: Emad Omar <emad2030@gmail.com>
 * Date: 2/26/2016
 * Time: 11:19 AM
 */

namespace Telebot;

use Telebot\Exceptions\Exception;
use Telebot\Exceptions\InvalidUpdateInputException;
use TelebotSDK\Update;

class Kernel {

    /**
     * The token of the bot
     * @var string
     */
    protected $botToken;

    /**
     * Error handler
     *
     *      null: (default) The internal handler.
     *      boolean:
     *          false: An exception will be raised when an error occurred.
     *          true: Silent mode, execution will stop, but no exceptions will be raised.
     *      callable: A callable function, that will be called when an error occurs.
     *
     * @var boolean|callable|null
     */
    protected $errorHandler;

    /**
     * Response data
     * @var array
     */
    protected $response;

    public function __construct($botToken) {
        $this->botToken = $botToken;
    }

    /**
     * @param null|string|json|Update $update
     *
     * @return null
     * @throws InvalidUpdateInputException
     */
    public function processUpdate($update = null) {
        if ($update == null) {
            $update = file_get_contents('php://input');

            // Check if update input still empty
            if ($update == null) {
                return $this->handleError(
                    new InvalidUpdateInputException('Update input was empty.')
                );
            }
        }

        if (is_string($update)) {
            // Decoded to check if JSON string is valid
            $update = json_decode($update);

            // If `$update` is not an object, this is because the JSON string was invalid
            if (!is_object($update)) {
                return $this->handleError(
                    new InvalidUpdateInputException(
                        'Could\'nt parse JSON:Invalid JSON data syntax.'
                    )
                );
            }

            // Re encoded to pass it to the parser
            $update = Update::parse(json_encode($update));
        }

        if (!($update instanceof Update)) {
            return $this->handleError(
                new InvalidUpdateInputException(
                    '`$update` must be an object of type `' . Update::class . '`.'
                    . ' `' . get_class($update) . '` is given.'
                )
            );
        }

        $this->handleUpdate($update);
    }

    public function showResponse() {

    }

    /**
     * @param boolean|callable|null $errorHandler
     */
    public function setErrorHandler($errorHandler) {
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param Exception $exception
     *
     * @return null
     * @throws Exception
     */
    protected function handleError($exception) {
        if (is_callable($this->errorHandler)) {
            call_user_func($this->errorHandler, $exception);
        } else if ($this->errorHandler === false) {
            throw $exception;
        } else if ($this->errorHandler === true) {
            // Just ignore. Silence is golden (not sure this time)
            return;
        }

        $this->renderResponse([], $exception->getCode());
    }

    /**
     * @param array $data
     * @param int $status
     */
    protected function renderResponse(array $data, $status = 200) {
        $this->response = compact('data', 'status');
    }

    protected function handleUpdate($update) {
    }


}