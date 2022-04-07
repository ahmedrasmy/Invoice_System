<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_invoice',
        'invoice_number',
        'product',
        'section_id',
        'status',
        'value_status',
        'note',
        'user',
        'payment_date',
    ];
    // invoiceDetails belongsTo section 
    public function section(){
        return $this->belongsTo('App\Models\Section');
    }
}
