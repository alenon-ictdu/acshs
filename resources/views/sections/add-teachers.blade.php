@extends('backpack::layout')

@section('before_styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Add Teacher per Subject
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li class="active">Add Teacher per Subject</li>
      </ol>
    </section>
@endsection

@section('content')

@if(session('error'))
        <div class="alert alert-danger alert-dismissible fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ session('error') }}
        </div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="box-title"><h3><span class="small">Section: </span>{{ $section->name }}</h3>  </div>
            </div>

            <div class="box-body">
            	<form id="add-teacher-form" method="POST">
					{{ csrf_field() }}
		              <table class="table table-striped table-hover">
						<thead>
							<tr>
								<th style="width: 50%;">Subjects</th>
								<th style="width: 50%;">Teachers</th>
							</tr>		
						</thead>
						<tbody>
							
							@foreach($section->subjects as $subject)
							
								{{-- <input type="hidden" name="subject_id" value="{{ $subject->id }}" > --}}
								<tr>
									<td>{{ $subject->name }}</td>
									<td>
										<select class="form-control select2-multi" name="{{ $subject->id }}" required>
											<option value=""> Select a teacher </option>
											@foreach($teachers as $teacher)
											<option @if($subject->pivot->teacher_id == $teacher->id) selected @endif value="{{ $teacher->id }}">{{ $teacher->firstname }} {{ $teacher->middlename }} {{ $teacher->lastname }} </option>
											@endforeach
										</select>
									</td>
								</tr>
								 
							
							@endforeach
							
						</tbody>
					</table>
				</form>
            </div>
            <div class="box-body">
            	<button form="add-teacher-form" formaction="{{ route('section.teachers.update', $section->id) }}" class="btn btn-success pull-right"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('before_scripts')
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/select2.full.min.js') }}"></script>
	<script type="text/javascript">
		$('.select2-multi').select2();
	</script>
@endsection