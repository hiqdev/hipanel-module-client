<?php

namespace hipanel\modules\client\models;

use DateInterval;
use hipanel\base\Model;

class NotifyTries extends Model
{
    public $try_last;

    public $tries_left;

    public $sleep;

    /**
     * @return array
     */
    public function attributes()
    {
        return ['try_last', 'tries_left', 'sleep'];
    }

    /**
     * @return DateInterval
     */
    public function getMinimumInterval()
    {
        return DateInterval::createFromDateString('2 minutes');
    }

    /**
     * @return bool
     */
    public function isIntervalSatisfied()
    {
        return $this->sleep === null;
    }

    public function getNextTryTime()
    {
        if ($this->isIntervalSatisfied()) {
            return null;
        }

        return time() + $this->sleep;
    }
}
