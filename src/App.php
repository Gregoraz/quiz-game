<?php

namespace App;

use Symfony\Component\Console\Application;
use Traversable;

class App extends Application
{

    public function __construct(iterable $commands)
    {
        $commands = $commands instanceof Traversable ? iterator_to_array($commands) : $commands;

        foreach ($commands as $command) {
            $this->add($command);
        }

        parent::__construct();
    }
}