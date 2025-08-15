<?php

use App\Models\ItemCategory;
use App\Models\Project;
use App\Models\Propose;
use App\Models\Vendor;
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
Route::middleware(['auth', 'api'])->prefix('api')->group(function () {

    // Get propose items for editing
    Route::get('proposes/{propose}/items', function (Propose $propose) {
        return response()->json($propose->items()->with('category')->get());
    })->name('api.proposes.items');

    // Get vendors by category or search
    Route::get('vendors', function (Request $request) {
        $query = Vendor::active();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('specialty')) {
            $query->whereJsonContains('specialties', $request->specialty);
        }

        return response()->json($query->limit(20)->get());
    })->name('api.vendors');

    // Get item categories
    Route::get('categories', function (Request $request) {
        $query = ItemCategory::active();

        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        } else {
            $query->whereNull('parent_id'); // Only parent categories
        }

        return response()->json($query->get());
    })->name('api.categories');

    // Get projects for selection
    Route::get('projects', function (Request $request) {
        $query = Project::select('id', 'name', 'code');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        return response()->json($query->limit(20)->get());
    })->name('api.projects');
});
