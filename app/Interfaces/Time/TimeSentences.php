<?php


namespace App\Interfaces\Time;

/**
 * Interface TimeSentences
 * @package App\Interfaces
 */
interface TimeSentences
{
    /**
     * Return a sentences from date time
     *
     * @param \DateTime $time
     * @return string
     */
    public function toSentences(\DateTime $time) : string;
}
