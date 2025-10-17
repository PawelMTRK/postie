<?php

namespace App\Controller;

use App\Form\Type\UserSettingsType;
use App\Form\Type\UserType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route(path: '/register', name: 'user_register')]
    public function register(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $plainPass = $user->getPassword();
            $hashedPass = $passwordHasher->hashPassword(
                $user,
                $plainPass
            );
            $user->setPassword($hashedPass);
            $em->persist($user);
            $em->flush();
            return $this->redirect('/');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/login', name: 'user_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        // HACK: uses form without data, login is handled auto
        // move the stuff into UserType class
        // instead of login.html.twig template
        // https://symfony.com/doc/current/security.html#form-login

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        $form = $this->createForm(UserType::class);

        return $this->render('user/login.html.twig', [
            'error' => $error,
            'form' => $form,
        ]);
    }

    #[Route(path: '/user/{nickname}', name: 'user_profile')]
    public function profile(string $nickname, EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(User::class)->findOneBy(['nickname' => $nickname]);
        return $this->render('user/profile.html.twig', [
            'user' => $user
        ]);
    }
    #[Route(path: '/settings', name: 'user_edit')]
    public function settings(Request $request, EntityManagerInterface $em): Response
    {
        // TODO more fields and nickname checking
        $user = $this->getUser();
        $form = $this->createForm(UserSettingsType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User */
            $user = $form->getData();
            $em->persist($user);
            $em->flush();
            return $this->redirect('/user/' . $user->getNickname());
        }

        return $this->render('user/settings.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route(path: '/logout', name: 'user_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
