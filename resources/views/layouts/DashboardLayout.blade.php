<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
	@include('includes.style')
	@stack('costum-style')
  </head>
  <body>
	<div class="container-scroller">
	  <!-- partial:partials/_navbar.html -->
	  @include('components.navbar')
	  <!-- partial -->
	  <div class="container-fluid page-body-wrapper">
		<!-- partial:partials/_sidebar.html -->
		@include('components.sidebar')
		<!-- partial -->
		<div class="main-panel">
		  <div class="content-wrapper">
			<div class="page-header">
			  <h3 class="page-title">
				<span class="page-title-icon bg-gradient-primary text-white me-2">
				@yield('iconPage')
				</span> @yield('pageTitle')
			  </h3>
			  <nav aria-label="breadcrumb">
				<ul class="breadcrumb">
					@yield('breadcrumb')
				</ul>
			  </nav>
			</div>

			@yield('pageContent')
		  </div>
		  <!-- content-wrapper ends -->
		  <!-- partial:partials/_footer.html -->
		  @include('components.footer')
		  <!-- partial -->
		</div>
		<!-- main-panel ends -->
	  </div>
	  <!-- page-body-wrapper ends -->
	</div>
	<!-- container-scroller -->
	@include('includes.script')
	@stack('customJs')
	<!-- End custom js for this page -->
  </body>
</html>