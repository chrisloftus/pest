<?php

declare(strict_types=1);

namespace Pest\Bootstrappers;

use Pest\Contracts\Bootstrapper;
use Pest\Support\View;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @internal
 */
final class BootView implements Bootstrapper
{
    public function __construct(
        private readonly OutputInterface $output
    ) {
        // ..
    }

    /**
     * Boots the view renderer.
     */
    public function boot(): void
    {
        View::renderUsing($this->output);
    }
}
