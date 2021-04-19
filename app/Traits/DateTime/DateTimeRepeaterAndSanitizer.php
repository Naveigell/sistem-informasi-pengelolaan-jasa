<?php
namespace App\Traits\DateTime;

trait DateTimeRepeaterAndSanitizer
{
    /**
     * Sanitizing month, dont give month less than 1 and more than 12
     *
     * @param int $month
     * @return int
     */
    private function sanitizeMonth(int $month) : int
    {
        $result = max(0, min($month, 12));
        if ($result == 0) {
            return 12;
        }

        return $result;
    }

    /**
     * Repeating month, example: month is 25, its will be 1 by modulo 25 % 12
     * if month is -25 it will be 11 by modulo the given month and subtract it by 12,
     * if month is 0, return back 1
     *
     * @param int $month
     * @return int
     */
    private function repeatMonth(int $month) : int
    {
        if ($month == 0)
            return 12;

        if ($month > 12) {
            return $this->sanitizeMonth($month % 12);
        } else if ($month < 1) {
            return $this->sanitizeMonth(12 - (abs($month) % 12));
        }

        return $month;
    }

    /**
     * Sanitizing year, clamp year to 2010 if year less than 2010
     *
     * @param int $year
     * @return int
     */
    private function sanitizeYear(int $year) : int
    {
        return max($year, 2010);
    }
}
