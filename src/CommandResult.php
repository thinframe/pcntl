<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Pcntl;

/**
 * Class CommandResult
 * @package ThinFrame\Pcntl
 * @since   0.3
 */
class CommandResult
{
    /**
     * @var int
     */
    private $pid;
    /**
     * @var string
     */
    private $stdOut;
    /**
     * @var string
     */
    private $stdErr;
    /**
     * @var int
     */
    private $exitStatus;

    /**
     * Constructor
     *
     * @param int    $pid
     * @param string $stdOut
     * @param string $stdErr
     * @param int    $exitStatus
     */
    public function __construct($pid, $stdOut, $stdErr, $exitStatus)
    {
        $this->pid        = $pid;
        $this->stdOut     = $stdOut;
        $this->stdErr     = $stdErr;
        $this->exitStatus = $exitStatus;
    }

    /**
     * Get stdout
     * @return string
     */
    public function getStdOut()
    {
        return $this->stdOut;
    }

    /**
     * Get stderr
     * @return string
     */
    public function getStdErr()
    {
        return $this->stdErr;
    }

    /**
     * Get pid
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Get exit status
     * @return int
     */
    public function getExitStatus()
    {
        return $this->exitStatus;
    }

    /**
     * Check if result is successful
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->exitStatus == 0;
    }
}
