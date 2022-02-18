<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Redaktur extends Model
{
    use HasFactory;

    protected $fillable = [
        'redakturNama',
        'redakturEmail',
        'redakturNomor',
        'redakturAlamat',
        'redakturUniv',
        'redakturFakultas',
        'redakturProdi',
        'redakturKuliah',
        'redakturMapaba',
        'redakturFoto',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i, d M Y');
    }
}