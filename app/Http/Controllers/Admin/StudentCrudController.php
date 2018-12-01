<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\StudentRequest as StoreRequest;
use App\Http\Requests\StudentRequest as UpdateRequest;
use App\Models\Student;

class StudentCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Student');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/student');
        $this->crud->setEntityNameStrings('student', 'students');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->setFromDb();

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'gender',
            'label' => "Gender",
            'type' => 'select_from_array',
            'options' => ['Male' => 'Male', 'Female' => 'Female', 'Others' => 'Others'],
            'allow_null' => false,
        ]);
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        $this->crud->removeField('s_id', 'both');
        $this->crud->removeField('email', 'both');
        $this->crud->removeField('password', 'both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        $this->crud->removeColumns(['id', 'address2']);
        /*$this->crud->addColumn([
            'name' => 'student_id',
            'label' => 'Student ID'
        ])->beforeColumn('firstname');*/
        /*$this->crud->addColumn([
            'name' => 'id',
            'label' => 'Student ID'
        ])->beforeColumn('firstname'); */
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        $this->crud->addButtonFromModelFunction('top', 'open_google', 'downloadStudents', 'end'); // add a button whose HTML is returned by a method in the CRUD model
        $this->crud->addButtonFromView('line', 'btnReset', 'resetStudent', 'end');
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
        $this->crud->allowAccess(['list', 'create', 'update', 'delete', 'reset_student']);
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        $this->crud->orderBy('created_at', 'desc');
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function index() {
        // under maintenance
        return view('maintenance');
    }

    public function create()
    {
        // under maintenance
        return view('maintenance');
    }

    public function edit($id)
    {
        // under maintenance
        return view('maintenance');
    }

    public function store(StoreRequest $request)
    {
        $email = strtolower($request->firstname. '_' .$request->lastname. '@example.com');
        $students = Student::all();
        $yearNow = date('y');
        $lrn = '';
        $currentID = 1;
        if ($students->count() == 0) {
            $lrn = '01'. $yearNow. '000'. $currentID;
        } else {
            $lastStudent = Student::orderBy('created_at', 'desc')->first();
            $lastID = substr($lastStudent->s_id, 7) + 1;
            $lrn = '01'. $yearNow. '000'. $lastID;
        }

        // echo $lrn;


        $en_password = bcrypt($lrn);
        $request->offsetSet('s_id', $lrn);
        $request->offsetSet('email', $email);
        $request->offsetSet('password', $en_password);
        

        // dd($request);
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        /*$en_password = bcrypt($request->password);
        $request->offsetSet('password', $en_password);*/
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function studentResetPassword($id) {
        $student = Student::find($id);
        $student->password = bcrypt('abcd123456');
        $student->save();

        // show a success message
        \Alert::success('Student ID: '.$student->s_id.' has been reset')->flash();
        return redirect()->back();
    }

    public function downloadStudents() {
        $dataToDownload = [];
        $x = 0;
        $students = Student::all();

        $csvName = 'Students' .date("Y/m/d");

        // output headers so that the file is downloaded rather than displayed
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename='.$csvName.'.csv');
         
        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');
         
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');
         
        // send the column headers
        fputcsv($file, array('StudentID', 'Firstname', 'Middlename', 'Lastname', 'Gender', 'Birthday', 'Contact', 'Address', 'Barangay', 'Municipality', 'Province', 'Father', 'Mother'));
        foreach ($students as $row) {
            $dataToDownload[$x++] = [
                'student_id' => $row->s_id,
                'student_firstname' => $row->firstname,
                'student_middlename' => $row->middlename,
                'student_lastname' => $row->lastname,
                'student_gender' => $row->gender,
                'student_birthday' => $row->birthday,
                'student_contact' => $row->contact,
                'student_address' => $row->address1,
                'student_barangay' => $row->barangay,
                'student_municipality' => $row->municipality,
                'student_province' => $row->province,
                'student_father' => $row->father,
                'student_mother' => $row->mother
            ];
        }
    
         
        //print_r($dataToDownload);
        // output each row of the data
        foreach ($dataToDownload as $row)
        {
        fputcsv($file, $row);
        }
         
        exit();
    }
}
