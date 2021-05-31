<?php


namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    private $rules = [
        'name' => 'required|max:255',
        'is_active' => 'boolean'
    ];

    public function index()
    {
        return Gender::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        return Gender::create($request->all());
    }

    public function show(Gender $genre)
    {
        return $genre;
    }

    public function update(Request $request, Gender $genre)
    {
        $this->validate($request, $this->rules);
        $genre->update($request->all());
        return $genre;
    }

    public function destroy(Gender $genre)
    {
        $genre->delete();
        return response()->noContent();
    }
}
