<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileStatus extends Model
{
    const PENDING = 1;
    const DOWNLOADING = 2;
    const COMPLETED = 3;
    const ERROR = 4;
}
