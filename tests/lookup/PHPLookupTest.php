<?php

use Rahmatawaludin\LaravelNotes\Lookup\PHPLookup;
use Mockery as m;

class PHPLookupTest extends PHPUnit_Framework_TestCase
{

    private $lookup;

    public function setUp()
    {
        $this->lookup = new PHPLookup(array('tests/lookup/stubs'), array());
        $this->lookup->setIncludePaths(array('tests/lookup/stubs'));
        $this->lookup->setExcludePaths(array());
    }

    /** @test **/
    public function itCanFilterDefault()
    {
        $this->assertTrue(is_array($this->lookup->filter()));
        $this->assertEquals(24, $this->lookup->count());
    }

    /** @test **/
    public function itCanFilterCustomtype()
    {
        $this->lookup->mergeTypes(array('customtype'));
        $this->assertTrue(is_array($this->lookup->filter()));
        $this->assertEquals(32, $this->lookup->count());
    }

    /** @test **/
    public function itCanFilterDefaultWithExclusion()
    {
        $this->lookup->setExcludePaths(array('exclude'));
        $this->assertTrue(is_array($this->lookup->filter()));
        $this->assertEquals(12, $this->lookup->count());
    }

    /** @test **/
    public function itCanFilterCustomTypeWithExclusion()
    {
        $this->lookup->setExcludePaths(array('exclude'));
        $this->lookup->mergeTypes(array('customtype'));
        $this->assertTrue(is_array($this->lookup->filter()));
        $this->assertEquals(16, $this->lookup->count());
    }

    /** @test **/
    public function itCanCount()
    {
        $this->assertEquals($this->lookup->count(), 0);
    }

    /** @test **/
    public function itCanAdd()
    {
        $this->lookup->add(m::mock('Rahmatawaludin\LaravelNotes\Lookup\Line'));
        $this->assertEquals(1, $this->lookup->count());
    }

    /** @test **/
    public function itCanSetIncludeAndExcludePaths()
    {
        $include = array('foo');
        $exclude = array('bar');

        $this->lookup->setIncludePaths($include);
        $this->lookup->setExcludePaths($exclude);

        $this->assertEquals($include, $this->lookup->getIncludePaths());
        $this->assertEquals($exclude, $this->lookup->getExcludePaths());
    }
}
