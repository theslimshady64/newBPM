<?php

namespace App\Catalog;

class ConversionMetrics
{
    /**
     * Перевод байт в мегабайты
     *
     * @param integer $bytes
     * @return string
     */
    public static function bytesToMegabytes($bytes)
    {
        if ($bytes < 1000 * 1024) {
            return number_format($bytes / 1024, 2) . " KB";
        } elseif ($bytes < 1000 * 1048576) {
            return number_format($bytes / 1048576, 2) . " MB";
        }
    }
}
