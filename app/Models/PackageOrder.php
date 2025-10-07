<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageOrder extends Model
{
    use HasFactory;

    protected $table = "package_orders"; // Good practice to explicitly define table name
    protected $fillable = [
        "client_name",
        "email",
        "phone",
        "package_type",
        "package_class",
        "amount",               // This will be the total amount (base + GST)
        "payment_status",
        "cashfree_order_id",    // To store the Cashfree order ID
        "payment_session_id",   // To store the Cashfree payment session ID
        "transaction_id",       // To store the Cashfree transaction ID (payment_id from webhook)
        "payment_completed_at", // Timestamp for when the payment was completed
        "base_amount",          // To store the amount before GST
        "gst_amount",           // To store the calculated GST amount
        "remarks",
    ];

    protected $casts = [
        'amount' => 'float',
        'base_amount' => 'float',
        'gst_amount' => 'float',
        'payment_completed_at' => 'datetime',
    ];
}
