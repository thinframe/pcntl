<?php

namespace ThinFrame\Pcntl;

use ThinFrame\Foundation\Constants\DataType;
use ThinFrame\Foundation\Helpers\TypeCheck;
use ThinFrame\Pcntl\Constants\Signal;
use ThinFrame\Pcntl\Helpers\Exec;

class Process
{
    /**
     * @var int
     */
    private $pid = 0;

    /**
     * Constructor
     *
     * @param int $pid
     */
    public function __construct($pid)
    {
        TypeCheck::doCheck(DataType::INT);
        $this->pid = $pid;
    }

    /**
     * @return bool
     */
    public function restart()
    {
        $this->sendSignal(new Signal(Signal::KILL));
        list($exitStatus, $out, $err, $pid) = array_values(
            Exec::viaPipe(
                $this->getStartCommand() . ' > /dev/null 2>&1 &',
                $this->getWorkingDir()
            )
        );

        return !!$exitStatus;
    }

    /**
     * Send signal to process
     *
     * @param Signal $signal
     *
     * @return bool
     */
    public function sendSignal(Signal $signal)
    {
        return !!posix_kill($this->getPid(), $signal->__toString());
    }

    /**
     * Get process pid
     *
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Get process command
     *
     * @return mixed
     */
    public function getStartCommand()
    {
        return str_replace("\000", " ", @file_get_contents('/proc/' . $this->getPid() . '/cmdline'));
    }

    /**
     * Get process cwd
     *
     * @return string
     */
    public function getWorkingDir()
    {
        return realpath('/proc/' . $this->pid . '/cwd');
    }

    public function getTTY()
    {
        var_dump($this->getEnvironmentVariables()['SSH_TTY']);
    }

    /**
     * Get process environment variables
     *
     * @return null
     */
    public function getEnvironmentVariables()
    {
        if (!$this->isAlive()) {
            return null;
        }

        $environ = str_replace("\000", "&", file_get_contents('/proc/' . $this->getPid() . '/environ'));
        parse_str($environ, $variables);
        return $variables;
    }

    /**
     * Check if process is alive
     *
     * @return bool
     */
    public function isAlive()
    {
        return file_exists('/proc/' . $this->pid);
    }
}
