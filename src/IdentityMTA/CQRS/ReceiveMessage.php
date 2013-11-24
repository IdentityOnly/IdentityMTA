<?php
namespace IdentityMTA\CQRS;

use IdentityCommon\Entity;
use IdentityCommon\Service;
use IdentityCommon\CQRS\AbstractCQRS;

class ReceiveMessage extends AbstractCQRS
{
    protected $messageService;

    protected $message;
    
    public function __construct(Service\Message $messageService)
    {
        parent::__construct();
        
        $this->setMessageService($messageService);
    }

    public function execute() {
        $messageService = $this->getMessageService();
        $message = $this->getMessage();
    
        $receivedMessage = new Entity\ReceivedMessage;
        $receivedMessage->setContent($message);
        
        $message = $messageService->saveReceivedMessage($receivedMessage);
        
        return $message;
    }
    
    public function getMessageService() {
        return $this->messageService;
    }
    
    public function setMessageService($messageService) {
        $this->messageService = $messageService;
        return $this;
    }
    
    public function getMessage() {
        return $this->message;
    }
    
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }
}
