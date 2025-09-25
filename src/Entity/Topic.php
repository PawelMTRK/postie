<?php

namespace App\Entity;

enum Topic: string
{
    case Technology = 'tech';
    case Nature = 'nature';
    case Music = 'music';
    case Photography = 'photo';
    case Cinema = 'cinema';
    case Books = 'books';
}
