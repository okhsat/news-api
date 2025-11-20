<?php

namespace App\Http\Controllers;

use App\Models\SyncLog;

class SyncLogController extends Controller
{
    public function index()
    {
        return SyncLog::with('source')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function show(SyncLog $syncLog)
    {
        return $syncLog->load('source');
    }
}