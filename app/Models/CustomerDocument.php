<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
    use HasFactory;

    CONST TYPE_ID = 1;
    CONST TYPE_PASSPORT = 2;
    CONST TYPE_DRIVING_LICENSE = 3;
    CONST TYPE_CONSULER_ID = 4;
    CONST TYPE_PICTURE = 5;
    CONST TYPE_OTHER = 6;
    CONST TYPES = [
        self::TYPE_ID => 'ID',
        self::TYPE_PASSPORT => 'Passport',
        self::TYPE_DRIVING_LICENSE => 'Driving License',
        self::TYPE_CONSULER_ID => 'Consuler ID',
        self::TYPE_PICTURE => 'Picture',
        self::TYPE_OTHER => 'Other',
    ];

    protected $fillable = [
        'customer_id',
        'description',
        'type',
        'file',
        'expiration_date',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['type_text'];

    public function getTypeTextAttribute()
    {
        return self::TYPES[$this->type] ?? '';
    }
}
