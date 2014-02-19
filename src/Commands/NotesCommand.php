<?php namespace Rahmatawaludin\LaravelNotes\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Rahmatawaludin\LaravelNotes\Lookup\GrepLookup;
use Rahmatawaludin\LaravelNotes\Lookup\PHPLookup;

class NotesCommand extends Command
{

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
    * Lookup providers
    *
    * @var array
    */
    protected $providers;

    /**
     * Selected lookup service
     *
     * @var Rahmatawaludin\LaravelNotes\Lookup\LookupInterface
     */
    protected $lookup;

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct(array $providers)
    {
        parent::__construct();
        $this->providers = $providers;
        $this->lookup = $this->getLookupService();
    }

    /**
    * Execute the console command.
    *
    * @return void
    */
    public function fire()
    {
        // Set single type from argument
        if ($this->argument('filter')) {
            $this->lookup->setType($this->argument('filter'));
        }

        $this->lookup->setIncludePaths(
            explode(',', $this->option('include-path'))
        );

        $this->lookup->setExcludePaths(
            explode(',', $this->option('exclude-path'))
        );

        if ($this->option('extra-filters')) {
            $this->lookup->mergeTypes(
                explode(',', $this->option('extra-filters'))
            );
        }

        $matches = $this->lookup->filter();

        $this->info(
            sprintf('Found %d matches', $this->lookup->count())
        );

        foreach ($matches as $match) {
            $this->output->writeln("<fg=green>$match->filename</fg=green>:<fg=cyan>$match->lineNumber</fg=cyan>");
            $this->comment(sprintf("[%s] %s", $match->type, $match->content));
            $this->info('');
        }
    }

    /**
     * Lookup Provider strategy: grep for UNIX, PHP for Windows
     *
     * @return Rahmatawaludin\LaravelNotes\Lookup\LookupInterface
     */
    private function getLookupService()
    {
        if (DIRECTORY_SEPARATOR == '\\') {
            return $this->providers['php']; // PHPLookup
        } else {
            return $this->providers['grep']; // GrepLookup
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('filter', InputArgument::OPTIONAL, 'Filter only this type', null),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array(
                'include-path',
                'i',
                InputOption::VALUE_OPTIONAL,
                'Specify included paths. Comma separated.',
                'app'
            ),
            array(
                'exclude-path',
                'e',
                InputOption::VALUE_OPTIONAL,
                'Specify excluded paths. Comma separated.',
                'storage'
            ),
            array(
                'extra-filters',
                'f',
                InputOption::VALUE_OPTIONAL,
                'Append extra filters to defaults. Comma separated.',
                null
            ),
        );
    }
}
