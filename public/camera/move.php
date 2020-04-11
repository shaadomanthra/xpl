<?php

exec('ls');

$command = escapeshellcmd('python3 p.py');
    $output = shell_exec($command);
    echo $output;