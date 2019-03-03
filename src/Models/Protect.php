<?php

namespace Jaybizzle\BladeProtect\Models;

use Illuminate\Database\Eloquent\Model;

class Protect extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'protect';

    public $fillable = ['name', 'user_id', 'identifier'];
}
