<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Grade;
use App\Models\Section;
use Auth;
use App\SectionStudent;
use App\SectionSubject;
use App\Models\Year;
use App\Models\AcademicYear;
use App\Models\Teacher;
use App\Models\Subject;
use Session;

class GradeController extends Controller
{
    public function __construct() {
    	$this->middleware('auth:student');
    }

    public function studentSections() {
    	$sectionArr = [];
    	$sectionArr2 = [];
    	$x = 0;
    	//$grades = Grade::all();


    	//finding the sections of a student
    	$studentSections = SectionStudent::all();
    	foreach ($studentSections as $row) {

    		if ($row->student_id == Auth::user()->s_id) {
    			if (!in_array($row->section_id, $sectionArr)) { 
    				$sectionArr[] = $row->section_id;
    			}
    		}

    	}


    	foreach ($sectionArr as $key => $value) {
    		$section = Section::find($value);
    		$year = Year::find($section->year_id);
    		$ac = AcademicYear::find($section->academic_year_id);
    		$sectionArr2[$x++] = [
    			'section_id' => $value,
    			'section_name' => $section->name,
    			'year_id' => $year->id,
    			'year_name' => $year->name,
    			'ac_id' => $ac->id,
    			'ac_name' => $ac->start. ' - ' .$ac->end
    		]; 
    	}

    	$section_encoded = json_encode($sectionArr2);
    	$section_decoded = json_decode($section_encoded);
    	
    	return view('students.sections')
    		->with('student_section', $section_decoded);

    	

    }

    public function studentGrades($id) {
        $studentGrades = [];
        $student_id = Auth::user()->id;
        $section_id = $id;
        $x = 0;
        $section = Section::find($section_id);
        $year = Year::find($section->year_id);
        $yearLevel = $year->name;
        $ac = AcademicYear::find($section->academic_year_id);
        $ac_name = $ac->start .' - '. $ac->end;


        $sectionSubject = SectionSubject::all();
        $grades = Grade::all();
        foreach ($sectionSubject as $row) {
            if($row->teacher_id == null || $row->teacher_id == '') {
                
                Session::flash('error', 'The section doesnt have a teacher yet. Please contact the administrator');
                return redirect()->back();
            } else {
                if ($row->section_id == $section_id) {
                    $subject = Subject::find($row->subject_id);
                    $teacher = Teacher::find($row->teacher_id);

                    $g = Grade::where([
                            ['teacher_id', '=', $teacher->id], 
                            ['subject_id', '=', $subject->id],
                            ['section_id', '=', $section_id],
                            ['student_id', '=', $student_id]
                    ])->first();

                    $studentGrades[$x++] = [
                        'subject_id' => $subject->id,
                        'subject_name' => $subject->name,
                        'teacher_id' => $teacher->id,
                        'teacher_name' => $teacher->firstname. ' ' .$teacher->middlename. ' ' .$teacher->lastname,
                        'student_grade' => $g['grade'] ?? ' '
                    ];
                }
            }
        }

        $grade_encoded = json_encode($studentGrades);
        $grade_decoded = json_decode($grade_encoded);

        return view('students.grades')
            ->with('grades', $grade_decoded)
            ->with('section', $section)
            ->with('yearLevel', $yearLevel)
            ->with('ac_name', $ac_name);
    }


}
