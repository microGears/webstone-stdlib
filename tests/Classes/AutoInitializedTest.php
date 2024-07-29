<?php

use PHPUnit\Framework\TestCase;
use RuntimeException;
use WebStone\Stdlib\Classes\AutoInitialized;

class AutoInitializedTest extends TestCase
{
    public function testConstructorWithEmptyArray()
    {
        $autoInitialized = new AutoInitialized([]);
        $this->assertInstanceOf(AutoInitialized::class, $autoInitialized);
    }

    public function testConstructorWithNonEmptyArray()
    {
        $config = ['key' => 'value'];
        $autoInitialized = new AutoInitialized($config);
        $this->assertInstanceOf(AutoInitialized::class, $autoInitialized);
    }

    public function testTurnIntoWithValidClassName()
    {
        $result = AutoInitialized::turnInto(AutoInitialized::class);
        $this->assertInstanceOf(AutoInitialized::class, $result);
    }

    public function testTurnIntoWithValidClassNameAndConfig()
    {
        $input = [
            'class' => AutoInitialized::class,
            'config' => ['key' => 'value']
        ];
        $result = AutoInitialized::turnInto($input);
        $this->assertInstanceOf(AutoInitialized::class, $result);
    }

    public function testTurnIntoWithValidClassNameAndNoConfig()
    {
        $input = [
            'class' => AutoInitialized::class
        ];
        $result = AutoInitialized::turnInto($input);
        $this->assertInstanceOf(AutoInitialized::class, $result);
    }

    public function testTurnIntoWithInvalidClassName()
    {
        $this->expectException(RuntimeException::class);
        AutoInitialized::turnInto('InvalidClassName');
    }

    public function testTurnIntoWithInvalidClassNameInArray()
    {
        $input = [
            'class' => 'InvalidClassName'
        ];
        $this->expectException(RuntimeException::class);
        AutoInitialized::turnInto($input);
    }
}