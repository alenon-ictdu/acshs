<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Year;
use App\Models\AcademicYear;
use App\Models\Student;
use Auth;
use DB;
use App\Grade;
use Session;

class SectionController extends Controller
{
    public function __construct() {
        $this->middleware('auth:teacher');
    }

    public function viewSection() {
        $id = Auth::user()->id;
        $teacherSections = [];
        $teacherSubjects = [];
        $x = 0;
        $countStudents = 0;

        $sections = Section::all();

        foreach ($sections as $section) {

            $new_section = Section::find($section->id);

                foreach ($new_section->subjects as $subject) {

                    if ($subject->pivot->teacher_id == $id) {
                        $find_section = Section::find($subject->pivot->section_id);
                        $find_subject = Subject::find($subject->pivot->subject_id);
                        $find_yearLevel = Year::find($find_section->year_id);
                        $find_ac = AcademicYear::find($find_section->academic_year_id);

                        foreach ($find_section->students as $student) {
                            $countStudents += 1;
                        }

                        $teacherSections[$x++] = [
                            'section_id' => $subject->pivot->section_id,
                            'section_name' => $find_section->name,
                            'year_level_id' => $find_yearLevel->id,
                            'year_level_name' => $find_yearLevel->name,
                            'subject_id' => $subject->pivot->subject_id,
                            'subject_name' => $find_subject->name,
                            'academic_year_id' => $find_ac->id,
                            'academic_year' => $find_ac->start.' - '.$find_ac->end,
                            'students' => $countStudents
                        ];

                        $countStudents = 0;

                    }


                }
        }


        $sectionsEncode = json_encode($teacherSections);

        $new_sections = json_decode($sectionsEncode);

         /*foreach ($new_sections as $row) {
             echo "<br>";
             echo 'section id: '.$row->section_id;
             echo ', section: '.$row->section_name;
             echo ', year id: '.$row->year_level_id;
             echo ', year name: '.$row->year_level_name;
             echo ', subject id: '.$row->subject_id;
             echo ', subject name: '.$row->subject_name;
             echo ', academic year id: '.$row->academic_year_id;
             echo ', academic year name: '.$row->academic_year;
             echo ', students :'.$row->students;
         }*/

        

        return view('teachers.section')
            ->with('sections', $new_sections);
    }

    public function viewSectionStudents($section_id, $subject_id) {
        $section = Section::find($section_id);
        $grades = Grade::all();
        $subject = Subject::find($subject_id);
        return view('teachers.section-students')
            ->with('section', $section)
            ->with('subject_id', $subject_id)
            ->with('grades', $grades)
            ->with('subject', $subject);
    }

    public function updateGrade(Request $request, $section_id, $subject_id) {
        //echo($request);
        $teacher_id = Auth::user()->id;

        //dd($request);
        /*"_token" => "qNWdXckUdaY5fypd4l6dBYux0zqoSEqpZr0Y2Lsy"
      "student-table_length" => "10"*/

        $inputs = $request->all();
        //array_shift($inputs); //remove the token from request
        //array_shift($inputs); //remove the table_length from request
        //print_r($inputs);
        foreach ($inputs as $key => $value) {
            if ($key == '_token' || $key == 'student-table_length') {
               continue;
            }
            $student_id = $key;
            $student_grade = $value;

            $checkIfExist = Grade::where([
                ['teacher_id', '=', $teacher_id], 
                ['subject_id', '=', $subject_id],
                ['section_id', '=', $section_id],
                ['student_id', '=', $student_id]
            ]);

            if($checkIfExist->count() <= 0){ //if not exist add new
                if ($student_grade == null) {
                    continue;
                }else {
                    $grade = New Grade;
                    $grade->teacher_id = $teacher_id;
                    $grade->subject_id = $subject_id;
                    $grade->section_id = $section_id;
                    $grade->student_id = $student_id;
                    $grade->not_editable = 1;
                    $grade->grade = $student_grade;
                    $grade->save();
                }
                
            }
            else { //else update
                if($student_grade == null){
                    continue;
                }else{
                    /*$checkIfExist->grade = $student_grade;
                    $checkIfExist->not_editable = 1;
                    $checkIfExist->save();*/
                    $updateGrade = Grade::where([
                        ['teacher_id', '=', $teacher_id], 
                        ['subject_id', '=', $subject_id],
                        ['section_id', '=', $section_id],
                        ['student_id', '=', $student_id]
                    ])->first();
                    if ($updateGrade->not_editable == 1) { //check if the user edited the disabled input
                        continue;
                    }else {
                        $updateGrade->grade = $student_grade;
                        $updateGrade->not_editable = 1;
                        $updateGrade->save();
                    }
                }
               
            }
        }

        return redirect()->back();

    }

