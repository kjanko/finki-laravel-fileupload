<!DOCTYPE html>
<html lang="en">

<head>

	<title>ФИНКИ - File Sharing</title>
	<meta charset="utf-8" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1">

    {!! Html::style('css/style.css') !!}

	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	
	<!-- Bootstrap	-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

	
</head>

<body>
	<!-- WRAPPER -->
	<div class="container" id="wrapper">
		<!-- FIRST -->
		<div class="row">
		
			<div class="col-md-12 text-center">
				
				<img src="./images/finki-logo-9.png" alt="logo" />
				
			</div>
			
			<div class="col-md-12">
							
				<div class="panel panel-primary finki-small-box-center">
					
					<div class="panel-heading text-center">Систем за споделување на фајлови</div>

					<div class="panel-body">
						
						<div class="row">
						
							<div class="col-md-6">
							
								<img src="./images/CASlogo.png" class="img-responsive" alt="logo" />
								
							</div>
						
							<div class="col-md-6" style="margin-top: 30px;">
								<h4>Најава</h4>
								<p>Со цел да пристапите до овој сервис на ФИНКИ, ве молиме да се најавите!</p>
								
								<a href="{!! url('user/') !!}">
									<button type="button" class="btn btn-danger btn-md">Login</button>
								</a>
								
							</div>
							
						</div>
						
						<hr />
						
						<p class="text-center finki-text-small">
							Централниот Автентикациски Сервис на ФИНКИ овозможува пристап до сите овие сервиси, а секој студент може да ги користи само оние што му се потребни. Сите студенти добиваат иницијално корисничко име кое е еднакво со бројот на индексот, а можат да ја променат или активираат својата лозинка преку сервисот за промена на лозинка.
						</p>
						
					</div>
					
				</div>
				
				<p class="text-center finki-text-small">© 2011-2016 ФИНКИ Сите права се задржани</p>
				
			</div>
			
		</div>
		<!-- END FIRST -->
	</div>
	<!-- END WRAPPER -->
</body>

</html>