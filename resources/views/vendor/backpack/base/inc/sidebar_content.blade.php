<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
{{-- for content managers --}}
@if(Auth::user()->user_type == 2)
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li><a href="{{backpack_url('announcement') }}"><i class="fa fa-bullhorn"></i> <span>Announcements</span></a></li>
<li><a href="{{ route('message.index') }}"><i class="fa fa-inbox"></i> <span>Inbox</span></a></li>

<li class="treeview">
            <a href="#"><i class="fa fa-newspaper-o"></i> <span>Content Management</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ route('logo.index') }}"><i class="fa fa-file-o"></i> <span>Logo</span></a></li>
              <li><a href="{{ route('schoolname.index') }}"><i class="fa fa-file-o"></i> <span>School Name</span></a></li>
              <li><a href="{{ route('carousel.index') }}"><i class="fa fa-file-o"></i> <span>Carousel</span></a></li>
              <li><a href="{{ route('about.index') }}"><i class="fa fa-file-o"></i> <span>About</span></a></li>
              <li><a href="{{backpack_url('facility') }}"><i class="fa fa-file-o"></i> <span>Facilities</span></a></li>
              <li><a href="{{backpack_url('administration') }}"><i class="fa fa-file-o"></i> <span>Administration</span></a></li>
              <li><a href="{{ route('album.index') }}"><i class="fa fa-file-o"></i> <span>Album</span></a></li>

            </ul>
          </li>
</li>{{-- for content managers --}}

@else

<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li><a href="{{backpack_url('announcement') }}"><i class="fa fa-bullhorn"></i> <span>Announcements</span></a></li>
<li><a href="{{ route('message.index') }}"><i class="fa fa-inbox"></i> <span>Inbox</span></a></li>

<li class="treeview">
            <a href="#"><i class="fa fa-newspaper-o"></i> <span>Content Management</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ route('logo.index') }}"><i class="fa fa-file-o"></i> <span>Logo</span></a></li>
              <li><a href="{{ route('schoolname.index') }}"><i class="fa fa-file-o"></i> <span>School Name</span></a></li>
              <li><a href="{{ route('carousel.index') }}"><i class="fa fa-file-o"></i> <span>Carousel</span></a></li>
              <li><a href="{{ route('about.index') }}"><i class="fa fa-file-o"></i> <span>About</span></a></li>
              <li><a href="{{backpack_url('facility') }}"><i class="fa fa-file-o"></i> <span>Facilities</span></a></li>
              <li><a href="{{backpack_url('administration') }}"><i class="fa fa-file-o"></i> <span>Administration</span></a></li>
              <li><a href="{{ route('album.index') }}"><i class="fa fa-file-o"></i> <span>Album</span></a></li>

            </ul>
          </li>
</li>

<li class="treeview">
            <a href="#"><i class="fa fa-newspaper-o"></i> <span>Grade Management <i style="margin-left: 5px; color: orange;" class="fa fa-exclamation-triangle"></i> </span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ route('crud.academicyear.index') }}"><i class="fa fa-list"></i> <span>Academic Years</span></a></li>
              <li><a href="{{ route('crud.year.index') }}"><i class="fa fa-list"></i> <span> Year Levels</span></a></li>
              <li><a href="{{ route('crud.subject.index') }}"><i class="fa fa-book"></i> <span>Subjects</span></a></li>        
              <li><a href="{{ route('crud.teacher.index') }}"><i class="fa fa-user"></i> <span>Teachers</span></a></li>
              <li><a href="{{ route('crud.student.index') }}"><i class="fa fa-user"></i> <span>Students</span></a></li>
              <li><a href="{{ route('crud.section.index') }}"><i class="fa fa-newspaper-o"></i> <span>Sections</span></a></li>
            </ul>
          </li>
</li> 

<li><a href="{{ route('user.index') }}"><i class="fa fa-users"></i> <span>Content Managers</span></a></li>
<li><a href="{{ route('log.index') }}"><i class="fa fa-history"></i> <span>Logs</span></a></li>

@endif

