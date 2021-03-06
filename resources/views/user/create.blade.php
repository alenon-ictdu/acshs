@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Content Manager<small>Add content manager.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('user.index') }}">Content Managers</a></li>
        <li class="active">Add</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <!-- Default box -->  
    <a href="{{ route('user.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all content managers</a><br><br>
    
    {{-- Show the errors, if any --}}
    @if ($errors->any())
        <div class="callout callout-danger">
            {{-- <h4>dsasdadsa</h4> --}}
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

      <form method="post" action="{{ route('user.store') }}" enctype="multipart/form-data">
      {!! csrf_field() !!}
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Add a new content manager</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

         <div class="form-group col-xs-12">
          <label>Name</label>
          <input type="text" name="name" class="form-control">
        </div>

        <div class="form-group col-xs-12">
          <label>Email</label>
          <input type="text" name="email" class="form-control">
        </div>

        </div><!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
        </div><!-- /.box-footer-->

      </div><!-- /.box -->
      </form>
  </div>
</div>

@endsection
