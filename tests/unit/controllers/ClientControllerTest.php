<?php

namespace hipanel\modules\client\tests\unit\controllers;

use hipanel\modules\client\controllers\ClientController;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-04-22 at 14:39:12.
 */
class ClientControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientController
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new ClientController('test', null);
    }

    protected function tearDown()
    {
    }

    public function testActions()
    {
        $this->assertInstanceOf(ClientController::class, $this->object);
    }

}
