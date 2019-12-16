<?php

declare(strict_types=1);

namespace StudentCornerWeb\Controller\Offer;

use Exception;
use Shared\Domain\ValueObject\Uuid;
use Shared\Infrastructure\Symfony\Controller;
use StudentCorner\Offer\Application\Publish\PublishOfferCommand;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PublishController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $form = $this->publishForm();

        $form->handleRequest($request);

        if ($this->validForm($form)) {
            $userId = $request->attributes->get('user_id');
            $data = $form->getData();
            $command = new PublishOfferCommand(
                Uuid::random()->value(),
                $data['name'],
                $data['school'],
                $data['course'],
                $data['teacher'],
                (int)$data['price'],
                $userId
            );

            try {
                $this->dispatch($command);

                return $this->redirectToRoute('index_get');
            } catch (Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render(
            'offer/publish.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    private function publishForm(): FormInterface
    {
        return $this->formFactory->createBuilder(
            FormType::class,
            null,
            [
                'attr' => ['autocomplete' => 'off'],
            ]
        )
            ->add('name', TextType::class)
            ->add('school', TextType::class)
            ->add('course', TextType::class)
            ->add('teacher', TextType::class)
            ->add('price', NumberType::class)
            ->add('submit', SubmitType::class)
            ->getForm();
    }
}
