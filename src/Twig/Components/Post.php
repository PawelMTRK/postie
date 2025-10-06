<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use App\Entity\Post as PostEntity;

#[AsTwigComponent]
final class Post
{
    public PostEntity $post;
}
