@extends('backpack::layout')

@section('before_styles')
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Sections <small> View section students</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection

@section('content')

<div class="panel panel-default">
  <div class="panel-heading"><h3>{{ $section->name }}</h3></div>
  <div class="panel-body">
  	<table id="student-table" class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Student id</th>
				<th>Firstname</th>
				<th>Middlename</th>
				<th>Lastname</th>
				<th>Gender</th>
				<th>Birthday</th>
				<th>Contact</th>
				<th>Address</th>
			</tr>		
		</thead>
		<tbody>
			@foreach($section->students as $student)
				<tr>
					<td>{{ $student->id }}</td>
					<td>{{ $student->firstname }}</td>
					<td>{{ $student->middlename }}</td>
					<td>{{ $student->lastname }}</td>
					<td>{{ $student->gender}}</td>
					<td>{{ $student->birthday }}</td>
					<td>{{ $student->contact }}</td>
					<td>{{ $student->address }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
  </div>
</div>

@endsection


@section('after_scripts')
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
    $('#student-table').DataTable();
    } );
  </script>
@endsection