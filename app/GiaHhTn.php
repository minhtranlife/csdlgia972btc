<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiaHhTn extends Model
{//có thể bỏ lên chưa đồng bộ 07.07.18
    protected $table = 'giahhtn';
    protected $filltable = [
        'id',
        'mahh',
        'masopnhom',
        'maloaihh',
        'maloaigiamaloaigia',
        'thitruong',
        'thoigian',
        'mathoidiem',
        'giatu',
        'giaden',
        'dvt',
        'nguontin',
        'mahs',
        'gc'
    ];
}
