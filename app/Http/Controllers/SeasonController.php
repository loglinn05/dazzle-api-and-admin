<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SeasonController extends Controller
{
    public function index()
    {
        return Season::all();
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:seasons',
        ]);
        $season = new Season();
        $season->title = $validated["title"];
        $season->save();
    }

    public function show($id)
    {
        return Season::find($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('seasons')->ignore($id)
            ],
        ]);
        $season = Season::find($id);
        $season->title = $validated["title"];
        $season->save();
    }

    public function delete($id)
    {
        Season::destroy($id);
    }
}
