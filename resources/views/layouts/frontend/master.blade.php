{{--@dd(session('cart'))--}}
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="author" content="M_Adnan">
   <title>ECOSHOP - Multipurpose eCommerce HTML5 Template</title>

   <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
   <link rel="stylesheet" type="text/css" href="rs-plugin/css/settings.css" media="screen"/>

   <!-- Bootstrap Core CSS -->
   <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">

   <!-- Custom CSS -->
   <link href="{{asset('frontend/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
   <link href="{{asset('frontend/css/ionicons.min.css')}}" rel="stylesheet">
   <link href="{{asset('frontend/css/main.css')}}" rel="stylesheet">
   <link href="{{asset('frontend/css/style.css')}}" rel="stylesheet">
   <link href="{{asset('frontend/css/responsive.css')}}" rel="stylesheet">

   <!-- JavaScripts -->
   <script src="{{asset('frontend/js/modernizr.js')}}"></script>

   <!-- Online Fonts -->
   <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
   <link href='https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900' rel='stylesheet' type='text/css'>

   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
   <![endif]-->

</head>
<body>

{{--<!-- LOADER -->--}}
{{--<div id="loader">--}}
   {{--<div class="position-center-center">--}}
      {{--<div class="ldr"></div>--}}
   {{--</div>--}}
{{--</div>--}}

