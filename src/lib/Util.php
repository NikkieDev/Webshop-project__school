<?php

declare(strict_types=1);

class Util
{
    public static function verifyPropertyExists($haystack, $needleArray)
    {
        foreach ($needleArray as $needle) {
            if ($haystack[$needle]) {
                return;
            }

            throw new Exception("Property " . $needle . " is missing");
        }
    }

    public static function renderErrorPage(int $statusCode, string $message)
    {
        header("Location: /error/" . (string) $statusCode . ".php");
        die($message);
    }
}