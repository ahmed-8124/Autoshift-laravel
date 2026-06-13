<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    protected $fillable = ['name', 'type'];

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
