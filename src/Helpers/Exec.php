<?php

/**
 * /src/Helpers/Exec.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Pcntl\Helpers;

use ThinFrame\Foundation\Constants\DataType;
use ThinFrame\Foundation\Helpers\TypeCheck;

/**
 * Class Exec
 *
 * @package ThinFrame\Pcntl\Helpers
 * @since   0.2
 */
final class Exec
{
    /**
     * Execute command via pipe
     *
     * @param      $command
     * @param null $workingDir
     *
     * @return array
     */
    public static function viaPipe($command, $workingDir = null)
    {
        TypeCheck::doCheck(DataType::STRING, DataType::STRING);

        $descriptorSpec = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ];

        $pipes = [];

        $resource = proc_open($command, $descriptorSpec, $pipes, $workingDir);

        $status = proc_get_status($resource);

        $stdOut = stream_get_contents($pipes[1]);
        $stdErr = stream_get_contents($pipes[2]);

        foreach ($pipes as $pipe) {
            fclose($pipe);
        }
        $exitStatus = trim(proc_close($resource));


        return [
            "exitStatus" => $exitStatus,
            "stdOut"     => $stdOut,
            "stdErr"     => $stdErr,
            "pid"        => $status['pid']
        ];
    }
}
