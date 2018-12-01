<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\AcademicYear;
use App\Models\Section;
use App\Models\Year;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Announcement;
use App\Message;


class AdminDashboardController extends CrudController
{
	/*public function __construct()
    {
        $this->middleware(backpack_middleware());
    }
*/
    public function dashboard()
    {
        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title
        $students = Student::all();
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $sections = Section::all();
        $latest_news = Announcement::orderBy('created_at', 'desc')->first();
        $academicyears = AcademicYear::orderBy('start', 'asc')->get();
        $messages = Message::orderBy('created_at', 'desc')->paginate(5);

        return view('admin-dashboard.dashboard', $this->data)
            ->with('students', $students)
            ->with('teachers', $teachers)
            ->with('subjects', $subjects)
            ->with('sections', $sections)
            ->with('ay', $academicyears)
            ->with('latest_news', $latest_news)
            ->with('messages', $messages);
    }

    public function viewAcademicYearSection($id) {
    	$ay = AcademicYear::find($id);
    	$sections = Section::all();
    	$years = Year::all();

    	return view('admin-dashboard.academicyear-sections')
    		->with('ay', $ay)
    		->with('sections', $sections)
    		->with('years', $years);
    }

    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect()->route('admin.dashboard');
    }
}
