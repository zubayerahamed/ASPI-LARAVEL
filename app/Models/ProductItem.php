<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    protected $fillable = [
        'product_id',
        'product_behaviour',

        'thumbnail_id',

        'is_item_active',
        'is_listed',
        'is_featured',
        'is_trending',
        'is_highlighted',
        'is_for_purchase',
        'is_for_sell',
        'is_downloadable',

        // Identification
        'sku',
        'barcode',
        // 'manufacturer_sku',
        // 'country_of_origin',

        // Units and Conversions
        'base_unit',
        'consumption_type',
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

    protected $casts = [
        'is_item_active' => 'boolean',
        'is_listed' => 'boolean',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_highlighted' => 'boolean',
        'is_for_purchase' => 'boolean',
        'is_for_sell' => 'boolean',
        'is_downloadable' => 'boolean',
        'free_shipping' => 'boolean',
        'stock_track' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_item_active', true);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function thumbnail()
    {
        return $this->belongsTo(Cadoc::class, 'thumbnail_id');
    }

}
