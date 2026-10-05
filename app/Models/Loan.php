<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// File: app/Models/Loan.php
class Loan extends Model
{
    protected $fillable = [
        'member_id', 'user_id', 'tanggal_pinjam',
        'tanggal_kembali', 'tanggal_dikembalikan', 'status',
    ];
}
