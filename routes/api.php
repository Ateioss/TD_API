<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/', function () {
    //
})->middleware(['first', 'second']);

Route::get("/cours", function () {
    return \App\Models\Cour::all();
});

Route::get('/cours/{courId}', function ($courId) {
    $cour = \App\Models\Cour::find($courId);

    if ($cour) {
        return $cour;
    }

    return response("Cour not found", 404);
});

Route::put('/cours/{courId}', function ($courId) {
    $cour = \App\Models\Cour::find($courId);

    $formData = request()->only(['title', 'content', 'done', 'priority']);

    request()->validate([
        'title'    => 'required',
        'content'  => 'required',
        'done'     => 'required',
        'priority' => 'required'
    ]);

    $cour->update($formData);
});

Route::post('/cours', function () {
    request()->validate([
        'nom' => 'required|string',
        'programme' => 'required|string',
        'description' => 'required|string',
        'year' => 'required|date',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date',
        'image_url' => 'required|string',
    ]);

    $data = request()->all();

    return \App\Models\Cour::create($data);

});
Route::delete('/cours/{courId}', function ($CourId) {
    $Cour = \App\Models\Cour::find($CourId);

    if(!$Cour) {
        return response("Not found", 404);
    }

    $Cour->delete();
});
