<!DOCTYPE html>
<html lang="en">

<x-head/>

<body>
	<div id="global-loader">
		<div class="whirly-loader"> </div>
	</div>
	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<x-header/>
		<!-- /Header -->

		<!-- Sidebar -->
		<x-sidebar/>
		<!-- /Sidebar -->

		<div class="page-wrapper">
            @yield("content")


        

		</div>




	</div>
	<!-- /Main Wrapper -->



	<!-- jQuery -->
	<x-script/>
@stack('scripts') 

</body>

</html>
