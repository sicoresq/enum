<?php

namespace Sicoresq\Enum\Tests;

use PHPUnit\Framework\TestCase;
use Sicoresq\Enum\Enum;
use UnexpectedValueException;

final class EnumTest extends TestCase
{
    public function testGetValue()
    {
        $enum = new EnumStub(EnumStub::E3);
        $enum2 = new EnumStub(EnumStub::E1);

        $this->assertEquals('e3', $enum->getValue());
        $this->assertEquals(EnumStub::E1, $enum2->getValue());
        $this->assertNotEquals(EnumStub::E1, $enum->getValue());
    }

    public function testGetConstList()
    {
        $constList = EnumStub::getConstList();

        $this->assertCount(3, $constList);
        $this->assertArrayHasKey('E2', $constList);
        $this->assertEquals(EnumStub::E2, $constList['E2']);
    }

    public function testHasValue()
    {
        $hasValue = EnumStub::hasValue('invalid');

        $this->assertFalse($hasValue);

        $hasValue = EnumStub::hasValue(EnumStub::E1);

        $this->assertTrue($hasValue);
    }

    public function testCallStatic()
    {
        $value = EnumStub::E3();
        $this->assertInstanceOf(EnumStub::class, $value);
        $this->assertSame(EnumStub::getConstList()['E3'], $value->getValue());
    }

    public function testInvalidValue()
    {
        $this->expectException(UnexpectedValueException::class);
        new EnumStub('invalid');
    }

    public function testConstListCaching()
    {
        $e1List = EnumStub::getConstList();
        $e2List = EnumStub2::getConstList();

        $this->assertNotEquals($e1List, $e2List);
    }

    public function testGetAll()
    {
        $expected = [
            EnumStub::E1(),
            EnumStub::E2(),
            EnumStub::E3(),
        ];

        $this->assertEquals($expected, EnumStub::getAll());
    }
}

/**
 * @method static self E1()
 * @method static self E2()
 * @method static self E3()
 */
class EnumStub extends Enum
{
    public const E1 = 0, E2 = 3, E3 = 'e3';
}

/**
 * @method static self G1()
 * @method static self G2()
 * @method static self G3()
 */
class EnumStub2 extends Enum
{
    public const G1 = 'abc', G2 = 222, G3 = 'e3';
}
