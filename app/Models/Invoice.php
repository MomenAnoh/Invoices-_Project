<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Section;
use App\Models\Product;
use App\Models\Invoices_attatchment;

class Invoice extends Model
{
    use SoftDeletes;
    // هستعمل الفيلابل بس عشان عطلت عليه ف تحديث حالة الدفع
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'Due_date',
        'product',
        'section_id',
        'Amount_collection',
        'Amount_Commission',
        'Discount',
        'Value_VAT',
        'Rate_VAT',
        'Total',
        'Status',
        'Value_Status',
        'note',
        'Payment_Date',
    ];
    use HasFactory;
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); 
    }
    public function attachments()
    {
        return $this->hasMany(Invoices_attatchment::class, 'invoice_id', 'id');
    }

}
