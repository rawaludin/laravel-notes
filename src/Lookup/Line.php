<?php namespace Rahmatawaludin\LaravelNotes\Lookup;

class Line
{
    public $filename;
    public $lineNumber;
    public $content;
    public $type;

    public function __construct($filename, $lineNumber, $content, $type)
    {
        $this->filename = $filename;
        $this->lineNumber = $lineNumber;
        $this->content = $content;
        $this->type = $type;
    }
}
