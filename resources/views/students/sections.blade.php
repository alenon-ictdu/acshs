@extends('student-layout')

@section('after_styles')
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Sections<small> Choose a section</small>
      </h1>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('error') }}
              </div>
            @endif
            <div class="box box-default">
                <!-- <div class="box-header with-border">
                    <div class="box-title">Something here...</div>
                </div> -->

                <div class="box-body">
                  <table id="section-table" class="table table-stripped table-hover">
                    <thead>
                      <tr>
                        <th>Section</th>
                        <th>Level</th>
                        <th>School Year</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($student_section as $row)
                      <tr>
                        <td>{{ $row->section_name }}</td>
                        <td>{{ $row->year_name }}</td>
                        <td>{{ $row->ac_name }}</td>
                        <td><a href="{{ route('student.grades', $row->section_id) }}" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> View Grades</a></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_scripts')
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
    $('#section-table').DataTable();
    } );
  </script>
@endsection