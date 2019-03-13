<?php

namespace NitroPHP\BaseClass;

use Module\ProfilerModule\Services\Profiler;


class NitroException
{
    public function __construct($type, $message, $file, $line)
    {
        Profiler::getInstance()->setError($type, $message, $file, $line);
    }

    public function __destruct()
    {
        // Todo
    }
}