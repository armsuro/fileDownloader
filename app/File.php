<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'url',
        'file_size',
        'hash'
    ];

    public function status() {
        return $this->belongsTo('App\FileStatus', 'status_id');
    }
}
