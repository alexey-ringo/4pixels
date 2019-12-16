<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'logo'
    ];

    public function users() {
        return $this->belongsToMany(User::class,'section_user');
    }
}
