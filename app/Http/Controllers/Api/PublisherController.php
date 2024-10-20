<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use App\Models\User;
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

    public function viewAllPublishers(Request $request)
    {
        try {
            $perPageOptions = [20, 50, 100];

            $searchValue = $request->input('search', '');
            $perPage = $request->input('per_page', 20);

            if (!in_array($perPage, $perPageOptions)) {
                $perPage = 20;
            }

            $validator = validator()->make($request->all(), [
                'search' => 'string',
                'per_page' => 'integer|in:' . implode(',', $perPageOptions),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Invalid parameters',
                    'message' => $validator->errors()
                ], 400);
            }

            $query = Publisher::query();
            if (!empty($searchValue)) {
                $query->where('name', 'LIKE', "%{$searchValue}%");
            }

            $publishers = $query->paginate($perPage);

            return response()->json([
                'data' => PublisherResource::collection($publishers),
                'meta' => [
                    'total' => $publishers->total(),
                    'per_page' => $publishers->perPage(),
                    'current_page' => $publishers->currentPage(),
                    'last_page' => $publishers->lastPage(),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
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
