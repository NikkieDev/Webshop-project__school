<?php

if (empty($argv[1])) {
    die("No arguments given.");
}

echo password_hash($argv[1], PASSWORD_DEFAULT) . "\n";

?>