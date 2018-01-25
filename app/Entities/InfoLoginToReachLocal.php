<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class InfoLoginToReachLocal.
 *
 * @package namespace App\Entities;
 */
class InfoLoginToReachLocal extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'client_id', 'client_secret', 'grant_type', 'username', 'password', 'refresh_token', 'access_token'];


    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table= '';

    public $timestamps= true;
}
