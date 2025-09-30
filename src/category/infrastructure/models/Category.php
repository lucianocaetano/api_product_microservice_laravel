<?php

namespace Src\category\infrastructure\models;

use MongoDB\Laravel\Eloquent\Model;

class Category extends Model {

    protected $connection = 'mongodb';
    protected $collection = 'categories';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'slug',
        'name',
        'parent',
    ];
}
