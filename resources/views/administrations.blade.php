<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@if(!$schoolnameEmpty) {{ $publicSchoolname->name }} @else SPCFPartners @endif</title>
    <link rel="shortcut icon" href="@if(!$logoEmpty) {{ asset('img/logo/'. $publicLogo->image) }} @endif">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/agency.css" rel="stylesheet">

    <style>
      @media only screen and (max-width: 600px) {
          #aboutIcon {
              display: none;
          }
      }
    </style>

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="{{ route('landing') }}"><img width="50" @if(!$logoEmpty) src="{{ asset('img/logo/'. $publicLogo->image) }}"  @endif>@if(!$schoolnameEmpty) {{ $publicSchoolname->abbreviation }} @endif</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav text-uppercase ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#facilities">Facilities</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#news">Announcements</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#admin">Administration</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="{{ route('student.login') }}">StudentLogin</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="{{ route('teacher.login') }}">TeacherLogin</a>
            </li> -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Login
              </a>
              <div class="dropdown-menu" style="font-family: Montserrat,'Helvetica Neue',Helvetica,Arial,sans-serif;">
                <a class="dropdown-item" href="{{ route('student.login') }}">As Student</a>
                <a class="dropdown-item" href="{{ route('teacher.login') }}">As Teacher</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    

    <!-- Administration -->
    @if(!$administrations->count() == 0)
    <section class="bg-light" id="admin">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading text-uppercase">Meet the Administration</h2>
           <!-- <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3> -->
          </div>
        </div>

        <div class="row">
          @if($administrations->count() == 1)
            @foreach($administrations as $admins)
            <div class="col-sm-4 offset-md-4">
              <div class="team-member">
                <img class="mx-auto rounded-circle" src="uploads/{{ $admins->image }}" alt="">
                <h4>{{ $admins->name }}</h4>
                <p class="text-muted">{{ $admins->position }}</p>
              </div>
            </div>
            @endforeach
          @endif

          @if($administrations->count() == 2)
            <?php $administraionCounter = 1; ?>
            @foreach($administrations as $admins)
            <div class="col-sm-4 @if($administraionCounter == 1) offset-md-2 @endif">
              <div class="team-member">
                <img class="mx-auto rounded-circle" src="uploads/{{ $admins->image }}" alt="">
                <h4>{{ $admins->name }}</h4>
                <p class="text-muted">{{ $admins->position }}</p>
              </div>
            </div>
            <?php $administraionCounter++; ?>
            @endforeach
          @endif

          @if($administrations->count() >= 3)
            @foreach($administrations as $admins)
            <div class="col-sm-4">
              <div class="team-member">
                <img class="mx-auto rounded-circle" src="uploads/{{ $admins->image }}" alt="">
                <h4>{{ $admins->name }}</h4>
                <p class="text-muted">{{ $admins->position }}</p>
              </div>
            </div>
            @endforeach
          @endif
        </div>
              
    </section>
    @endif

    <!-- Clients -->
    <section class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-6">
            <a href="#">
              <img class="img-fluid d-block mx-auto" src="img/spcf.png" alt="">
            </a>
          </div>

          <div class="col-md-3 col-sm-6">
            <a href="#">
              <img class="img-fluid d-block mx-auto" src="img/ccis.png" alt="">
            </a>
          </div>
          
          <div class="col-md-3 col-sm-6">
            <a href="#">
              <img class="img-fluid d-block mx-auto" src="img/ictdu.png" alt="">
            </a>
          </div>
          
          <div class="col-md-3 col-sm-6">
            <a href="#">
              <img class="img-fluid d-block mx-auto" src="img/tiger.png" alt="">
            </a>
          </div>
        </div>
      </div>
    </section>

        <!-- Contact -->
    <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading text-uppercase">Contact Us</h2>
            <!-- <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3> -->
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            
            @if (Session::has('success'))
              <div class="alert alert-success" role="alert">
                <strong>Success:</strong> {{ Session::get('success') }}
              </div>
            @endif

            <div class="row">
              <div class="col-7">
                <form method="POST" action="{{ route('message.store') }}">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input class="form-control" name="name" type="text" placeholder="Your Name *" required="required" data-validation-required-message="Please enter your name.">
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="Your Email *" required="required" data-validation-required-message="Please enter your email address.">
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="tel" name="contact" placeholder="Your Phone *" required="required" data-validation-required-message="Please enter your phone number.">
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <textarea class="form-control" name="message" placeholder="Your Message *" required="required" data-validation-required-message="Please enter a message."></textarea>
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-12 text-center">
                  <div id="success"></div>
                  <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Send Message</button>
                </div>
              </div>
            </form>
              </div>
              <div class="col">
                {{-- google map --}}
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1144.970448337502!2d120.60442560605601!3d15.14701734719918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396f216e31b14b1%3A0xa82e585aa0070cf2!2sAngeles+City+Senior+High+School!5e0!3m2!1sen!2sph!4v1543049861214" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
              </div>
            </div>

            
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <span class="copyright">Powered by <a href="https://www.spcf.edu.ph/">Systems Plus College Foundation</a></span>
          </div>
          <div class="col-md-4">
            <!-- <ul class="list-inline social-buttons">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-twitter"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-facebook"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-linkedin"></i>
                </a>
              </li>
            </ul> -->
          </div>
          @if(!$aboutEmpty)
          <div class="col-md-4">
            <ul class="list-inline quicklinks">
              <li class="list-inline-item">
                <p>{{ $publicAbout->email }}</p>
              </li>
              <li class="list-inline-item">
                <p>{{ $publicAbout->contact }}</p>
              </li>
            </ul>
          </div>
          @endif
        </div>
      </div>
    </footer>

    
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Contact form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/agency.min.js"></script>

  </body>

</html>
