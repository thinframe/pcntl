<?php

/**
 * /src/PcntlSignalEvent.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Pcntl;

use ThinFrame\Events\AbstractEvent;
use ThinFrame\Pcntl\Constants\Signal;

/**
 * Class PcntlSignalEvent
 *
 * @package ThinFrame\Pcntl
 * @since   0.2
 */
class PcntlSignalEvent extends AbstractEvent
{
    const EVENT_ID = 'thinframe.pcntl.signal';

    /**
     * Constructor
     *
     * @param Signal $signal
     */
    public function __construct(Signal $signal)
    {
        parent::__construct('thinframe.pcntl.signal', ['signal' => $signal]);
    }

    /**
     * Get event signal
     *
     * @return Signal
     */
    public function getSignal()
    {
        return $this->getPayload()->get('signal')->get();
    }
}
