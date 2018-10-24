<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
	public $incrementing = false;
	
	protected $primaryKey = 'short';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'link', 'short', 'expired_at',
    ];
}
