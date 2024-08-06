<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function viewPublisher($id){
        $publisher = Publisher::find($id);
        if(!$publisher){
            return response()->json(['errorr' => 'Publisher not found'], 404);
        }

        return response()->json($publisher, 200);
    }

    public function viewLogo($id){
        $publisher = Publisher::find($id);

        if (!$publisher) {
            return response()->json(['error' => 'Publisher not found'], 404);
        }

        $logo = $publisher->getFirstMedia('logo');

        if (!$logo) {
            return response()->json(['error' => 'Publisher logo not found'], 404);
        }

        return response()->file($logo->getPath());
    }
}
