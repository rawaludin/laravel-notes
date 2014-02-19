<?php namespace Rahmatawaludin\LaravelNotes\Lookup;

use Rahmatawaludin\LaravelNotes\Lookup\Line;

abstract class Lookup
{
    /**
     * Folders to include
     * @var array
     */
    protected $includePaths;

    /**
     * Folders to exclude
     * @var array
     */
    protected $excludePaths;

    /**
     * Matches found
     * @var array
     */
    protected $matches = array();

    /**
     * Types to match
     * @var array
     */
    protected $types = array('OPTIMIZE', 'TODO', 'FIXME');

    public function getIncludePaths()
    {
        return $this->includePaths;
    }

    public function setIncludePaths($includePaths)
    {
        $this->includePaths = (array) $includePaths;
    }

    public function getExcludePaths()
    {
        return $this->excludePaths;
    }

    public function setExcludePaths($excludePaths)
    {
        $this->excludePaths = (array) $excludePaths;
    }

    public function add(Line $line)
    {
        return array_push($this->matches, $line);
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function setType($type)
    {
        $this->types = array($type);
    }

    public function mergeTypes(array $types)
    {
        $this->types = array_merge($this->types, $types);
    }

    public function count()
    {
        return count($this->matches);
    }
}
