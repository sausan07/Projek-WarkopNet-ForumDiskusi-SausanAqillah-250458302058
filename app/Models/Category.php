<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{

    protected $fillable = [ 'name', 'slug'];

    public function threads(){
        return $this->hasMany(Thread::class);
    }

    public function getRouteKeyName() {
        return 'slug';
    }
}
