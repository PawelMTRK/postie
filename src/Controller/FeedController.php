<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\Type\PostType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\DateTime;

final class FeedController extends AbstractController
{
    #[Route('/', name: 'app_feed')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setPostedOn(new DateTimeImmutable());
            $post->setAuthor($this->getUser());

            $em->persist($post);
            $em->flush();

            return $this->redirect('/');
        }

        return $this->render('feed/index.html.twig', [
            'controller_name' => 'FeedController',
            'form' => $form,
        ]);
    }
}
