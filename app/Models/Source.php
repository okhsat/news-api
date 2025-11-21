<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Source extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'code',
        'api_url',
        'logo_url',
        'enabled',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function syncLogs(): HasMany
    {
        return $this->hasMany(SyncLog::class);
    }
}