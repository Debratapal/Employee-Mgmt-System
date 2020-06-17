<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Excel;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
         $employees = DB::table('employees')
        ->select('employees.*', 'empid as emp_id', 'empname as emp_name', 'mobnumber as mob_number', 'email as email', 'birthdate as birthdate', 'picture as picture')->get();
        return view('system-mgmt/report/index',['employees' => $employees]);
    }

    public function exportExcel(Request $request) {
        $this->prepareExportingData($request)->export('xlsx');
        redirect()->intended('system-management/report');
    }

    public function exportPDF(Request $request) {
         $constraints = [
            'from' => $request['from'],
            'to' => $request['to']
        ];
        $employees = $this->getExportingData($constraints);
        $pdf = PDF::loadView('system-mgmt/report/pdf', ['employees' => $employees, 'searchingVals' => $constraints]);
        return $pdf->download('report_from_'. $request['from'].'_to_'.$request['to'].'pdf');
        // return view('system-mgmt/report/pdf', ['employees' => $employees, 'searchingVals' => $constraints]);
    }
    
    private function prepareExportingData($request) {
        $author = Auth::user()->username;
        $employees = $this->getExportingData(['from'=> $request['from'], 'to' => $request['to']]);
        return Excel::create('report_from_'. $request['from'].'_to_'.$request['to'], function($excel) use($employees, $request, $author) {

        // Set the title
        $excel->setTitle('List of employees from '. $request['from'].' to '. $request['to']);

        // Chain the setters
        $excel->setCreator($author)
            ->setCompany('HoaDang');

        // Call them separately
        $excel->setDescription('The list of employees');

        $excel->sheet('Employees', function($sheet) use($employees) {

        $sheet->fromArray($employees);
            });
        });
    }

    public function search(Request $request) {
        $constraints = [
            'from' => $request['from'],
            'to' => $request['to']
        ];

        $employees = $this->getHiredEmployees($constraints);
        return view('system-mgmt/report/index', ['employees' => $employees, 'searchingVals' => $constraints]);
    }

    private function getHiredEmployees($constraints) {
        $employees = DB::table('employees')
        ->select('employees.*', 'empid as emp_id', 'empname as emp_name', 'mobnumber as mob_number', 'email as email', 'birthdate as birthdate', 'picture as picture')->get();
        return $employees;
    }

    private function getExportingData($constraints) {
        return DB::table('employees')
        ->select('employees.*', 'empid as emp_id', 'empname as emp_name', 'mobnumber as mob_number', 'email as email', 'birthdate as birthdate', 'picture as picture')->get()
        ->map(function ($item, $key) {
        return (array) $item;
        })
        ->all();
    }
}
