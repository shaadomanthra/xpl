<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../../../">
		<meta charset="utf-8" />
		<title>{{request()->session()->get('client')->name}}</title>
		<meta name="description" content="Singin page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="assets/css/pages/login/login-4.css?v=7.0.4" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css?v=7.0.4" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.4" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css?v=7.0.4" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="assets/css/themes/layout/header/base/light.css?v=7.0.4" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/header/menu/light.css?v=7.0.4" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/brand/dark.css?v=7.0.4" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/aside/dark.css?v=7.0.4" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Content-->
				<div class="login-container order-2 order-lg-1 d-flex flex-center flex-row-fluid px-7 pt-lg-0 pb-lg-0 pt-4 pb-6 bg-white">
					<!--begin::Wrapper-->
					<div class="login-content d-flex flex-column pt-lg-0 pt-12">
						<!--begin::Logo-->
						<a href="#" class="login-logo pb-xl-20 pb-15">
							<img src="{{ request()->session()->get('client')->logo }}" class="max-h-70px" alt="" />
						</a>
						<!--end::Logo-->

						

						<!--begin::Signin-->
						<div class="login-form">
							<!--begin::Form-->
							<form  method="POST" action="{{ route('login') }}">
								{{ csrf_field() }}
								<!--begin::Title-->
								<div class="pb-5 pb-lg-15">
									<h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h3>
									<div class="text-muted font-weight-bold font-size-h4">New Here?
									<a href="{{ route('register') }}" class="text-primary font-weight-bolder">Create Account</a></div>
								</div>
								<!--begin::Title-->
								<!--begin::Form group-->
								<div class="form-group">
									<label class="font-size-h6 font-weight-bolder text-dark">Email</label>
									<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="text" name="email" autocomplete="off" />
								</div>
								<!--end::Form group-->
								<!--begin::Form group-->
								<div class="form-group mb-4">
									<div class="d-flex justify-content-between mt-n5 mb-4">
										<label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
										
									</div>
									<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="password" name="password" autocomplete="off" />
									<div class="mt-5">
									<a href="{{ route('password.request') }}" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5 mt-4">Forgot Password ?</a>
								</div>
								</div>
								<!--end::Form group-->
								<!--begin::Action-->
								<div class="pb-lg-0 pb-5">
									<input id="client_slug" type="hidden" class="form-control" name="client_slug" value="{{subdomain()}}">
									<button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In</button>
									<button type="button" class="btn btn-light-primary font-weight-bolder px-8 py-4 my-3 font-size-lg">
									<span class="svg-icon svg-icon-md">
										<!--begin::Svg Icon | path:assets/media/svg/social-icons/google.svg-->
										<i class="fa flaticon-letter-g"></i>
										<!--end::Svg Icon-->
									</span></button>
									<button type="button" class="btn btn-light-primary font-weight-bolder px-8 py-4 my-3 font-size-lg">
									<span class="svg-icon svg-icon-md">
										
										<i class="fa flaticon-facebook-letter-logo"></i>
									</span></button>
									<button type="button" class="btn btn-light-primary font-weight-bolder px-8 py-4 my-3 font-size-lg">
									<span class="svg-icon svg-icon-md">
										
										<i class="fa flaticon-linkedin-logo"></i>
									</span></button>
								</div>
								<!--end::Action-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Signin-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--begin::Content-->
				<!--begin::Aside-->
				<div class="login-aside order-1 order-lg-2 bgi-no-repeat bgi-position-x-right">
					<div class="login-conteiner bgi-no-repeat bgi-position-x-right bgi-position-y-bottom" style="background-image: url(assets/media/svg/illustrations/login-visual-4.svg);">
						<!--begin::Aside title-->
						<h3 class="pt-lg-40 pl-lg-20 pb-lg-0 pl-10 py-20 m-0 d-flex justify-content-lg-start font-weight-boldest display5 display1-lg text-white">We Got
						<br />A Surprise
						<br />For You</h3>
						<!--end::Aside title-->
					</div>
				</div>
				<!--end::Aside-->
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->
		
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js?v=7.0.4"></script>
		<script src="assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.4"></script>
		<script src="assets/js/scripts.bundle.js?v=7.0.4"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="assets/js/pages/custom/login/login-4.js?v=7.0.4"></script>
		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>