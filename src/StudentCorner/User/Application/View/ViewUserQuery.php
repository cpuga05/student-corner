<?php

declare(strict_types=1);

namespace StudentCorner\User\Application\View;

use Shared\Domain\Bus\Query\Query;

final class ViewUserQuery implements Query
{
    /** @var string */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
