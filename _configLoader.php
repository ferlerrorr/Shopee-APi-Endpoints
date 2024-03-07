<?php
$envFilePath = __DIR__ . '/config.env';
// Read the custom environment file line by line
$lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Parse each line and set environment variables
foreach ($lines as $line) {
    // Skip lines starting with #
    if (strpos($line, '#') !== false) {
        continue;
    }

    // Split the line into key and value
    list($key, $value) = explode('=', $line, 2);

    // Trim whitespace and quotes from the value
    $key = trim($key);
    $value = trim($value, " \t\n\r\0\x0B\"'");

    // Set the environment variable
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}
