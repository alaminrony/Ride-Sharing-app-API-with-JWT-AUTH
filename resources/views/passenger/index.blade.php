<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<title>Passenger Dashboard</title>
	</head>
	<body>
		{{-- navbar : start	 --}}
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">Navbar</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item active">
							<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Link</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Account
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								

								<form class="dropdown-item" action="{{ route('passenger.logout') }}" id="formLogOut" method="POST" style="display: none;">
                            @csrf
                        </form>
                        {{-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink"> --}}
                            <a class="dropdown-item" onclick="document.getElementById('formLogOut').submit();">Log out</a>
                          {{--   <a class="dropdown-item" href="{{ route('profile.edit') }}">My profile</a> --}}
                        {{-- </div> --}}


								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</li>
						{{-- dropdown --}}

					</ul>
				</div>
			</div>
		</nav>
		{{-- navbar : end	 --}}
		

		{{
			Auth::user('passenger')->p_first_name.' '.Auth::user('passenger')->p_last_name
		}}
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	</body>
</html>