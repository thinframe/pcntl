<?php

/**
 * /src/SignalsCatcher.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Pcntl;

use ThinFrame\Events\Dispatcher;
use ThinFrame\Events\DispatcherAwareInterface;
use ThinFrame\Foundation\Exceptions\RuntimeException;
use ThinFrame\Pcntl\Constants\Signal;

/**
 * Class SignalsCatcher
 *
 * @package ThinFrame\Pcntl
 * @since   0.2
 */
class SignalsCatcher implements DispatcherAwareInterface
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;
    /**
     * @var Signal[]
     */
    private $signals = [];

    /**
     * @param Dispatcher $dispatcher
     */
    public function setDispatcher(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Add signal to be binded
     *
     * @param Signal $signal
     *
     * @return $this
     */
    public function addSignal(Signal $signal)
    {
        $this->signals[] = $signal;

        return $this;
    }

    /**
     * Bind all added signals
     *
     * @throws \ThinFrame\Foundation\Exceptions\RuntimeException
     */
    public function bind()
    {
        foreach ($this->signals as $signal) {
            if (!@pcntl_signal((int)$signal->__toString(), [$this, 'handlePcntlSignal'])) {
                throw new RuntimeException('Cannot forward signal ' . $signal);
            }
        }
    }

    /**
     * Forward signal using internal event dispatcher
     *
     * @param int $signalNo
     */
    public function handlePcntlSignal($signalNo)
    {
        $this->dispatcher->trigger(new PcntlSignalEvent(new Signal($signalNo)));
    }

    /**
     * Remove all signals bindings
     */
    public function unbind()
    {
        foreach ($this->signals as $signal) {
            pcntl_signal((int)$signal->__toString(), SIG_IGN);
        }
    }
}
