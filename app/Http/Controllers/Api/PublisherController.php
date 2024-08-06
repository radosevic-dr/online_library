<?php

namespace App\Http\Controllers\Api;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class PublisherController extends Controller
{
    public function createPublisher(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255', Rule::unique('publishers', 'name')],
            'logo' => ['required', 'file', 'mimes:jpeg,jpg,png,svg', 'max:1024'],
            'address' => ['required'],
            'website' => ['required', 'url'],
            'established_year' => ['required', 'integer'],
            'email' => ['required', 'email', Rule::unique('publishers', 'email')],
            'phone' => ['required', 'numeric'],
        ]);

        $publisher = Publisher::create($validatedData);

        if ($request->hasFile('logo')) {
            $publisher->addMedia($request->file('logo'))->toMediaCollection('logo');
        }

        return $publisher;
    }
}
