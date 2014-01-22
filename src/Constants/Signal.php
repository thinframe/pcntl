<?php

/**
 * /src/Constants/Signal.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Pcntl\Constants;

use ThinFrame\Foundation\DataTypes\AbstractEnum;

/**
 * Class Signals
 *
 * @package ThinFrame\Pcntl\Constants
 * @since   0.2
 */
final class Signal extends AbstractEnum
{
    const HANGUP                        = SIGHUP;
    const KEYBOARD_INTERRUPT            = SIGINT;
    const KEYBOARD_QUIT                 = SIGQUIT;
    const ILLEGAL_INSTRUCTION           = SIGILL;
    const TRACE_TRAP                    = SIGTRAP;
    const ABORT                         = SIGABRT;
    const FLOATING_POINT_EXCEPTION      = SIGFPE;
    const BUS_ERROR                     = SIGBUS;
    const POLLABLE_EVENT                = SIGPOLL;
    const USER_DEFINED_1                = SIGUSR1;
    const USER_DEFINED_2                = SIGUSR2;
    const INVALID_MEMORY_REFERENCE      = SIGSEGV;
    const BROKEN_PIPE                   = SIGPIPE;
    const ALARM                         = SIGALRM;
    const TERMINATION                   = SIGTERM;
    const CHILD_STOPPED                 = SIGCHLD;
    const CONTINUE_IF_STOPPED           = SIGCONT;
    const TYPED_STOP_AT_TERMINAL        = SIGTSTP;
    const INPUT_FOR_BACKGROUND_PROCESS  = SIGTTIN;
    const OUTPUT_FOR_BACKGROUND_PROCESS = SIGTTOU;
    const URGENT_CONDITION_ON_SOCKET    = SIGURG;
    const CPU_TIME_LIMIT                = SIGXCPU;
    const FILE_SIZE_LIMIT               = SIGXFSZ;
    const VIRTUAL_ALARM_CLOCK           = SIGVTALRM;
    const PROFILING_TIMER_EXPIRED       = SIGPROF;
    const WINDOW_RESIZE_SIGNAL          = SIGWINCH;
    const IO_NOT_POSSIBLE               = SIGIO;
    const POWER_FAILURE                 = SIGPWR;
    const BAD_ARGUMENT_TO_ROUTINE       = SIGSYS;
    const KILL                          = SIGKILL;
}
