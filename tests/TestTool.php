<?php

namespace App\Tests;

final class TestTool
{
    /**
     * @param int $length
     * @return string
     */
    static function generateString(int $length): string
    {
        $string = '';
        while (strlen($string) < $length) {
            $string = $string .'a';
        }
        return $string;
    }
}
