<?php

namespace Src\product\infrastructure\models;

use Laravel\Scout\Searchable;
use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    use Searchable;

    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'id',
        'slug',
        'name',
        'description',
        'quantity',
        'price',
        'currency',
        'category_slug',
    ];

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'category_slug' => $this->category_slug,
            'description' => $this->description,
            'price' => $this->price,
        ];
    }
}
