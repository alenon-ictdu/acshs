@extends('teacher-layout')

@section('after_styles')

  <link rel="stylesheet" type="text/css" href="{{ asset('css/teacherdashboard.css') }}">

@endsection

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>Teacher dashboard</small>
      </h1>
      
    </section>
@endsection


@section('content')
    <div class="row">
        @foreach($sections as $section)
        
         
            <a href="{{ route('teacher.view.section.students', [$section->section_id, $section->subject_id]) }}">
                <div class="col-md-3">
                  <div class="box box-default">
                      <div class="box-header with-border" >
                        <div class="box-content">
                          <div class="box-title"><h1>{{ $section->section_name }}</h1><p>{{ $section->subject_name }}</p></div>
                          <div class="box-icon"><i class="fa fa-list"></i></div>
                        </div>
                      </div>
          
                      <div class="box-body">{{ $section->academic_year }}<span class="box-view pull-right"><i class="fa fa-eye"></i> View</span></div>
                  </div>
                </div>
            </a>
          
          @if($limitBox >= 4)
            <?php break; ?>
          @endif
          
          <?php $limitBox++ ?>
        @endforeach
        
    </div>
@endsection