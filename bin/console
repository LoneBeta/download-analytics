<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../AppKernel.php';

/**
 * Very crude way of checking if the user is requesting a command, and then running that command.
 */
if(preg_match('/command\s*=\s*([\S\s]+)/',implode(' ', $argv), $command)){
    $command = $container->get('Lonebeta\\DownloadAnalytics\\Commands\\'.$command[1]);

    $command->handle();
}
