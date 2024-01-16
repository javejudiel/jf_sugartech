<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('index', compact('employees'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'birthday' => 'required|date',
                'monthly_salary' => 'required|numeric',
            ]);

            Employee::create($request->all());

            return redirect()->route('index')->with('success', 'Employee created successfully!');
        } catch (Exception $e) {
            return redirect()->route('index')->with('error', 'Error creating employee: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'birthday' => 'required|date',
                'monthly_salary' => 'required|numeric',
            ]);

            $employee = Employee::findOrFail($id);
            $employee->update($request->all());

            return redirect()->route('index')->with('success', 'Employee updated successfully!');
        } catch (Exception $e) {
            return redirect()->route('index')->with('error', 'Error updating employee: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return redirect()->route('index')->with('success', 'Employee deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('index')->with('error', 'Error deleting employee: ' . $e->getMessage());
        }
    }
}
