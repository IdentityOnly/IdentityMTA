<?php
namespace IdentityMTA\Controller;

use IdentityMTA\CQRS;
use IdentityCommon\Entity;

use Zend\Mail\Message;
use Zend\Http\Request as HttpRequest;
use Zend\Console\Request as ConsoleRequest;

class Receiver extends AbstractController
{
    public function receiveAction() {
        $receiveMessage = $this->getServiceLocator()->get('IdentityMTA\CQRS\ReceiveMessage');
        
        if($this->getRequest() instanceof ConsoleRequest) {
            $messageContent = file_get_contents($this->params('message'));
        } elseif($this->getRequest() instanceof HttpRequest) {
            $messageContent = $this->getRequest()->getContent();
        }
        
        $receiveMessage->setMessage($messageContent);
        $message = $receiveMessage->execute();
        
        if($this->getRequest() instanceof ConsoleRequest) {
            if($message instanceof Entity\ReceivedMessage) {
                return $this->getResponse()
                    ->setContent('Success');
            } else {
                return $this->getResponse()
                    ->setContent('Failure');
            }
        } elseif($this->getRequest() instanceof HttpRequest) {
            if($message instanceof Entity\ReceivedMessage) {
                return $this->getResponse()
                    ->setStatusCode(200);
            } else {
                return $this->getResponse()
                    ->setStatusCode(400);
            }
        }
    }
}
