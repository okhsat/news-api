<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SyncLog extends Model
{
    protected $fillable = [
        'source_id',
        'synced_at',
        'fetched_count',
        'status',
        'message'
    ];

    protected $dates = ['synced_at'];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }
}