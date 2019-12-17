<?php

declare(strict_types=1);

namespace StudentCorner\Shared\Infrastructure\Twig;

use StudentCorner\User\Domain\Authenticate;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TemplateHelper extends AbstractExtension
{
    /** @var Authenticate */
    private Authenticate $authenticate;

    public function __construct(Authenticate $authenticate)
    {
        $this->authenticate = $authenticate;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('auth', [$this, 'auth']),
        ];
    }

    public function auth(): bool
    {
        return $this->authenticate->isAlreadyAuthenticated();
    }
}
