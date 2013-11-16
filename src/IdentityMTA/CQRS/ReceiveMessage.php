<?php
namespace IdentityMTA\CQRS;

use Zend\Mail\Message;

class ReceiveMessage extends AbstractCQRS
{
    protected $message;

    public function execute() {
        $message = $this->getMessage();
    
        file_put_contents(__DIR__.'/../../../data/received.txt', var_export($message, true));
    }
    
    public function getMessage() {
        return $this->message;
    }
    
    public function setMessage(Message $message) {
        $this->message = $message;
        return $this;
    }
}
