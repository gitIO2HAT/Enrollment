<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Message;

class DepartmentController extends Controller
{

    public function department(Request $request)
    {
        $notification['notify'] = DB::select("
        SELECT
            users.id,
            users.name,
            users.lastname,
            users.email,
            COUNT(messages.is_read) AS unread
        FROM
            users
        LEFT JOIN
            messages ON users.id = messages.send_to AND messages.is_read = 0
        WHERE
            users.id = " . Auth::id() . "
        GROUP BY
            users.id, users.name, users.lastname, users.email
    ");
        $search = $request->input('search');

        $departments = Department::query();
        if ($search) {
            $departments->where(function ($q) use ($search) {
                $q->whereRaw("CONCAT(name, ' ', id) LIKE ?", ["%$search%"]);
            });
        }

        $departments->where('deleted', '=', 1);

        $departments = $departments->paginate(10);

        $query = Message::getNotify();


        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.department.department'
            : (Auth::user()->user_type == 1
                ? 'admin.department.department'
                : 'employee.dashboard');


        return view($viewPath, [
            'notification' => $notification,
            'getNot' => $getNot,
            'departments' => $departments,
        ]);
    }


    public function departmentarchived()
    {
        $notification['notify'] = DB::select("
        SELECT
            users.id,
            users.name,
            users.lastname,
            users.email,
            COUNT(messages.is_read) AS unread
        FROM
            users
        LEFT JOIN
            messages ON users.id = messages.send_to AND messages.is_read = 0
        WHERE
            users.id = " . Auth::id() . "
        GROUP BY
            users.id, users.name, users.lastname, users.email
    ");

        $departments = Department::all();
        $query = Message::getNotify();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.department.departmentarchived'
            : (Auth::user()->user_type == 1
                ? 'admin.department.departmentarchived'
                : 'employee.message');


        return view($viewPath, [
            'notification' => $notification,
            'getNot' => $getNot,
            'departments' => $departments,
        ]);
    }


    public function getPositions($department_id)
    {
        $positions = Position::where('department_id', $department_id)->get();
        return response()->json($positions);
    }

    public function adddepartment(Request $request)
    {
        $department = new Department;

        $request->validate([
            'name' => 'string|max:50|unique:departments,name',
        ], [
            'name.unique' => 'This name has already been taken.',
        ]);

        $department->name = $request->name;
        $department->save();

        return redirect()->back()->with('success', 'Department successfully added');
    }
    public function updatedepartment($id, Request $request)
    {

        $department = Department::getId($id);
        $request->validate([
            'name' => 'required|string|max:50|unique:departments,name,' . $request->id,
        ],[
            'name.unique' => 'This name has already been taken.',
        ]);
    
        $department->name = $request->name;
        $department->save();
    
        return redirect()->back()->with('success', 'Department successfully updated');
    }
    

    public function addposition(Request $request)
    {

        $position = new Position;

        $request->validate([
            'name' => 'required|string|max:50|unique:positions,name',
            'department_id' => 'required|integer|exists:departments,id',
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'This name has already been taken.',
            'department_id.required' => 'The department field is required.',
            'department_id.exists' => 'The selected department is invalid.',
        ]);



        $position->name = $request->name;
        $position->department_id = $request->department_id;

        $position->save();

        return redirect()->back()->with('success', 'Position successfully added');
    }

    public function deleted($id)
    {
        $user = Department::getId($id);
        $user->deleted = 2;
        $user->save();

        return redirect()->back()->with('success', 'Department successfully DELETED');
    }
    public function deletedrestored($id)
    {
        $user = Department::getId($id);
        $user->deleted = 1;
        $user->save();

        return redirect()->back()->with('success', 'Department successfully RESTORED');
    }
}
