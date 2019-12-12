<?php

declare(strict_types=1);

namespace StudentCornerWeb\Controller;

use Shared\Infrastructure\Symfony\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class IndexController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return $this->render('layout/layout.html.twig');
    }
}
