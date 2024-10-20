<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        try {
            $publisher = Publisher::create($validatedData);

            if ($request->hasFile('logo')) {
                $publisher->addMedia($request->file('logo'))->toMediaCollection('logo');

                $publisher->addMedia($request->file('logo'))->toMediaCollection('logo');
            }

            return response()->json($publisher);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while trying to create the publisher'], 500);
        }
    }

    public function viewAllPublishers(Publisher $publisher, Request $request)
    {
//        $perPageOptions = [20, 50, 100];
//
//        $perPage = $request->input('per_page', 20);
//
//        if (!in_array($perPage, $perPageOptions)) {
//            $perPage = 20;
//        }
//
//        return PublisherResource::collection(Publisher::paginate($perPage));
    }

    public function viewPublisher($id)
    {
        if (auth()->user()->user_type !== User::USER_TYPE_LIBRARIAN) {
            return response()->json(['error' => 'Unauthorized'], 422);
        }

        $publisher = Publisher::findOrFail($id);

        return response()->json($publisher);
    }

    public function deletePublisher($id)
    {
        try {
            $publisher = Publisher::findOrFail($id);

            $publisher->delete();
            return response()->json([
                $id,
                'message' => 'Publisher deleted successfully.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function getPublisherLogo(Publisher $publisher)
    {
        return $publisher->getFirstMediaUrl('logo');
    }
}
