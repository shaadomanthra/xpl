<?php

$command = escapeshellcmd('python3 /camera/p.py');
    $output = shell_exec($command);
    echo $output;