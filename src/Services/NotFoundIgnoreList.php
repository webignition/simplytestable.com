<?php

namespace App\Services;

class NotFoundIgnoreList
{
    const IGNORE_LIST_RESOURCE_NAME = '/config/resources/not-found-ignore-list.txt';

    /**
     * @var string
     */
    private $kernelProjectDirectory;

    /**
     * @param $kernelProjectDirectory
     */
    public function __construct($kernelProjectDirectory)
    {
        $this->kernelProjectDirectory = $kernelProjectDirectory;
    }

    /**
     * @return string[]
     */
    public function get()
    {
        $content = file_get_contents($this->kernelProjectDirectory . self::IGNORE_LIST_RESOURCE_NAME);
        $lines = explode("\n", $content);

        return array_filter($lines);
    }
}
