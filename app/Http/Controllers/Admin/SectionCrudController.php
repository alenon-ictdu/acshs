<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SectionRequest as StoreRequest;
use App\Http\Requests\SectionRequest as UpdateRequest;
use App\Models\AcademicYear;
use App\Models\Year;
use App\Models\Student;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Session;

class SectionCrudController extends CrudController
{

    public function setup()
    {
        $students = Student::all();

        $schoolYearsArr = [];
        $schoolYears = AcademicYear::all();
        foreach ($schoolYears as $row) {
            $schoolYearsArr[$row->id] = $row->start.' - '.$row->end;
        }

        $YearsArr = [];
        $Years = Year::all();
        foreach ($Years as $row) {
            $YearsArr[$row->id] = $row->name;
        }

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Section');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/section');
        $this->crud->setEntityNameStrings('section', 'sections');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */


        $this->crud->setFromDb();

        // ------ CRUD FIELDS
        $this->crud->addField(
        [   // Select2Multiple = n-n relationship (with pivot table)
            'label' => "Subjects",
            'type' => 'select2_multiple',
            'name' => 'subjects', // the method that defines the relationship in your Model
            'entity' => 'subjects', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Subject", // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);

        $this->crud->addField(
        [   // Select2Multiple = n-n relationship (with pivot table)
            'label' => "Students",
            'type' => 'select2_multiple',
            'name' => 'students', // the method that defines the relationship in your Model
            'entity' => 'students', // the method that defines the relationship in your Model
            'attribute' => 'full_name', // foreign key attribute that is shown to user
            'model' => "App\Models\Student", // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);
        /*$this->crud->addField([   // Select2
            'label' => "Year Level",
            'type' => 'select2',
            'name' => 'year_id', // the db column for the foreign key
            'entity' => 'years', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Year" // foreign key model
        ]);*/

        $this->crud->addField([   // select_from_array
            'name' => 'year_id',
            'label' => "Year Level",
            'type' => 'select2_from_array',
            'options' => $YearsArr,
            'allows_null' => false,
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // select_from_array
            'name' => 'academic_year_id',
            'label' => "School Year",
            'type' => 'select2_from_array',
            'options' => $schoolYearsArr,
            'allows_null' => false,
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        $this->crud->addColumns(['school_year', 'level', 'name']);
        $this->crud->removeColumns(['year_id', 'academic_year_id']);
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        $this->crud->addButtonFromModelFunction('line', 'add_teachers', 'addTeachers', 'beginning');
        $this->crud->addButtonFromModelFunction('line', 'view_students', 'viewStudents', 'beginning');
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
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
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function addTeachers($id) {
        $section = Section::find($id);
        $teachers = Teacher::all();
        return view('sections.add-teachers')
            ->with('section', $section)
            ->with('teachers', $teachers);
    }

    public function addTeacherOnSubject(Request $request, $id) {
        print_r($request->all());

        $section_id = $id;

        $inputs = $request->all();
        foreach ($inputs as $key => $value) {

            $section = Section::find($section_id);

            if ($key == '_token') {
                continue;
            }

            if($value == '') {
                $section->subjects()->updateExistingPivot($key, ['teacher_id' => null]);
            }else {
                $section->subjects()->updateExistingPivot($key, ['teacher_id' => $value]);
            }

        }

        return redirect()->back();
    }

    public function viewStudents($id) {
        $section = Section::find($id);
        $students = Student::all();
        return view('sections.view-students')
            ->with('section', $section)
            ->with('students', $students);
    }



}
