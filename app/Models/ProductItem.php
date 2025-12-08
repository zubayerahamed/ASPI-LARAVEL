<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    protected $fillable = [
        'product_id',
        'product_behaviour',

        // Identification
        'sku',
        'barcode',
        // 'manufacturer_sku',
        // 'country_of_origin',

        // Units and Conversions
        'base_unit',
        'purchase_unit',
        'purchase_conversion',
        'sell_unit',
        'sell_conversion',

        // Dimensions
        'weight_unit',
        'weight',
        'dimension_unit',
        'length',
        'width',
        'height',

        // Shipping
        'volumetric_weight',
        'shipping_charge',
        'free_shipping',

        // Expiry Details
        // 'is_perishable',
        // 'expiry_period',
        // 'expiry_period_type',
        // 'alert_before_expiry',
        // 'storage_temp_min',
        // 'storage_temp_max',
        // 'storage_instructions',

        // Inventory
        // 'is_fragile',
        // 'is_service',
        // 'is_digital',
        'is_downloadable',
        // 'is_batch_managed',
        // 'is_serialized',
        'stock_track',
        'stock_status',
        'backorder_type',
        // 'min_order_qty',
        // 'max_order_qty',
        // 'lead_time_days',
        'reorder_point',
        'max_stock_level',

        // General
        // 'price',
        // 'discount_type',
        // 'discount_amt',
        // 'selling_price',
        // 'is_discount_scheduled',
        // 'discount_start_date',
        // 'discount_start_time',
        // 'discount_end_date',
        // 'discount_end_time',
        // 'cost_price',

        'tax_category_id',

        // 'prepare_time',
        // 'warranty_type',
        // 'warranty_period',
        // 'warranty_period_type',
        'download_limit',
        'download_expiry',
    ];


}
