<!DOCTYPE html>
<html lang="en">
<head>

     <title>HealthCare Center </title>
<!--

Template 2098 Health

http://www.tooplate.com/view/2098-health

-->
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="description" content="">
     <meta name="keywords" content="">
     <meta name="author" content="Tooplate">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

     <link rel="stylesheet" href="{{ asset('public/frontend/css/bootstrap.min.css') }}">
     <link rel="stylesheet" href="{{ asset('public/frontend/css/font-awesome.min.css') }}">
     <link rel="stylesheet" href="{{ asset('public/frontend/css/animate.css') }}">
     <link rel="stylesheet" href="{{ asset('public/frontend/css/owl.carousel.css') }}">
     <link rel="stylesheet" href="{{ asset('public/frontend/css/owl.theme.default.min.css') }}">

     <!-- MAIN CSS -->
     <link rel="stylesheet" href="{{ asset('public/frontend/css/tooplate-style.css') }}">

     <style>
          .text-right {
          text-align: right;
          padding-top: 12px;
          font-size: 15px;
          }
          /* Tăng khoảng cách giữa các liên kết trong phần user-actions */
          .user-actions a {
          display: inline-block;
          margin-right: 20px;  /* Tăng khoảng cách giữa các liên kết */
          font-size: 14px;
          text-decoration: none;
          }
          
     </style>
