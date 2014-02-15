<?php namespace Rahmatawaludin\LaravelNotes\Lookup;

use Symfony\Component\Finder\Finder;

class PHPLookup extends Lookup implements LookupInterface
{

    /**
     * Search through files and filter by this types
     * @param array $types
     * @return array Lines
     */
    public function filter(array $types = array())
    {
        $this->mergeTypes($types);

        $files = $this->getFiles();

        foreach ($files as $filename) {

            foreach (file($filename) as $lineNumber => $content) {
                foreach ($this->types as $type) {
                    if (stristr($content, "@$type")) {

                        // Strip note type text and comment tag
                        $content = preg_replace("/\S+(\s|\s\s+)$type(\s|\s\s+)/", '', $content);

                        // Strip excess whitespace (space or tab) in beginning string
                        $content = trim(preg_replace('/(\t+|\s\s+)/', '', $content));

                        $this->add(
                            new Line($filename, $lineNumber, $content, $type)
                        );
                    }
                }
            }
        }

        return $this->matches;
    }

    private function getFiles()
    {
        $finder = Finder::create()->exclude($this->excludePaths)->in($this->includePaths);

        return iterator_to_array(
            $finder->files(),
            false
        );
    }
}
