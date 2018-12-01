<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Student extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'students';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['s_id', 'firstname', 'middlename', 'lastname', 'gender', 'birthday', 'contact', 'religion', 'address1', 'address2', 'barangay', 'municipality', 'province', 'father', 'mother', 'email', 'password'];
    // protected $hidden = [];
    protected $hidden = ['password', 'remember_token'];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function downloadStudents($crud = false)
    {
        return '<a class="btn btn-default" target="_blank" href="/admin/download-students" data-toggle="tooltip" title="Download Students"><i class="fa fa-download"></i> Download Students</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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
    public function getFullNameAttribute($value) {
        return $this->s_id. ' - ' .$this->firstname. ' ' .$this->middlename. ' ' .$this->lastname;
    }

    public function getStudentIdAttribute($value) {
        return $this->s_id;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
