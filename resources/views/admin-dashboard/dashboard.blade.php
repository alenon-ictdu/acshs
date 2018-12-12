@extends('backpack::layout')

@section('after_styles')

  <link rel="stylesheet" type="text/css" href="{{ asset('css/admindashboard.css') }}">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
  <style>
    .panel-success>.panel-heading {
        color: #ffffff;
        background-color: #00a65a;
        border-color: #000000;
    }
    .panel-heading a:after {
        font-family:'Glyphicons Halflings';
        content:"\e114";
        float: right;
        color: white;
    }
    .panel-heading a.collapsed:after {
        content:"\e080";
    }

    .style-1::-webkit-scrollbar-track
    {
      /*-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);*/
      border-radius: 10px;
      background-color: #F5F5F5;
    }

    .style-1::-webkit-scrollbar
    {
      width: 12px;
      background-color: #F5F5F5;
    }

    .style-1::-webkit-scrollbar-thumb
    {
      border-radius: 10px;
      /*-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);*/
      background-color: #989a9c;
    }
  </style>

@endsection

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>Admin dashboard</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection


@section('content')

      {{-- <div class="container"> --}}
        <div class="row">
          {{-- <h1 class="text-center">SORRY THIS PAGE IS UNDER MAINTENANCE</h1> --}}
          
          {{-- for admin --}}
          @if(Auth::user()->user_type == 1)
          <div class="col-xs-4">
            <div class="panel-group">
              <div class="panel-group" id="accordion">
                <div class="panel panel-success" id="panel1">
                  <div class="panel-heading" style="height: 200px; padding-top: 30px;">
                    <div>
                      <p style="display: inline; font-size: 100px;"><i class="fa fa-users"></i></p>
                      <p style="display: inline; font-size: 20px;">Online Content Manager</p>
                      <p style="display: inline; font-size: 25px; position: absolute; right: 50px; top: 115px;">{{ $onlineUsers->count() - 1 }}</p>
                    </div>
                  </div>
                  <div class="panel-heading" style="border-top-left-radius: 0px;border-top-right-radius: 0px;">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-target="#collapseOne" href="#collapseOne" class="collapsed">
                        View 
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse" >
                      <div class="panel-body style-1" style="height: 300px; overflow: scroll;">
                        <table class="table table-striped">
                          <tbody>
                            @foreach($onlineUsers as $row)
                            @if($row->user_type == 2)
                            <tr>
                              <td style="width: 10px;"><i class="fa fa-user"></i></td>
                              <td>{{ $row->name }}</td>
                            </tr>
                            @endif
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif

      </div>
    {{-- </div> --}}
@endsection

@section('after_scripts')
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
    $('#ay-table').DataTable();
    } );
  </script>
@endsection
