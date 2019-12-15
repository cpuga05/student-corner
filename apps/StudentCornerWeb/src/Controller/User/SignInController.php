<?php

declare(strict_types=1);

namespace StudentCornerWeb\Controller\User;

use Shared\Infrastructure\Symfony\Controller;
use StudentCorner\User\Application\SignIn\SignInUserCommand;
use StudentCorner\User\Domain\UserNotExist;
use StudentCorner\User\Domain\UserPasswordInvalid;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SignInController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $form = $this->signInForm();

        $form->handleRequest($request);

        if ($this->validForm($form)) {
            $data = $form->getData();
            $command = new SignInUserCommand($data['email'], $data['password']);

            try {
                $this->dispatch($command);

                return $this->redirectToRoute('index_get');
            } catch (UserNotExist | UserPasswordInvalid $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render(
            'users/sign-in.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    private function signInForm(): FormInterface
    {
        return $this->formFactory->createBuilder(
            FormType::class,
            null,
            [
                'attr' => ['autocomplete' => 'off'],
            ]
        )
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('submit', SubmitType::class)
            ->getForm();
    }
}
