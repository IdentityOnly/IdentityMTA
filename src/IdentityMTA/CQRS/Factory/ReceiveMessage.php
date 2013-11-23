<?php
namespace IdentityMTA\CQRS\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use IdentityMTA\CQRS;

class ReceiveMessage implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $messageService = $serviceLocator->get('IdentityCommon\Service\Message');
    
        return new CQRS\ReceiveMessage($messageService);
    }
}
