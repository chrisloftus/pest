<?php

use PHPUnit\Framework\ExpectationFailedException;

test('passes', function () {
    expect(41)->toBeLessThanOrEqual(42);
    expect(4)->toBeLessThanOrEqual(4);
});

test('failures', function () {
    expect(4)->toBeLessThanOrEqual(3.9);
})->throws(ExpectationFailedException::class);

test('failures with custom message', function () {
    expect(4)->toBeLessThanOrEqual(3.9, 'oh no!');
})->throws(ExpectationFailedException::class, 'oh no!');

test('not failures', function () {
    expect(5)->not->toBeLessThanOrEqual(5);
})->throws(ExpectationFailedException::class);
