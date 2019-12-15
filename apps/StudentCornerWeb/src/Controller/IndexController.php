<?php

declare(strict_types=1);

namespace StudentCornerWeb\Controller;

use Shared\Infrastructure\Symfony\Controller;
use StudentCorner\Offer\Application\OffersResponse;
use StudentCorner\Offer\Application\Show\ShowOffersQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class IndexController extends Controller
{
    public function __invoke(Request $request): Response
    {
        /** @var OffersResponse $offers */
        $offers = $this->ask(new ShowOffersQuery([], 'publishedAt', 'desc', 6, 0));

        return $this->render('index.html.twig', ['offers' => $offers->offers()]);
    }
}
