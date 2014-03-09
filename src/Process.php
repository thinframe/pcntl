<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Pcntl;

use ThinFrame\Foundation\Constant\DataType;
use ThinFrame\Foundation\Helper\TypeCheck;
use ThinFrame\Pcntl\Constant\Signal;
use ThinFrame\Pcntl\Helper\Exec;

/**
 * Process
 *
 * @package ThinFrame\Pcntl
 * @since   0.2
 */
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
        $startCommand      = $this->getStartCommand();
        $currentWorkingDir = $this->getWorkingDir();
        $this->sendSignal(new Signal(Signal::KILL));
        list($exitStatus, $stdOut, $stdErr, $processId) = array_values(
            Exec::viaPipe(
                $startCommand . ' > /dev/null 2>&1 &',
                $currentWorkingDir
            )
        );

        return !$exitStatus;
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
     * Get process pid
     *
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
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
     * Get process tty
     *
     * @return string
     */
    public function getTTY()
    {
        return $this->getEnvironmentVariables()['SSH_TTY'];
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
