<?php

namespace NitroPHP\ModuleManager;

use Alzundaz\NitroPHP\BaseClass\Singleton;

class GitModuleManager extends Singleton
{
    /**
     * Module repo clonning for install
     *
     * @param string $url
     * @param string $installPath
     * @return object $repo
     */
    public function clone(string $url, string $installPath):object
    {
        return GitRepository::cloneRepository($url, $installPath);
    }

    /**
     * Create local repository for module
     *
     * @param string $path
     * @param string $repo
     * @return object $repo
     */
    public function create(string $path, string $repo = null):object
    {
        if(!$repo) return GitRepository::init($path);
        $repo = GitRepository::init($path);
        $repo->addRemote('origin', $repo);
        return $repo;
    }

    /**
     * Check if Module have change
     *
     * @param string $path
     * @return boolean
     */
    public function checkUpdate(string $path):bool
    {
        $repo = new Cz\Git\GitRepository($path);
        return $repo->hasChanges();
    }
}