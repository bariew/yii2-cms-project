<?php

namespace tests\codeception\unit\models;

use yii\codeception\TestCase;

class UserTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        // uncomment the following to load fixtures for user table
        //$this->loadFixtures(['user']);
    }

    public function it()
    {

    }

    // TODO add test methods here
    public function getName($withDataSet = TRUE)
    {
        return ['it'];
        // TODO: Implement getName() method.
    }

    public function toString()
    {
        // TODO: Implement toString() method.
    }
}
