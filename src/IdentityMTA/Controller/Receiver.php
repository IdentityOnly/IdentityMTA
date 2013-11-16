<?php
namespace IdentityMTA\Controller;

use IdentityMTA\CQRS;

use Zend\Mail\Message;

class Receiver extends AbstractController
{
    public function receiveAction() {
        $receiveMessage = $this->getServiceLocator()->get('IdentityMTA\CQRS\ReceiveMessage');
    
        $messageContent = $this->getRequest()->getContent();
        $message = Message::fromString($messageContent);
        
        $receiveMessage->setMessage($message);
        
        $receiveMessage->execute();
        
        echo 'test';
    }
}
