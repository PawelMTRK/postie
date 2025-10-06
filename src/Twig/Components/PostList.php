<?php

namespace App\Twig\Components;

use App\Repository\PostRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class PostList
{
    public int $author_id = 0;

    public function __construct(private PostRepository $postRepository)
    {}

    public function getPosts(): array
    {
        if ($this->author_id != 0)
            return $this->postRepository->findByAuthorId($this->author_id);
        else
            return $this->postRepository->findAll();
    }
}
