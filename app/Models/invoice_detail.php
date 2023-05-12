<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'id_Invoice',
        'product',
        'section',
        'Status',
        'Value_Status',
        'note',
        'user',
        'Payment_Date',
    ];

}
