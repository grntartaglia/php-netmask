<?php
namespace Netmask;

class NetmaskTest extends \PHPUnit_Framework_TestCase
{
    public function provider()
    {
        return array(
            array('192.168.0.1/24', '255.255.255.0'),
            array('192.168.0.1/255.255.255.0', '255.255.255.0'),
            array('192.168.0.1', '255.255.255.255')
        );
    }

    public function invalidProvider()
    {
        return array(
            array('192.168.0.1/1.1'),
            array('192.168.0.1.1'),
            array('192.168.0.1.1/24'),
            array('192.168.0.1/64')
        );
    }

    /**
     * @covers Netmask\Netmask::__construct
     * @dataProvider provider
     */
    public function testMask($net, $mask)
    {
        $block = new Netmask($net);
        $this->assertEquals($block->mask, $mask);
    }

    /**
     * @covers Netmask\Netmask::__construct
     */
    public function testProperties()
    {
        $block = new Netmask('10.0.0.0/12');
        $this->assertEquals($block->base, '10.0.0.0');
        $this->assertEquals($block->mask, '255.240.0.0');
        $this->assertEquals($block->bitmask, 12);
        $this->assertEquals($block->hostmask, '0.15.255.255');
        $this->assertEquals($block->broadcast, '10.15.255.255');
        $this->assertEquals($block->size, 1048576);
        $this->assertEquals($block->first, '10.0.0.1');
        $this->assertEquals($block->last, '10.15.255.254');
    }

    /**
     * @covers Netmask\Netmask::contains
     */
    public function testContains()
    {
        $block = new Netmask('10.0.0.0/12');
        $this->assertTrue($block->contains('10.8.0.10'));
        $this->assertTrue($block->contains('10.0.8.10/12'));
        $this->assertFalse($block->contains('192.168.1.20'));
    }

    /**
     * @covers Netmask\Netmask::getAll
     */
    public function testGetAll()
    {
        $block = new Netmask('192.168.0.1/24');
        $this->assertTrue(is_array($block->getAll()));
        $this->assertEquals(254, count($block->getAll()));
        $this->assertTrue(in_array('192.168.0.24', $block->getAll()));
    }

    /**
     * @covers Netmask\Netmask::__construct
     * @expectedException InvalidArgumentException
     * @dataProvider invalidProvider
     */
    public function testThrows($net)
    {
        new Netmask($net);
    }
}
