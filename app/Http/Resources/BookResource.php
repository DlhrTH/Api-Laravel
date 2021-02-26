<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class BookResource extends BaseResource
{
    public static $map = [
        'id' => 'identifier',
        'title' => 'title',
        'description' => 'details',
        'updated_at' => 'last_modified',
        'created_at' => 'creation_date',
    ];

    public function generateLinks($request)
    {
        return [
            [
                'rel' => 'self',
                'href' => route('books.show', $this->id),
            ],
        ];
    }
}