</head>
<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">

     <!-- PRE LOADER -->
     <section class="preloader">
          <div class="spinner">

               <span class="spinner-rotate"></span>
               
          </div>
     </section>


     <!-- HEADER -->
     <!-- <header>
          <div class="container">
               <div class="row">

                    <div class="col-md-4 col-sm-5">
                         <p>Welcome to a Professional Health Care</p>
                    </div>
                         
                    <div class="col-md-8 col-sm-7 text-align-right">
                         <span class="phone-icon"><i class="fa fa-phone"></i> 010-060-0160</span>
                         <span class="date-icon"><i class="fa fa-calendar-plus-o"></i> 6:00 AM - 10:00 PM (Mon-Fri)</span>
                         <a href="{{ URL::to('/log-in') }}" class="btn-login"><i class="fa fa-lock"></i> Đăng nhập</a>
                         <a href="{{ URL::to('/register') }}" class="btn-register"><i class="fa fa-user"></i> Đăng ký</a>                    
                    </div>

               </div>
          </div>
     </header> -->
     <header>
    <div class="container">
        <div class="row">
            <!-- Cột chào mừng -->
            <div class="col-md-5 col-sm-5">
            <span class="phone-icon"><i class="fa fa-phone"></i> 010-060-0160</span>
            <span class="date-icon"><i class="fa fa-calendar-plus-o"></i> 6:00 AM - 10:00 PM (Mon-Fri)</span>                
            </div>

            <!-- Cột thông tin liên hệ và người dùng -->
            <div class="col-md-7 col-sm-7 text-align-center">
               
                @if (!Auth::guard('patients')->check())
                    <!-- Khi người dùng chưa đăng nhập -->
                    <a href="{{ URL::to('/log-in') }}" class="btn-login"><i class="fa fa-lock"></i> Đăng nhập</a>
                    <a href="{{ URL::to('/register') }}" class="btn-register"><i class="fa fa-user"></i> Đăng ký</a>
                @else
                    <!-- Khi người dùng đã đăng nhập -->
                    <div class="user-actions text-right">
                        <a href="{{ URL::to('/enroll-history') }}" class="small mr-3">
                            <i class="fa fa-history"></i> Lịch sử khám
                        </a>
                        <a href="{{ URL::to('/enroll-history') }}" class="small mr-3">
                            <i class="fa fa-file-text-o"></i> Kết quả khám
                        </a>
                        <a href="{{ URL::to('/user-profile') }}" class="small mr-3">
                            <i class="fa fa-user"></i> Profile: 
                            @php
                                $user_info = DB::table('info_patients')->where('id', Auth::guard('patients')->id())->first();
                            @endphp
                            {{ $user_info ? $user_info->HoTen : 'N/A' }}
                        </a>
                        <a href="{{ URL::to('/dang-xuat') }}" class="small">
                            <i class="fa fa-sign-out"></i> Thoát
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>



     <!-- MENU -->
     <section class="navbar navbar-default navbar-static-top" role="navigation">
          <div class="container">

               <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>

                    <!-- lOGO TEXT HERE -->
                    <a href="{{ URL::to('/trang-chu') }}" class="navbar-brand"><i class="fa fa-h-square"></i>ealth Center</a>
                    

               </div>

               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-center">
                         <li><a href="{{ URL::to('/trang-chu') }}" class="smoothScroll">Trang chủ</a></li>
                         <li><a href="#team" class="smoothScroll">Chuyên khoa khám</a></li>
                         <li><a href="#news" class="smoothScroll">Chuyên gia - Bác sĩ</a></li>
                         <!-- <li><a href="#news" class="smoothScroll">Tra cứu kết quả khám</a></li> -->
                         <li><a href="#news" class="smoothScroll">Hướng dẫn khám</a></li>
                         <li><a href="#google-map" class="smoothScroll">Liên hệ</a></li>
                         <li class="appointment-btn"><a href="#appointment">Đăng ký khám</a></li>
                    </ul>

               </div>

          </div>
     </section>
     

          @yield('content')

     <!-- FOOTER -->
     <footer data-stellar-background-ratio="5">
          <div class="container">
               <div class="row">

                    <div class="col-md-4 col-sm-4">
                         <div class="footer-thumb"> 
                              <h4 class="wow fadeInUp" data-wow-delay="0.4s">Contact Info</h4>
                              <p>Fusce at libero iaculis, venenatis augue quis, pharetra lorem. Curabitur ut dolor eu elit consequat ultricies.</p>

                              <div class="contact-info">
                                   <p><i class="fa fa-phone"></i> 010-070-0170</p>
                                   <p><i class="fa fa-envelope-o"></i> <a href="#">info@company.com</a></p>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-4"> 
                         <div class="footer-thumb"> 
                              <h4 class="wow fadeInUp" data-wow-delay="0.4s">Latest News</h4>
                              <div class="latest-stories">
                                   <div class="stories-image">
                                        <a href="#"><img src="{{ asset('public/frontend/images/news-image.jpg') }}" class="img-responsive" alt=""></a>
                                   </div>
                                   <div class="stories-info">
                                        <a href="#"><h5>Amazing Technology</h5></a>
                                        <span>March 08, 2018</span>
                                   </div>
                              </div>

                              <div class="latest-stories">
                                   <div class="stories-image">
                                        <a href="#"><img src="{{ asset('public/frontend/images/news-image.jpg') }}" class="img-responsive" alt=""></a>
                                   </div>
                                   <div class="stories-info">
                                        <a href="#"><h5>New Healing Process</h5></a>
                                        <span>February 20, 2018</span>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-4"> 
                         <div class="footer-thumb">
                              <div class="opening-hours">
                                   <h4 class="wow fadeInUp" data-wow-delay="0.4s">Opening Hours</h4>
                                   <p>Monday - Friday <span>06:00 AM - 10:00 PM</span></p>
                                   <p>Saturday <span>09:00 AM - 08:00 PM</span></p>
                                   <p>Sunday <span>Closed</span></p>
                              </div> 

                              <ul class="social-icon">
                                   <li><a href="https://www.facebook.com/tooplate" class="fa fa-facebook-square" attr="facebook icon"></a></li>
                                   <li><a href="#" class="fa fa-twitter"></a></li>
                                   <li><a href="#" class="fa fa-instagram"></a></li>
                              </ul>
                         </div>
                    </div>

                    <div class="col-md-12 col-sm-12 border-top">
                         <div class="col-md-4 col-sm-6">
                              <div class="copyright-text"> 
                                   <p>Copyright &copy; 2017 Your Company 
                                   
                                   | Design: <a href="http://www.tooplate.com" target="_parent">Tooplate</a></p>
                              </div>
                         </div>
                         <div class="col-md-6 col-sm-6">
                              <div class="footer-link"> 
                                   <a href="#">Laboratory Tests</a>
                                   <a href="#">Departments</a>
                                   <a href="#">Insurance Policy</a>
                                   <a href="#">Careers</a>
                              </div>
                         </div>
                         <div class="col-md-2 col-sm-2 text-align-center">
                              <div class="angle-up-btn"> 
                                  <a href="#top" class="smoothScroll wow fadeInUp" data-wow-delay="1.2s"><i class="fa fa-angle-up"></i></a>
                              </div>
                         </div>   
                    </div>
                    
               </div>
          </div>
     </footer>

     <!-- SCRIPTS -->
     <script src="{{ asset('public/frontend/js/jquery.js') }}"></script>
     <script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>
     <script src="{{ asset('public/frontend/js/jquery.sticky.js') }}"></script>
     <script src="{{ asset('public/frontend/js/jquery.stellar.min.js') }}"></script>
     <script src="{{ asset('public/frontend/js/wow.min.js') }}"></script>
     <script src="{{ asset('public/frontend/js/smoothscroll.js') }}"></script>
     <script src="{{ asset('public/frontend/js/owl.carousel.min.js') }}"></script>
     <script src="{{ asset('public/frontend/js/custom.js') }}"></script>

</body>
</html>