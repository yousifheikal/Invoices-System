<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    // Using Trait
    use HasFactory, SoftDeletes;

    // Column in database invoices
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
