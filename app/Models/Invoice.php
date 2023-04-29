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
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'due_date',
        'product',
        'section',
        'discount',
        'rate_vat',
        'value_vat',
        'Total',
        'Status',
        'value_status',
        'note',
        'user',
    ];
}
