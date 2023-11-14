<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    CONST TYPE_ASSET = 1;
    CONST TYPE_LIABILITY = 2;
    CONST TYPE_EQUITY = 3;
    CONST TYPE_REVENUE = 4;
    CONST TYPE_EXPENSE = 5;
    CONST TYPES = [
        self::TYPE_ASSET => 'Asset',
        self::TYPE_LIABILITY => 'Liability',
        self::TYPE_EQUITY => 'Equity',
        self::TYPE_REVENUE => 'Revenue',
        self::TYPE_EXPENSE => 'Expense',
    ];

    protected $fillable = [
        'ref',
        'name',
        'type',
        'created_by',
        'updated_by'
    ];

    protected $appends = ['type_name'];

    public function getTypeNameAttribute()
    {
        return self::TYPES[$this->type] ?? '';
    }
}
