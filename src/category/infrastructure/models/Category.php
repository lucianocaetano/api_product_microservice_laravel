<?php

namespace Src\category\infrastructure\models;

use MongoDB\Laravel\Eloquent\Model;

class Category extends Model {

    protected $connection = 'mongodb';
    protected $collection = 'categories';
    protected $primaryKey = '_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        '_id',
        'slug',
        'name',
        'parent',
    ];
}
