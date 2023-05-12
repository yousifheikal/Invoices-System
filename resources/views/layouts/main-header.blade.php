<!-- main-header opened -->
			<div class="main-header sticky side-header nav nav-item">
				<div class="container-fluid">
					<div class="main-header-left ">
						<div class="responsive-logo">
							<a href="{{ url('/' . $page='dashboard') }}"><img src="{{URL::asset('assets/img/brand/logo.png')}}" class="logo-1" alt="logo"></a>
							<a href="{{ url('/' . $page='dashboard') }}"><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="dark-logo-1" alt="logo"></a>
							<a href="{{ url('/' . $page='dashboard') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-2" alt="logo"></a>
							<a href="{{ url('/' . $page='dashboard') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="dark-logo-2" alt="logo"></a>
						</div>
						<div class="app-sidebar__toggle" data-toggle="sidebar">
							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
						</div>
						<div class="main-header-center mr-3 d-sm-none d-md-none d-lg-block">
							<input class="form-control" placeholder="Search for anything..." type="search"> <button class="btn"><i class="fas fa-search d-none d-md-block"></i></button>
						</div>
					</div>
					<div class="main-header-right">
						<ul class="nav">
							<li class="">
							</li>
						</ul>
						<div class="nav nav-item  navbar-nav-right ml-auto">
							<div class="nav-link" id="bs-example-navbar-collapse-1">
								<form class="navbar-form" role="search">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Search">
										<span class="input-group-btn">
											<button type="reset" class="btn btn-default">
												<i class="fas fa-times"></i>
											</button>
											<button type="submit" class="btn btn-default nav-link resp-btn">
												<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
											</button>
										</span>
									</div>
								</form>
							</div>
							<div class="dropdown nav-item main-header-notification">
								<a class="new nav-link" href="#">
								<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class=" pulse"></span></a>
								<div class="dropdown-menu">
									<div class="menu-header-content bg-primary text-right">
										<div class="d-flex">
											<h1 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">
                                                الاشعارات
{{--                                                <a href="{{route('mark.read')}}" class="float-right text-light">الاشعارات قراءة جميع الاشعارات </a>--}}
                                            </h1>
                                        </div>
                                        <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">لديك {{Auth::User()->unreadNotifications->count()}}  اشعارات غير مقرؤة </p>
									</div>
                                    @foreach(Auth::User()->unreadNotifications as $notification)
									<div class="main-notification-list Notification-scroll">
										<a class="d-flex p-3 border-bottom" href="{{route('invoice.details', $notification->data['invoice_id'])}}">
{{--											<div class="notifyimg bg-warning">--}}
{{--												<i class="la la-envelope-open text-white"></i>--}}
{{--											</div>--}}
                                            <img src="{{asset('profile/3135715.png')}}" width="70px" class="w-200 rounded-circle" alt="not-found">

                                            <div class="mr-3">
                                                <h8 class="text-info">{{$notification->data['user-name']}}</h8>
                                                <p class="notification-label mb-1">Add new invoice</p>
												<div class="notification-subtext">{{$notification->created_at}}</div>
											</div>
											<div class="mr-auto" >
												<i class="las la-angle-left text-left text-muted"></i>
											</div>
										</a>
									</div>
                                    @endforeach
									<div class="dropdown-footer">
                                        <a href="{{route('mark.read')}}">رؤاية جميع الاشعارات</a>
									</div>
								</div>
							</div>
							<div class="nav-item full-screen fullscreen-button">
								<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
							</div>
							<div class="dropdown main-profile-menu nav nav-item nav-link">
								<a class="profile-user d-flex" href=""><img alt="" src="{{asset('profile/3135715.png')}}"></a>
								<div class="dropdown-menu">
									<div class="main-header-profile bg-primary p-3">
										<div class="d-flex wd-100p">
											<div class="main-img-user"><img alt="" src="{{asset('profile/3135715.png')}}" class=""></div>
											<div class="mr-3 my-auto">
												<h6>{{ucfirst(username())}}</h6><span>{{email()}}</span>
											</div>
										</div>
									</div>
									<a class="dropdown-item" href="{{route('dashboard')}}"><i class="bx bx-user-circle"></i>الصفحة الرئيسية</a>
									<a class="dropdown-item" href="{{route('invoices.index')}}"><i class="bx bxs-inbox"></i>الفواتير</a>
                                    <a class="dropdown-item" href="{{route('invoices.report')}}"><i class="bx bxs-inbox"></i>التقارير</a>
                                    <a class="dropdown-item" href="{{route('sections.index')}}"><i class="bx bxs-inbox"></i>الاقسام</a>
									<a class="dropdown-item" href="{{route('products.index')}}"><i class="bx bxs-inbox"></i>المنتجات</a>
                                    <a class="dropdown-item" href="{{route('users.create')}}"><i class="bx bx-cog"></i>اضافة مستخدم</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                            class="bx bx-log-out"></i>تسجيل خروج</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
								</div>
							</div>
{{--							<div class="dropdown main-header-message right-toggle">--}}
{{--								<a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">--}}
{{--									<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>--}}
{{--								</a>--}}
{{--							</div>--}}
						</div>
					</div>
				</div>
			</div>
<!-- /main-header -->
