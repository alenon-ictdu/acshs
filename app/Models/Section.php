<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;


class Section extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'sections';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'year_id', 'academic_year_id', 'full_name'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function addTeachers($crud = false)
    {
        return '<a class="btn btn-xs btn-default" target="_blank" href="section/'.$this->id.'/addteachers" data-toggle="tooltip" title="Add Teacher per subject"><i class="fa fa-plus"></i> Add Teachers</a>';
    }

    public function viewStudents($crud = false)
    {
        return '<a class="btn btn-xs btn-default" target="_blank" href="section/'.$this->id.'/students" data-toggle="tooltip" title="View Section Students"><i class="fa fa-eye"></i> View Students</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function years() {
        return $this->hasMany('App\Models\Year');
    }

    public function academic_years() {
        return $this->hasMany('App\Models\AcademicYear');
    }

    public function subjects() {
        return $this->belongsToMany('App\Models\Subject')->withPivot('teacher_id');
    }

    public function students() {
        return $this->belongsToMany('App\Models\Student');
    }

    public function teachers() {
        return $this->belongsToMany('App\Models\Teacher');
    }

    public function grades() {
        return $this->hasMany('App\Grade');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getLevelAttribute(){
        $level_id = Year::find($this->year_id);
        return $level_id->name;
    }

    public function getSchoolYearAttribute(){
        $school_year_id = AcademicYear::find($this->academic_year_id);
        return $school_year_id->start. ' - ' .$school_year_id->end;
    }

    /*public function getFullNameAttribute() {
        $student = Student::find($this->student_id);
        return $student->lastname;
    }*/





    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
