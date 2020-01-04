<?php

declare(strict_types=1);

namespace StudentCornerWeb\Controller\Api\Offers;

use Shared\Infrastructure\Symfony\Controller;
use StudentCorner\Offer\Application\OfferResponse;
use StudentCorner\Offer\Application\OffersResponse;
use StudentCorner\Offer\Application\Show\ShowOffersQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use function Lambdish\Phunctional\reduce;

final class OffersGetController extends Controller
{
    public function __invoke(Request $request): Response
    {
        /** @var OffersResponse $offers */
        $offers = $this->ask(new ShowOffersQuery([], 'publishedAt', 'desc', 6, 0));

        $offers = reduce(
            static function (array $coll, OfferResponse $offer) {
                $coll[] = [
                    'id' => $offer->id(),
                    'name' => $offer->name(),
                    'school' => $offer->school(),
                    'course' => $offer->course(),
                    'teacher' => $offer->teacher(),
                    'price' => $offer->price(),
                    'user_id' => $offer->userId(),
                    'published_at' => $offer->publishedAt(),
                ];

                return $coll;
            },
            $offers->offers(),
            []
        );

        $response = new JsonResponse($offers);

        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}
