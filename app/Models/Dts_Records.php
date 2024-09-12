<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dts_Records extends Model
{
    use HasFactory;
    protected $table = 'dts_records';
    protected $fillable = [
        'dts_id',
        'tracking_number',
        'doc_type',
        'doc_title',
        'doc_subject',
        'doc_urgency',
        'actual_urgency',
        'mayors_approval',
        'originating_office',
        'latest_transaction',
        'receiving_office',
        'forward_to_office',
        'receiver_type',
        'released_date',
        'returned_date',
        'released_by',
        'returned_by',
        'released_remarks',
        'received_remarks',
        'returned_remarks',
        'mayors_remarks',
        'status',
        'created_at',
        'updated_at',
    ];  
}
