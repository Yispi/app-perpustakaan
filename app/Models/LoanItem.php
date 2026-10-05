<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// File: app/Models/LoanItem.php
class LoanItem extends Model
{
    protected $fillable = ['loan_id', 'book_id'];
}