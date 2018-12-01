<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Year;
use App\Models\AcademicYear;
use Session;
use Auth;
use Image;
use Storage;
use Hash;

class TeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:teacher');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $id = Auth::user()->id;
        $teacherSections = [];
        $teacherSubjects = [];
        $x = 0;
        $countStudents = 0;
        $limitBox = 1;

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
                            'academic_year_start' => $find_ac->start,
                            'academic_year' => $find_ac->start.' - '.$find_ac->end,
                            'students' => $countStudents
                        ];

                        $countStudents = 0;

                    }


                }
        }

        

        $sectionsEncode = json_encode($teacherSections);

        $new_sections = json_decode($sectionsEncode);

        usort($new_sections, function($first,$second){ //sort sections by id (desc)
            return $first->section_id < $second->section_id;
        });

        return view('teachers.dashboard')
            ->with('sections', $new_sections)
            ->with('limitBox', $limitBox);
    }

    public function viewAccountSettings() {
        return view('teachers.account-settings');
    }

    public function updatePicture(Request $request)
    {
        $this->validate($request, [
            'profile_picture'          =>        'required|image'
        ]);

        $id = Auth::user()->id;
        $teacher = Teacher::find($id);

        //save image
            if($request->hasFile('profile_picture')){
                $image = $request->file('profile_picture');
                $filename = $id . '.' . time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('uploads/teacher/' . $filename);
                Image::make($image)->save($location);
                $oldImage = $teacher->image; //old imagename

                $teacher->image = $filename; 

                Storage::delete($oldImage); //delete old image
             
            }

        $teacher->save();

        Session::flash('picture-is-in', 'value');
        Session::flash('success', 'Your profile picture has been changed.');

        return redirect()->route('teacher.view.account');
    }

    public function updateInfo(Request $request)
    {
        
        $this->validate($request, [
            'email'            =>          'required|email'
        ]);


        $id = Auth::user()->id;
        $teacher = Teacher::find($id);

        $teacher->email = $request->email;

        $teacher->save();

        Session::flash('info-is-in','value');
        Session::flash('success', 'Email has been changed.');

        return redirect()->route('teacher.view.account');
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'old_password'         =>       'required',
            'new_password'     =>           'required|string|min:6|confirmed'          
        ]);

        if (Hash::check($request->old_password, Auth::user()->password)) {
            //if current password and new password are same
            if(strcmp($request->get('old_password'), $request->get('new_password')) == 0) {
                Session::flash('password-is-in', 'haha');
                Session::flash('error', 'New Password cannot be same as your current password. Please choose a different password.');
                return redirect()->route('teacher.view.account');
            }

            $teacher = Teacher::find($id);

            $teacher->password = bcrypt($request->new_password);

            $teacher->save();

            Session::flash('password-is-in', 'haha');
            Session::flash('success', 'Your password has been successfully changed.');
            return redirect()->route('teacher.view.account');

        }
        else {
            Session::flash('password-is-in', 'haha');
            Session::flash('error', 'The old password you provided did not match your current password.');
            return redirect()->route('teacher.view.account');
        }

    }
}
