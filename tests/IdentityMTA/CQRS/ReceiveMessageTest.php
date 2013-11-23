<?php
namespace IdentityMTA\CQRS;

use IdentityMTATest\Bootstrap;
use PHPUnit_Framework_TestCase as TestCase;

class ReceiveMessageTest extends TestCase
{
    /**
     * @dataProvider provideMessageContents
     */
    public function testExecute($content) {
        $instance = $this->getInstance();
        $instance->setMessage($content);
        
        $message = $instance->execute();
    }

    public function provideMessageContents()
    {
        $data = array();
    
        foreach(glob(__DIR__.'/fixtures/ReceiveMessage/*.eml') as $fixture) {
            $data[] = array(
                file_get_contents($fixture)
            );
        }
        
        return $data;
    }
    
    protected function getInstance() {
        return Bootstrap::getServiceManager()->get('IdentityMTA\CQRS\ReceiveMessage');
    }
}
