<?php

use Symfony\Component\Process\Process;

$run = function (string $target, $decorated = false) {
    $process = new Process(['php', 'bin/pest', $target, '--colors=always'], dirname(__DIR__, 2),
        ['COLLISION_PRINTER' => 'DefaultPrinter', 'COLLISION_IGNORE_DURATION' => 'true'],
    );

    $process->run();

    return $decorated ? $process->getOutput() : preg_replace('#\\x1b[[][^A-Za-z]*[A-Za-z]#', '', $process->getOutput());
};

$snapshot = function ($name) {
    $testsPath = dirname(__DIR__);

    return file_get_contents(implode(DIRECTORY_SEPARATOR, [
        $testsPath,
        '.snapshots',
        "$name.txt",
    ]));
};

test('allows to run a single test', function () use ($run, $snapshot) {
    expect($run('tests/Fixtures/DirectoryWithTests/ExampleTest.php'))->toContain($snapshot('allows-to-run-a-single-test'));
})->skip(PHP_OS_FAMILY === 'Windows');

test('allows to run a directory', function () use ($run, $snapshot) {
    expect($run('tests/Fixtures'))->toContain($snapshot('allows-to-run-a-directory'));
})->skip(PHP_OS_FAMILY === 'Windows');

it('disable decorating printer when colors is set to never', function () use ($snapshot) {
    $process = new Process([
        'php',
        './bin/pest',
        '--colors=never',
        'tests/Fixtures/DirectoryWithTests/ExampleTest.php',
    ], dirname(__DIR__, 2), ['COLLISION_PRINTER' => 'DefaultPrinter', 'COLLISION_IGNORE_DURATION' => 'true']);
    $process->run();
    $output = $process->getOutput();
    expect($output)->toContain($snapshot('disable-decorating-printer'));
})->skip(PHP_OS_FAMILY === 'Windows');