    public function exportCsv($section_id, $subject_id) {
        $section = Section::find($section_id);
        $grades = Grade::all();
        $subject = Subject::find($subject_id);
        $dataToDownload = [];
        $x = 0;
        $student_grade = 0;
        $csvName = Auth::user()->firstname.Auth::user()->lastname. ' - ' .$section->name. ' - ' .$subject->name. ' - ' .date("Y/m/d");

        // output headers so that the file is downloaded rather than displayed
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename='.$csvName.'.csv');
         
        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');
         
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');
         
        // send the column headers
        fputcsv($file, array('SubjectName', 'StudentID', 'Firstname', 'Middlename', 'Lastname', 'Gender', 'Birthday', 'Contact', 'Address', 'Grade'));
         
        foreach($section->students as $row) {
            foreach($grades as $grade){
                if($section->id == $grade->section_id && $row->id == $grade->student_id && $subject->id == $grade->subject_id && Auth::user()->id == $grade->teacher_id){
                    $student_grade = $grade->grade;
                    break;
                }else{
                    $student_grade = 0;
                }
            }
            $dataToDownload[$x++] = [
                'subject_name' => $subject->name,
                'student_id' => $row->s_id,
                'student_firstname' => $row->firstname,
                'student_middlename' => $row->middlename,
                'student_lastname' => $row->lastname,
                'student_gender' => $row->gender,
                'student_birthday' => $row->birthday,
                'student_contact' => $row->contact,
                'student_address' => $row->address1,
                'student_grade' => $student_grade == 0 ? ' ' : $student_grade
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

    public function importCsv($section_id, $subject_id) {
        $section = Section::find($section_id);
        $subject = Subject::find($subject_id);
        return view('teachers.importcsv')
            ->with('section', $section)
            ->with('subject', $subject);
    }

    public function submitCsv($section_id, $subject_id) {
        $fname = $_FILES['sel_file']['name'];
        //echo 'upload file name: ' .$fname;
        $chk_ext = explode(".", $fname);

        $skipFirstRow = true;

        if (strtolower(end($chk_ext)) == "csv") {
            $filename = $_FILES['sel_file']['tmp_name'];
            $handle = fopen($filename, "r");

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($skipFirstRow){
                    if( //checking the format
                        strtolower($data[0]) == 'subjectname' && 
                        strtolower($data[1]) == 'studentid' && 
                        strtolower($data[2]) == 'firstname' && 
                        strtolower($data[3]) == 'middlename' && 
                        strtolower($data[4]) == 'lastname' &&
                        strtolower($data[5]) == 'gender' &&
                        strtolower($data[6]) == 'birthday' &&
                        strtolower($data[7]) == 'contact' &&
                        strtolower($data[8]) == 'address' &&
                        strtolower($data[9]) == 'grade'
                    ) {
                        if($skipFirstRow){
                            $skipFirstRow = false;
                            continue;
                        }
                        /*$student = New Student;
                        $student->firstname = $data[0];
                        $student->middlename = $data[1];
                        $student->lastname = $data[2];
                        $student->gender = $data[3];
                        $student->birthday = $data[4];
                        $student->contact = $data[5];
                        $student->save();*/
                        $student_grade = $data[9];

                        $checkIfExist = Grade::where([
                        ['teacher_id', '=', Auth::user()->id], 
                        ['subject_id', '=', $subject_id],
                        ['section_id', '=', $section_id],
                        ['student_id', '=', $data[1] ]
                        ]);

                        if($checkIfExist->count() <= 0){ //if not exist add new
                            if ($student_grade == ' ') {
                                continue;
                            }else {
                                if($student_grade > 100){
                                    continue;
                                }
                                $grade = New Grade;
                                $grade->teacher_id = Auth::user()->id;
                                $grade->subject_id = $subject_id;
                                $grade->section_id = $section_id;
                                $grade->student_id = $data[1] ;
                                $grade->not_editable = 1;
                                $grade->grade = $student_grade;
                                $grade->save();
                            }
                            
                        }
                        else { //else update
                            if($student_grade == null){
                                continue;
                            }else{
                                /*$checkIfExist->grade = $student_grade;
                                $checkIfExist->not_editable = 1;
                                $checkIfExist->save();*/
                                $updateGrade = Grade::where([
                                    ['teacher_id', '=', Auth::user()->id], 
                                    ['subject_id', '=', $subject_id],
                                    ['section_id', '=', $section_id],
                                    ['student_id', '=', $data[1] ]
                                ])->first();
                                if ($updateGrade->not_editable == 1) { //check if the user edited the disabled input
                                    continue;
                                }else {
                                    $updateGrade->grade = $student_grade;
                                    $updateGrade->not_editable = 1;
                                    $updateGrade->save();
                                }
                            }
                           
                        }
                    } else {
                        Session::flash('error', 'Please follow the format');
                        return redirect()->back();
                    }
                } else {
                    $student_grade = $data[9];

                    $checkIfExist = Grade::where([
                    ['teacher_id', '=', Auth::user()->id], 
                    ['subject_id', '=', $subject_id],
                    ['section_id', '=', $section_id],
                    ['student_id', '=', $data[1] ]
                    ]);

                    if($checkIfExist->count() <= 0){ //if not exist add new
                        if ($student_grade == ' ') {
                            continue;
                        }else {
                            if($student_grade > 100){
                                continue;
                            }
                            $grade = New Grade;
                            $grade->teacher_id = Auth::user()->id;
                            $grade->subject_id = $subject_id;
                            $grade->section_id = $section_id;
                            $grade->student_id = $data[1] ;
                            $grade->not_editable = 1;
                            $grade->grade = $student_grade;
                            $grade->save();
                        }
                        
                    }
                    else { //else update
                        if($student_grade == null){
                            continue;
                        }else{
                            /*$checkIfExist->grade = $student_grade;
                            $checkIfExist->not_editable = 1;
                            $checkIfExist->save();*/
                            $updateGrade = Grade::where([
                                ['teacher_id', '=', Auth::user()->id], 
                                ['subject_id', '=', $subject_id],
                                ['section_id', '=', $section_id],
                                ['student_id', '=', $data[1] ]
                            ])->first();
                            if ($updateGrade->not_editable == 1) { //check if the user edited the disabled input
                                continue;
                            }else {
                                $updateGrade->grade = $student_grade;
                                $updateGrade->not_editable = 1;
                                $updateGrade->save();
                            }
                        }
                       
                    }
                }

            }

            fclose($handle);
            Session::flash('success', 'File uploaded successfully!');
            return redirect()->route('teacher.view.section.students', [$section_id, $subject_id]);
        }
        else {
            Session::flash('error', 'Invalid File!');
            return redirect()->back();
        }
    }


}
