<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Throwable;

final class DoctrineTransactionMiddleware implements MiddlewareInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(
        Envelope $envelope,
        StackInterface $stack
    ): Envelope {
        $entityManager = $this->entityManager;

        $entityManager->getConnection()->beginTransaction();

        try {
            $envelope = $stack->next()->handle($envelope, $stack);

            $entityManager->flush();
            $entityManager->getConnection()->commit();

            return $envelope;
        } catch (Throwable $exception) {
            $entityManager->getConnection()->rollBack();

            if ($exception instanceof HandlerFailedException) {
                // Remove all HandledStamp from the envelope so the retry will execute all handlers again.
                // When a handler fails, the queries of allegedly successful previous handlers just got rolled back.
                //throw new HandlerFailedException($exception->getEnvelope()->withoutAll(HandledStamp::class), $exception->getNestedExceptions());
                throw $exception->getPrevious();
            }

            throw $exception;
        }
    }
}
