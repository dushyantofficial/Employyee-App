<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.index');
    }

    public function get_employee(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Employee::query();

        if ($startDate && $endDate) {
            $query->whereBetween('joining_date', [$startDate, $endDate]);
        }

        $employees = $query->get();

        $data = [];

        foreach ($employees as $key => $employee) {
            $editUrl = route('employee-edit', $employee->id);
            $deleteUrl = url('delete_employee', $employee->id);

            $data[] = [
                'id' => $employee->id,
                'employee_code' => $employee->employee_code,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'joining_date' => $employee->joining_date,
                'profile_image' => '<img src="' . asset('storage/images/' . $employee->profile_image) . '" width="100px"/>',
                'action' => '<a href="' . $editUrl . '" class="btn btn-info"><i class="fas fa-edit"></i></a> ' .
                    '<a href="' . $deleteUrl . '" class="btn btn-danger" ' .
                    'onclick="return confirm(\'Are you sure you want to delete this record?\')"><i class="fas fa-trash-alt"></i></a>',
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(Request $request)
    {

        // Validate the request data
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'joining_date' => 'required|date|after:today',
            'profile_image' => 'required|image|max:2048', // Max 2MB
        ]);

        // Generate employee code (you can implement your own logic)
        $employeeCode = 'EMP-' . str_pad(rand(99, 00) + 1, 4, '0', STR_PAD_LEFT);

        // Store the employee data
        $input = $request->all();
        $input['employee_code'] = $employeeCode;
        if ($request->hasFile("profile_image")) {
            $img = $request->file("profile_image");
            $img->store('public/images');
            $input['profile_image'] = $img->hashName();
        }

        Employee::create($input);

        return redirect()->back()->with('success', 'Employee added successfully!');
    }

    public function edit($id)
    {
        $employee_edits = Employee::find($id);
        return view('employee.edit', compact('employee_edits'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'joining_date' => 'required|date|after:today',
            'profile_image' => 'image|max:2048', // Max 2MB
        ]);
        $employee_edits = Employee::find($id);
        $input = $request->all();
        if ($request->hasFile("profile_image")) {
            $img = $request->file("profile_image");
            if (Storage::exists('public/images' . $employee_edits->profile_image)) {
                Storage::delete('public/images' . $employee_edits->profile_image);
            }
            $img->store('public/images');
            $input['profile_image'] = $img->hashName();
            $employee_edits->update($input);
        }
        $employee_edits->update($input);
        return redirect()->back()->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        $employee_delete = Employee::find($id);
        $employee_delete->delete();
        return redirect()->back()->with('danger', 'Employee delete successfully!');
    }

}
