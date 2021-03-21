<?php
namespace App\Helpers\Times;

use DateInterval;

class Time {

    /**
     * Get sentences of different time
     *
     * @param \DateTime $dateTime
     * @return string
     */
    public function toSentences(\DateTime $dateTime) : string
    {
        try {
            // using date time diff, maybe there's some bugs in leap year
            $diff = (new \DateTime(now()))->diff($dateTime);

            // if the diff is more than one day, we return real date
            if ($this->isMoreThanOneDay($diff)) {
                setlocale(LC_ALL, 'IND');
                return strftime("%d %B %Y", $dateTime->getTimestamp());
            }

            if ($this->isOneDay($diff)) {
                return "1 hari yang lalu";
            }

            if ($this->isLessThanOneDay($diff)) {
                return $diff->h." jam yang lalu";
            }

            if ($this->isLessThanOneHour($diff)) {
                return $diff->i." menit yang lalu";
            }

            if ($this->isLessThanOneMinute($diff)) {
                return $diff->s." detik yang lalu";
            }

            return "Baru saja";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * check if the day is one, dont care about hour, minutes etc
     *
     * @param DateInterval $interval
     * @return bool
     */
    private function isOneDay(DateInterval $interval) : bool
    {
        return $interval->d === 1;
    }

    /**
     * check if the day is 0 and hour between 1 and 24
     *
     * @param DateInterval $interval
     * @return bool
     */
    private function isLessThanOneDay(DateInterval $interval) : bool
    {
        return $interval->d === 0 && $interval->h < 24 && $interval->h > 0;
    }

    /**
     * check if day is 0, hour is 0 and minutes is more than 0, or it's mean
     * more than 1 minute
     *
     * @param DateInterval $interval
     * @return bool
     */
    private function isLessThanOneHour(DateInterval $interval) : bool
    {
        return $interval->d === 0 && $interval->h === 0 && $interval->i > 0;
    }

    /**
     * check if day is 0, hour is 0, minute is less than 60 and seconds more than 0
     *
     * @param DateInterval $interval
     * @return bool
     */
    private function isLessThanOneMinute(DateInterval $interval) : bool
    {
        return $interval->d === 0 && $interval->h === 0 && $interval->i < 60 && $interval->s > 0;
    }

    /**
     * check if day is more than 1, dont care about hours, minutes, seconds, etc
     *
     * @param DateInterval $interval
     * @return bool
     */
    private function isMoreThanOneDay(DateInterval $interval) : bool
    {
        return $interval->d > 1;
    }
}
