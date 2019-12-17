<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Domain;

use Shared\Domain\DomainError;

use function sprintf;

final class OfferAlreadyExist extends DomainError
{
    /** @var OfferId */
    private OfferId $id;

    public function __construct(OfferId $id)
    {
        $this->id = $id;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'offer.already_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The offer <%s> already exist', $this->id->value());
    }
}
