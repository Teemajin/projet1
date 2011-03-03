<?php

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->bootstrap = array($application->getBootstrap(), 'bootstrap');
        return parent::setUp();
    }

    public function tearDown()
    {
        /* Tear Down Routine */
    }

    public function testIndexPageShouldPullFromRightMCA()
    {
        $this->dispatch('/');
        
        $this->assertModule('Core');
        $this->assertController('index');
        $this->assertAction('index');
    }

}
