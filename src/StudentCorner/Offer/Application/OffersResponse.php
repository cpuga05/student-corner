<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Application;

use Shared\Domain\Bus\Query\Response;
use StudentCorner\Offer\Domain\Offers;

final class OffersResponse implements Response
{
    /** @var OfferResponse[] */
    private $offers;

    public function __construct(OfferResponse ...$offers)
    {
        $this->offers = $offers;
    }

    public static function fromOffers(Offers $offers): self
    {
        $collection = [];

        foreach ($offers as $offer) {
            $collection[] = OfferResponse::fromOffer($offer);
        }

        return new self(...$collection);
    }

    public function offers(): array
    {
        return $this->offers;
    }
}
