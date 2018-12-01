@extends('student-layout')

@section('after_styles')
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Section: {{ $section->name }}
      </h1>
      <p>Year: {{ $yearLevel }}</p>
      <p>School Year: {{ $ac_name }}</p>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <!-- <div class="box-header with-border">
                    <div class="box-title">Something here...</div>
                </div> -->

                <div class="box-body">
                  <table id="section-table" class="table table-stripped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Subject</th>
                        <th>Grade</th>
                        <th>Teacher</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($grades as $row)
                      <tr>
                        <td>{{ $row->subject_name }}</td>
                        <td>{{ $row->student_grade }}</td>
                        <td>{{ $row->teacher_name }}</td>
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