<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="{{ asset('/userLogin/img/MicrotechOs.png') }}" type="image/png">
	<title>{{ config('app.name') }} - Login Page</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/userLogin/css/login-style.css') }}">
    <!-- JQuery -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>
	@if(Session::has('status'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
    	<div class="text-center">
  			<strong>Success!</strong> {{ Session::get('status') }}
  		</div>
  		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
	@endif
	<div class="body">
		<div class="container">
			<div class="row">
				<div class="col-md-5 mx-auto">
					<div class="content">
						<div class="form-div">
							<div class="col-md-12 text-center mb-3">
								<h1>Login</h1>
							</div>
							<form method="POST" action="{{ route('login.post.check') }}">
							@csrf
								@if($errors->any())
								<div class="alert alert-danger" role="alert">
									@foreach ($errors->all() as $error)
									{{ $error }}
									@endforeach
								</div>
								@endif
								<div class="mb-4">
									<label for="exampleInputEmail1" class="form-label label-class required">Email address</label>
									<input type="email" class="form-control input-class" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter a valid email address" required>
								</div>
								<div class="mb-4">
									<label for="exampleInputPassword1" class="form-label label-class required">Password</label>
									<input type="password" class="form-control input-class" name="password" id="exampleInputPassword1" placeholder="Enter password" required>
								</div>
								<div class="mb-4 text-center">
									<p>By signing up you accept our <a href="">Terms Of Use</a></p>
								</div>
								<!-- <div class="mb-3 form-check">
									<input type="checkbox" class="form-check-input" id="exampleCheck1">
									<label class="form-check-label" for="exampleCheck1">Check me out</label>
								</div> -->
								<div class="mb-4 col-md-12 text-center">
									<button type="submit" class="btn btn-primary btn-block">Login</button>
								</div>
							</form>
							<div class="mb-4 text-center">
								<p>
									<a href="">Forgot Password?</a>
								</p>
							</div>
							<div class="row">
								<div class="col-md-12">
									<p class="text-center">Don't have an account? <a href="">Sign up here</a>
									</p>
								</div>
							</div>
							<div>
								<hr>
								<p class="text-center">
									<a href="">Continue Without Login</a>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- Boostrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</html>