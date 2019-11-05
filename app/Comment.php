<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Collection;
use App\User;

class Comment extends Model
{
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}