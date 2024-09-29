<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaccine;
use App\Services\CacheService;

/**
 * Class VaccineController
 *
 * Controller for managing operations related to vaccines.
 *
 * @author Alberto Aguiar Neto
 * @since 09/2024
 * 
 */
class VaccineController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cacheKey = 'vaccines_list:' . md5(implode('-', [
            $request->input('name', ''),
            $request->input('batch', ''),
            $request->input('expiration_date_start', ''),
            $request->input('expiration_date_end', ''),
            $request->input('is_active', '')
        ]));

        $this->cacheService->storeCacheKey($cacheKey);

        $vaccines = $this->cacheService->cacheData($cacheKey, function () use ($request) {
            $query = Vaccine::query();

            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->filled('batch')) {
                $query->where('batch', 'like', '%' . $request->batch . '%');
            }

            if ($request->filled('expiration_date_start') && $request->filled('expiration_date_end')) {
                $query->whereBetween('expiration_date', [$request->expiration_date_start, $request->expiration_date_end]);
            }

            if ($request->filled('is_active')) {
                $query->where('is_active', $request->input('is_active'));
            }

            return $query->paginate(10);
        });

        return view('vaccines.index', compact('vaccines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vaccines.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'batch' => 'required|string|max:100',
            'expiration_date' => 'required|date',
            'is_active' => 'boolean',
        ]);

        Vaccine::create($validatedData);

        $this->cacheService->clearCache();

        return redirect()->route('vaccines.index')->with('success', 'Vaccine saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vaccine = Vaccine::findOrFail($id);
        return response()->json($vaccine);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vaccine = Vaccine::findOrFail($id);
        return view('vaccines.form', compact('vaccine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vaccine = Vaccine::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'batch' => 'required|string|max:100',
            'expiration_date' => 'required|date',
            'is_active' => 'boolean',
        ]);

        $vaccine->update($validatedData);

        $this->cacheService->clearCache();

        return redirect()->route('vaccines.index')->with('success', 'Vaccine updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $vaccine = Vaccine::findOrFail($id);
            $vaccine->delete();

            $this->cacheService->clearCache();

            return redirect()->route('vaccines.index')->with('success', 'Vaccine deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('vaccines.index')->withErrors('Error deleting the vaccine. Remember that a vaccine cannot be deleted if it is associated with an employee.');
        }
    }
}
