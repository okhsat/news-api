<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index()
    {
        return Source::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'code'     => 'required|string|max:255|unique:sources,code',
            'api_url'  => 'nullable|url',
            'logo_url' => 'nullable|url',
            'enabled'  => 'boolean'
        ]);

        return Source::create($data);
    }

    public function show(Source $source)
    {
        return $source;
    }

    public function update(Request $request, Source $source)
    {
        $data = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'code'     => "sometimes|required|string|max:255|unique:sources,code,{$source->id}",
            'api_url'  => 'nullable|url',
            'logo_url' => 'nullable|url',
            'enabled'  => 'boolean'
        ]);

        $source->update($data);

        return $source;
    }

    public function destroy(Source $source)
    {
        $source->delete();

        return response()->noContent();
    }
}