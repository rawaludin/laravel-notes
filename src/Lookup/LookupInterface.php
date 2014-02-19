<?php namespace Rahmatawaludin\LaravelNotes\Lookup;

interface LookupInterface
{
    /**
     * Search through files and filter by specified types
     * @return array Lines
     */
    public function filter();

    /**
     * Return numbers of matches
     * @return int count
     */
    public function count();
}
