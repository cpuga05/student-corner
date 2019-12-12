<?php

declare(strict_types=1);

namespace StudentCornerWeb\Controller\User;

use Shared\Infrastructure\Symfony\Controller;
use StudentCorner\User\Application\SignOut\SignOutUserCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SignOutController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $command = new SignOutUserCommand();

        $this->dispatch($command);

        return $this->redirectToRoute('index_get');
    }
}
