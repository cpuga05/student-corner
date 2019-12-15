<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony;

use Shared\Domain\Bus\Command\Command;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Bus\Query\Query;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Domain\Bus\Query\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

abstract class Controller extends AbstractController
{
    /** @var CommandBus */
    private $commandBus;
    /** @var QueryBus */
    private $queryBus;
    /** @var FormFactoryInterface */
    protected $formFactory;

    public function __construct(
        CommandBus $commandBus,
        QueryBus $queryBus,
        FormFactoryInterface $formFactory
    ) {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->formFactory = $formFactory;
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

    protected function ask(Query $query): Response
    {
        return $this->queryBus->ask($query);
    }

    protected function validForm(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            return true;
        }

        foreach ($form->getErrors(true) as $error) {
            $this->addFlash('error', $error->getMessage());
        }

        return false;
    }
}
