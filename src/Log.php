<?php

namespace RemoteManage;

/**
 * Log class.
 * This is intended to be used as a static class, to make it easy to add log messages from anywhere.
 */
class Log
{
    public  static $debugMode = false;
    public  static $errCount = 0;
    private static $startTime = null;
    private static $endTime = null;

    /**
     * Print an error. Do not include a newline character at the end of your message!
     *
     * @param string $str Error string.
     *
     * @return null
     */
    public static function error($str)
    {
        echo "ERROR: $str" . PHP_EOL;
        self::$errCount++;
    }

    /**
     * Set a message. Do not include a newline character at the end of your message!
     *
     * @param string|array $str  Text to be printed. Can be a string or an array of strings.
     *
     * @return null
     */
    public static function msg($str)
    {
        if (is_array($str)) {
            foreach ($str as $s) {
                echo $s . PHP_EOL;
            }
        } else {
            echo $str . PHP_EOL;
        }
    }

    /**
     * Set a debug message, which will only print in debug mode.
     * Do not include a newline character at the end of your message!
     *
     * @param string|array $str  Debug text to be printed. Can be a string or an array of strings.
     *
     * @return null
     */
    public static function debug($str)
    {
        if (self::$debugMode) {
            if (is_array($str)) {
                foreach ($str as $s) {
                    echo $s . PHP_EOL;
                }
            } else {
                echo $str . PHP_EOL;
            }
        }
    }

    /**
     * Set some data. Do not include a newline character at the end of your message!
     *
     * @param string $arr  Array of data to be printed.
     *
     * @return null
     */
    public static function data($arr)
    {
        self::msg(print_r($arr, true));
    }

    /**
     * Execution time management.
     *
     * @param string $op  Stopwatch operation to execute.
     *
     * @return null
     */
    public static function stopWatch($op = 'start')
    {
        switch($op) {
            case 'start':
                self::$startTime = microtime(true);
                self::msg('Starting at ' . date('H:i:s', self::$startTime) . '...');
                break;
            case 'stop':
                self::$endTime = microtime(true);
                self::msg('Job started at ' . date('H:i:s', self::$startTime) . ' and finished at ' . date('H:i:s', self::$endTime) . '.');
                $seconds = self::$endTime - self::$startTime;
                self::msg('Total execution time was ' . floor($seconds / 3600) . gmdate(':i:s', ($seconds % 3600)) . '.');
                self::$startTime = null;
                break;
            case 'time':
                if (isset(self::$startTime)) {
                    $seconds = microtime(true) - self::$startTime;
                    self::msg('Elapsed execution time is ' . floor($seconds / 3600) . gmdate(':i:s', ($seconds % 3600)) . '.');
                }
                break;
            default:
                self::msg('Invalid stopWatch operation.');
        }
    }
}
