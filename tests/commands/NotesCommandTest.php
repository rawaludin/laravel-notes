<?php

use Rahmatawaludin\LaravelNotes\Commands\NotesCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Mockery as m;

class NotesCommandTest extends PHPUnit_Framework_TestCase
{

    /** @test **/
    public function itCanFilterWithDefaults()
    {
        $grepLookup = m::mock('Rahmatawaludin\LaravelNotes\Lookup\GrepLookup[filter]');
        $phpLookup = m::mock('Rahmatawaludin\LaravelNotes\Lookup\PHPLookup[filter]');

        $grepLookup->shouldReceive('filter')->once()->andReturn(array());

        $command = new NotesCommand(
            array('php' => $phpLookup, 'grep' => $grepLookup)
        );

        $tester = new CommandTester($command);
        $tester->execute(array());

        $this->assertEquals("Found 0 matches\n", $tester->getDisplay());
    }

    /** @test **/
    public function itCanSetFilter()
    {
        $grepLookup = m::mock('Rahmatawaludin\LaravelNotes\Lookup\GrepLookup[filter]');
        $phpLookup = m::mock('Rahmatawaludin\LaravelNotes\Lookup\PHPLookup[filter]');

        $grepLookup->shouldReceive('filter')->once()->andReturn(array());

        $command = new NotesCommand(
            array('php' => $phpLookup, 'grep' => $grepLookup)
        );

        $tester = new CommandTester($command);
        $tester->execute(array('filter' => 'customtype'));

        $this->assertEquals("Found 0 matches\n", $tester->getDisplay());
        $this->assertEquals(array('customtype'), $grepLookup->getTypes());
    }

    /** @test **/
    public function itCanSetExtraFilter()
    {
        $grepLookup = m::mock('Rahmatawaludin\LaravelNotes\Lookup\GrepLookup[filter]');
        $phpLookup = m::mock('Rahmatawaludin\LaravelNotes\Lookup\PHPLookup[filter]');

        $grepLookup->shouldReceive('filter')->once()->andReturn(array());

        $command = new NotesCommand(
            array('php' => $phpLookup, 'grep' => $grepLookup)
        );

        $tester = new CommandTester($command);
        $tester->execute(array('--extra-filters' => 'customtype'));

        $this->assertEquals("Found 0 matches\n", $tester->getDisplay());
        $this->assertEquals(array('OPTIMIZE', 'TODO', 'FIXME', 'customtype'), $grepLookup->getTypes());
    }

    /** @test **/
    public function itCanSetExtraFilters()
    {
        $grepLookup = m::mock('Rahmatawaludin\LaravelNotes\Lookup\GrepLookup[filter]');
        $phpLookup = m::mock('Rahmatawaludin\LaravelNotes\Lookup\PHPLookup[filter]');

        $grepLookup->shouldReceive('filter')->once()->andReturn(array());

        $command = new NotesCommand(
            array('php' => $phpLookup, 'grep' => $grepLookup)
        );

        $tester = new CommandTester($command);
        $tester->execute(array('--extra-filters' => 'customtype,anothertype'));

        $this->assertEquals("Found 0 matches\n", $tester->getDisplay());
        $this->assertEquals(array('OPTIMIZE', 'TODO', 'FIXME', 'customtype', 'anothertype'), $grepLookup->getTypes());
    }

    /** @test **/
    public function itCanDisplayResults()
    {
        $grepLookup = m::mock('Rahmatawaludin\LaravelNotes\Lookup\GrepLookup[filter]');
        $phpLookup = m::mock('Rahmatawaludin\LaravelNotes\Lookup\PHPLookup[filter]');

        $line = m::mock('Rahmatawaludin\LaravelNotes\Lookup\Line', array('foo.php', 1, 'bar', 'TODO'));

        $grepLookup->shouldReceive('filter')->once()->andReturn(
            array($line)
        );

        $command = new NotesCommand(
            array('php' => $phpLookup, 'grep' => $grepLookup)
        );

        $tester = new CommandTester($command);
        $tester->execute(array());

        $this->assertEquals(
            "Found 0 matches\n" .
            "foo.php:1\n" .
            "[TODO] bar\n\n",
            $tester->getDisplay()
        );
    }
}
