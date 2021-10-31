<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerPreference extends Model
{
    public $table = 'partnerPreference';
    use HasFactory;

    protected $fillable = [
        'user_id',
        'minExpectedIncome',
        'maxExpectedIncome',
        'occupation',
        'familyType',
        'manglik'
    ];
}
