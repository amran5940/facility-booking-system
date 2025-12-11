<?php

use CodeIgniter\CLI\CLI;

// The main Exception
CLI::write('[' . $exception::class . ']', 'light_gray', 'red');
CLI::write($message);
CLI::write('at ' . CLI::color(clean_path($exception->getFile()) . ':' . $exception->getLine(), 'green'));
CLI::newLine();

$last = $exception;

while ($prevException = $last->getPrevious()) {
    $last = $prevException;

    CLI::write('  Caused by:');
    CLI::write('  [' . $prevException::class . ']', 'red');
    CLI::write('  ' . $prevException->getMessage());
    CLI::write('  at ' . CLI::color(clean_path($prevException->getFile()) . ':' . $prevException->getLine(), 'green'));
    CLI::newLine();
}