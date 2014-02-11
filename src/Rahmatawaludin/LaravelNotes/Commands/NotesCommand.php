<?php

namespace Rahmatawaludin\LaravelNotes\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem as File;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NotesCommand extends Command {

    /**
    * The console command name.
    *
    * @var string
    */
    protected $name = 'notes';
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'List all notes';

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
    parent::__construct();
    }
    /**
    * Execute the console command.
    *
    * @return void
    */
    public function fire()
    {
        $fileReader = new File;
        $types = ['TODO','FIXME','OPTIMIZE'];
        $files = $fileReader->allFiles('app');

        foreach ($files as $filename) {
            $lines = file($filename);
            $results = array();
            $maxline = 999;

            // skip app/storage folder
            if (substr($filename->getPath(),0, 11) !== "app/storage") {
                foreach ($lines as $lineNumber => $line) {
                    foreach ($types as $type) {
                        if (strstr($line, " $type ")) {
                            // strip note type text and comment tag
                            $line = preg_replace("/\S.(\s|\s\s+)$type(\s|\s\s+)/", '', $line);
                            // Strip excess whitespace (space or tab) in beginning string
                            $line = preg_replace('/(\t+|\s\s+)/', '', $line);

                            array_push($results, [
                                'lineNumber'=>$lineNumber,
                                'type'=>$type,
                                'line'=>$line]
                            );
                            if ($lineNumber > $maxline) $maxline = $lineNumber;
                        }
                    }
                }
            }

            $maxline = strlen($maxline);
            if ($results != array()) {
                echo "$filename\n";
                foreach ($results as $result) {
                    printf(" * [%".$maxline."s] [%s] %s", $result['lineNumber'],
                       $result['type'], $result['line']);
                }
                echo "\n";
            }

        }
    }
}
