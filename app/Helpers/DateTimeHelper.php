<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelper
{
    /**
     * Convert timestamp to WIB timezone
     *
     * @param mixed $timestamp Timestamp to convert (Carbon instance, string, or null)
     * @param string $format Format for the output
     * @return string|null Formatted timestamp in WIB or null if input is null
     */
    public static function toWIB($timestamp, $format = 'd-m-Y H:i:s')
    {
        if (empty($timestamp)) {
            return null;
        }
        
        try {
            return Carbon::parse($timestamp)
                ->setTimezone('Asia/Jakarta')
                ->format($format) . ' WIB';
        } catch (\Exception $e) {
            \Log::error('Error converting timestamp to WIB: ' . $e->getMessage());
            return null;
        }
    }
}