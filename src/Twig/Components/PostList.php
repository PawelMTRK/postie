<?php

namespace App\Twig\Components;

use App\Repository\PostRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class PostList
{
    public function __construct(private PostRepository $postRepository)
    {}
    
    public function getPosts(): array
    {
        return $this->postRepository->findAll();
    }
}
