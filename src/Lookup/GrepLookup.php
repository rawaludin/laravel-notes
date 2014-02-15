<?php namespace Rahmatawaludin\LaravelNotes\Lookup;

use Symfony\Component\Finder\Shell\Command;

class GrepLookup extends Lookup implements LookupInterface
{

    /**
     * Search through files and filter by this types
     * @param array $types
     * @return array Lines
     */
    public function filter()
    {

        $command = "grep -n -i -R -E \"" . implode('|', $this->types) . "\"";

        foreach ($this->includePaths as $path) {
            $command .= " $path";
        }

        if ($this->excludePaths) {
            $command .= ' --exclude-dir=' . implode(',', $this->excludePaths);
        }

        exec($command, $commandOutput);

        foreach ($commandOutput as $line) {
            preg_match_all("/(.*):(.*):(.*)/", $line, $pieces, PREG_PATTERN_ORDER);

            foreach ($this->types as $type) {
                if (stristr($pieces[3][0], "@$type")) {

                    // Strip note type text and comment tag
                    $content = preg_replace("/\S+(\s|\s\s+)$type(\s|\s\s+)/", '', $pieces[3][0]);

                    // Strip excess whitespace (space or tab) in beginning string
                    $content = trim(preg_replace('/(\t+|\s\s+)/', '', $content));

                    $this->add(
                        new Line($pieces[1][0], $pieces[2][0], $content, $type)
                    );
                }
            }
        }

        return $this->matches;
    }
}