<!-- Wrap -->
<div id="wrap">

   <!-- header -->
   <header>
      <div class="sticky">
         <div class="container">

            <!-- Logo -->
            <div class="logo"><a href="index.html"><img class="img-responsive" src="images/logo.png" alt=""></a></div>
            <nav class="navbar ownmenu">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                          data-target="#nav-open-btn" aria-expanded="false"><span
                           class="sr-only">Toggle navigation</span> <span class="icon-bar"><i class="fa fa-navicon"></i></span>
                  </button>
               </div>

               <!-- NAV -->
               <div class="collapse navbar-collapse" id="nav-open-btn">
                  <ul class="nav">


                     <li><a href="{{action('FrontendController@index')}}">Home</a></li>


                     <li class="dropdown"><a href="#." class="dropdown-toggle" data-toggle="dropdown">Categories</a>
                        <ul class="dropdown-menu">
                           @foreach($Categories as $category)
                              <li>
                                 <a href="{{action('FrontendController@getCategory',['slug'=>$category->slug])}}">{{$category->name}} </a>
                              </li>
                           @endforeach
                        </ul>
                     </li>
                     <li><a href="about-us_01.html">About </a></li>
                  </ul>
               </div>

               <!-- Nav Right -->
               <div class="nav-right">
                  <ul class="navbar-right">
                  @if (session()->has('login'))
                     <!-- USER INFO -->
                        <li class="dropdown user-acc"><a href="{{action('FrontendController@register')}}"
                                                         class="dropdown-toggle" data-toggle="dropdown" role="button"><i
                                    class="icon-user"></i> </a>
                           <ul class="dropdown-menu">
                              <li>
                                 <h6>Hello,
                                    @if(session()->has('name'))
                                       {{ Session::get('name')}}
                                    @endif
                                 </h6>
                              </li>
                              <li><a href="/cart">MY CART</a></li>
                              <li><a href="#">ACCOUNT INFO</a></li>
                              <li><a href="{{action('FrontendController@logout')}}">LOG OUT</a></li>
                           </ul>
                        </li>
                        <li class="dropdown user-basket"><a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                            role="button" aria-haspopup="true" aria-expanded="true"><i
                                    class="icon-basket-loaded"></i> </a>
                           <ul class="dropdown-menu">
                              @foreach($carts as $cart)
                                 <li>
                                    <div class="media-left">
                                       <div class="cart-img"><a href="{{$cart['product']->slug}}"> <img
                                                   class="media-object img-responsive"
                                                   src="{{asset($cart['product']->image)}}"
                                                   alt="{{$cart['product']->name}}"> </a>
                                       </div>
                                    </div>
                                    <div class="media-body">
                                       <h6 class="media-heading">{{$cart['product']->name}}</h6>
                                       <span class="price">{{$cart['product']->price}} USD</span> <span
                                             class="qty">QTY: {{$cart['qty']}}</span></div>
                                 </li>
                              @endforeach
                              <li>
                                 <h5 class="text-center">SUBTOTAL: ${{$totalPrice}}</h5>
                              </li>
                              <li class="margin-0">
                                 <div class="row">
                                    <div class="col-xs-6"><a href="/cart" class="btn">VIEW CART</a></div>
                                    <div class="col-xs-6 "><a href="checkout.html" class="btn">CHECK OUT</a></div>
                                 </div>
                              </li>
                           </ul>
                        </li>

                  @else
                     <!-- USER BASKET -->
                        <li class="dropdown user-basket">
                           <a href="{{action('FrontendController@register')}}">Register</a>
                        </li>
                        <li class="dropdown user-acc"><a href="{{action('FrontendController@register')}}"
                                                         class="dropdown-toggle" data-toggle="dropdown" role="button">LOGIN</a>
                           <ul class="dropdown-menu">
                              <form action="{{action('FrontendController@login')}}" method='post'>
                                 @csrf
                                 <li>
                                    <label for="usename">Username</label>
                                    <input id='usename' class='form-control' name='user' type="text">
                                    <p class="font-italic text-center"
                                       style='color:red'>{{ $errors->first('user') }}</p>
                                 </li>
                                 <li>
                                    <label for="pass">Password</label>
                                    <input id='pass' class='form-control' name='password' type="password">
                                    <p class="font-italic text-center"
                                       style='color:red'>{{ $errors->first('password') }}</p>
                                 </li>
                                 <li>
                                    <button type="submit" class="btn">LOG IN</button>
                                 </li>
                              </form>
                           </ul>
                        </li>
                  @endif
                  <!-- SEARCH BAR -->
                     <li class="dropdown"><a href="javascript:void(0);" class="search-open"><i
                                 class=" icon-magnifier"></i></a>
                        <div class="search-inside animated bounceInUp"><i class="icon-close search-close"></i>
                           <div class="search-overlay"></div>
                           <div class="position-center-center">
                              <div class="search">
                                 <form>
                                    <input type="search" placeholder="Search Shop">
                                    <button type="submit"><i class="icon-check"></i></button>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </li>
                  </ul>
               </div>
            </nav>
         </div>
      </div>
   </header>

   <!-- Content -->
   <div id="content">

   @yield('content')

   <!-- About -->
      <section class="small-about padding-top-150 padding-bottom-150">
         <div class="container">

            <!-- Main Heading -->
            <div class="heading text-center">
               <h4>about ecoshop</h4>
               <p>Phasellus lacinia fermentum bibendum. Interdum et malesuada fames ac ante ipsumien lacus, eu posuere
                  odio luctus non. Nulla lacinia,
                  eros vel fermentum consectetur, risus purus tempc, et iaculis odio dolor in ex. </p>
            </div>

            <!-- Social Icons -->
            <ul class="social_icons">
               <li><a href="#."><i class="icon-social-facebook"></i></a></li>
               <li><a href="#."><i class="icon-social-twitter"></i></a></li>
               <li><a href="#."><i class="icon-social-tumblr"></i></a></li>
               <li><a href="#."><i class="icon-social-youtube"></i></a></li>
               <li><a href="#."><i class="icon-social-dribbble"></i></a></li>
            </ul>
         </div>
      </section>
      <section class="news-letter padding-top-150 padding-bottom-150">
         <div class="container">
            <div class="heading light-head text-center margin-bottom-30">
               <h4>NEWSLETTER</h4>
               <span>Phasellus lacinia fermentum bibendum. Interdum et malesuada fames ac ante ipsumien lacus, eu posuere odi </span>
            </div>
            <form>
               <input type="email" placeholder="Enter your email address" required>
               <button type="submit">SEND ME</button>
            </form>
         </div>
      </section>
   </div>

   <!--======= FOOTER =========-->
   <footer>
      <div class="container">

         <!-- Location -->
         <div class="col-md-3">
            <div class="about-footer"><img class="margin-bottom-30" src="images/logo-foot.png" alt="">
               <p><i class="icon-pointer"></i> Street No. 12, Newyork 12, <br> MD - 123, USA.</p>
               <p><i class="icon-call-end"></i> 1.800.123.456789</p>
               <p><i class="icon-envelope"></i> info@ecoshop.com</p>
            </div>
         </div>

         <!-- HELPFUL LINKS -->
         <div class="col-md-3">
            <h6>HELPFUL LINKS</h6>
            <ul class="link">
               <li><a href="#."> Products</a></li>
               <li><a href="#."> Find a Store</a></li>
               <li><a href="#."> Features</a></li>
               <li><a href="#."> Privacy Policy</a></li>
               <li><a href="#."> Blog</a></li>
               <li><a href="#."> Press Kit </a></li>
            </ul>
         </div>

         <!-- SHOP -->
         <div class="col-md-3">
            <h6>SHOP</h6>
            <ul class="link">
               <li><a href="#."> About Us</a></li>
               <li><a href="#."> Career</a></li>
               <li><a href="#."> Shipping Methods</a></li>
               <li><a href="#."> Contact</a></li>
               <li><a href="#."> Support</a></li>
               <li><a href="#."> Retailer</a></li>
            </ul>
         </div>

         <!-- MY ACCOUNT -->
         <div class="col-md-3">
            <h6>MY ACCOUNT</h6>
            <ul class="link">
               <li><a href="#."> Login</a></li>
               <li><a href="#."> My Account</a></li>
               <li><a href="#."> My Cart</a></li>
               <li><a href="#."> Wishlist</a></li>
               <li><a href="#."> Checkout</a></li>
            </ul>
         </div>

         <!-- Rights -->
         <div class="rights">
            <p>© 2016 ecoshop All right reserved. </p>
            <div class="scroll"><a href="#wrap" class="go-up"><i class="lnr lnr-arrow-up"></i></a></div>
         </div>
      </div>
   </footer>
</div>
<script src="{{asset('frontend/js/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/js/own-menu.js')}}"></script>
<script src="{{asset('frontend/js/jquery.lighter.js')}}"></script>
<script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>

@yield('extra-js')

<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
<script type="text/javascript" src="{{asset('frontend/rs-plugin/js/jquery.tp.t.min.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/rs-plugin/js/jquery.tp.min.js')}}"></script>
<script src="{{asset('frontend/js/main.js')}}"></script>
</body>
</html>