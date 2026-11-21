<?php

namespace App\Models;

use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'summary', 'content', 'preview_image', 'full_image'])]
class Article extends Model
{
    /** @use HasFactory<ArticleFactory> */
    use HasFactory;

    public const IMAGES = [
        'full.jpeg' => 'preview.jpg',
        'full_2.jpeg' => 'preview_2.jpg',
    ];
}
