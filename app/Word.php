<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Word
 *
 * @package App
 *
 * @method static \Illuminate\Database\Eloquent\Builder select($columns = ['*'])
 * @method static bool insert(array $values)
 */
class Word extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'word',
    ];
}
