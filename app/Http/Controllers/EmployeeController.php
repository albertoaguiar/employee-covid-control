<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\CpfService;
use App\Models\Employee;
use App\Models\Vaccine;
use App\Jobs\GenerateUnvaccinatedReport;

/**
 * Class EmployeeController
 *
 * Controller for managing operations related to employees.
 *
 * @author Alberto Aguiar Neto
 * @since 09/2024
 * 
 */
class EmployeeController extends Controller
{
    protected $cpfService;

    public function __construct(CpfService $cpfService)
    {
        $this->cpfService = $cpfService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::query();
    
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        if ($request->filled('cpf')) {

            $cpf_hash = $this->cpfService->processCpf($request->cpf)['cpf_hash'];
            $query->where('cpf_hash', $cpf_hash);
        }
    
        if ($request->filled('vaccine_id')) {
            $query->where('vaccine_id', $request->vaccine_id);
        }

        if ($request->filled('first_dose_date_start') && $request->filled('first_dose_date_end')) {
            $query->whereBetween('date_first_dose', [$request->first_dose_date_start, $request->first_dose_date_end]);
        }

        if ($request->filled('second_dose_date_start') && $request->filled('second_dose_date_end')) {
            $query->whereBetween('date_second_dose', [$request->second_dose_date_start, $request->second_dose_date_end]);
        }

        if ($request->filled('third_dose_date_start') && $request->filled('third_dose_date_end')) {
            $query->whereBetween('date_third_dose', [$request->third_dose_date_start, $request->third_dose_date_end]);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->input('is_active'));
        }
    
        $employees = $query->paginate(10);
    
        $vaccines = Vaccine::all();
    
        return view('employees.index', compact('employees', 'vaccines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vaccines = Vaccine::where('is_active', 1)->get();
    
        return view('employees.form', compact('vaccines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'cpf' => 'required|string|max:14',
                'name' => 'required|string|max:255',
                'birth_date' => 'required|date|before_or_equal:today',
                'date_first_dose' => 'nullable|date|before_or_equal:today',
                'date_second_dose' => 'nullable|date|before_or_equal:today',
                'date_third_dose' => 'nullable|date|before_or_equal:today',
                'vaccine_id' => 'exists:vaccines,id',
                'comorbidity' => 'boolean',
                'comorbidity_desc' => 'nullable|string|max:255',
                'is_active' => 'boolean',
            ], [
                'birth_date.before_or_equal' => 'The Date of Birth field must be a date before or equal to today.',
            ]);
    
            $processedCpf = $this->cpfService->processCpf($request->cpf);
    
            if (Employee::where('cpf_hash', $processedCpf['cpf_hash'])->exists()) {
                return redirect()->back()->withErrors('The CPF has already been registered.');
            }
    
            $validatedData['cpf_hash'] = $processedCpf['cpf_hash'];
            $validatedData['cpf_prefix'] = $processedCpf['cpf_prefix'];
    
            unset($validatedData['cpf']);
    
            Employee::create($validatedData);
            
            return redirect()->route('employees.index')->with('success', 'Employee saved successfully!');
        } catch(\InvalidArgumentException $e) {
            return redirect()->back()->withErrors(['cpf' => $e->getMessage()])->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['general' => 'An error occurred.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with('vaccine')->findOrFail($id);
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        
        $vaccines = Vaccine::all();

        return view('employees.form', compact('employee', 'vaccines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $employee = Employee::findOrFail($id);
    
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'birth_date' => 'required|date|before_or_equal:today',
                'date_first_dose' => 'nullable|date|before_or_equal:today',
                'date_second_dose' => 'nullable|date|before_or_equal:today',
                'date_third_dose' => 'nullable|date|before_or_equal:today',
                'vaccine_id' => 'exists:vaccines,id',
                'comorbidity' => 'boolean',
                'comorbidity_desc' => 'nullable|string|max:255',
                'is_active' => 'boolean',
            ], [
                'birth_date.before_or_equal' => 'The Date of Birth field must be a date before or equal to today.',
            ]);
    
            unset($validatedData['cpf']);
            $employee->update($validatedData);
            
            return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['cpf' => 'An error occurred while updating the employee. Please try again later.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
    
            return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->withErrors('Error deleting the employee. Try it again later.');
        }
    }

    /**
     * Generate report.
     */
    public function generateUnvaccinatedReport()
    {
        try {
            GenerateUnvaccinatedReport::dispatch();
    
            return response()->json([
                'success' => true,
                'message' => 'Unvaccinated report is being generated.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while generating the report.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
