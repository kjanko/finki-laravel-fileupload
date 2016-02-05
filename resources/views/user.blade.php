<!DOCTYPE html>
<html lang="en">

<head>

	<title>ФИНКИ - File Sharing</title>
	<meta charset="utf-8" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{!! csrf_token() !!}">


    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection" />

    <!-- jQuery	-->
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

    <!-- Bootstrap	-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Alertify -->
    {!! Html::style('js/alertify/dist/css/alertify-bootstrap-3.css') !!}
    {!! Html::script('js/alertify/dist/js/alertify.js') !!}

    <!-- Plupload & frontend implementation -->
    {!! Html::script('js/plupload/upload.js') !!}
    {!! Html::script('js/plupload/plupload.full.min.js') !!}


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
							
				<div class="panel panel-primary finki-medium-box">
					
					<div class="panel-heading text-center">Систем за споделување на фајлови</div>

					<div class="panel-body">
					
						<blockquote>
							<p class="finki-text-medium">
								Сервисот ви овозможува повеќекратен избор на фајлови, како и преглед на вашите досегашни фајлови. <br />
								Максималната дозволена големина на фајл е: <strong>10 GB</strong> <br />
                                Дозволени екстензии: <strong>jpg, tif, gif, png, tar, bz2, 7z, rar, zip, .tar.*</strong> <br />
							</p>
						</blockquote>

                        <!-- http://www.plupload.com/docs/Options -->
                        {!! Plupload::make('file_upload', action('FileController@upload'))
                            ->setOptions([
                                'filters' => [
                                    'max_file_size' => '10000mb',
                                    'prevent_duplicates' => true,
                                    'mime_types' => [
                                        [ 'title' => 'Image files', 'extensions' => 'jpg,gif,png,tif' ],
                                        [ 'title' => 'Zip files', 'extensions' => 'zip,rar,tar,7z,bz2,arj' ]
                                    ],
                                ],
                                'headers' => [
                                    'x-csrf-token' => csrf_token()
                                ],
                                'chunk_size' => '100kb',
                        ])
                        ->render() !!}

                        <script>
                            $(function () {
                                createUploader('file_upload');
                            });
                        </script>

                        <table role="presentation" class="table table-striped">

                            <tbody class="files">
                                @foreach ($files as $key => $file)
                                <tr id="{!! $key !!}" class="template-upload fade in">
                                    <td>
                                        <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                                    </td>
                                    <td>
                                        <p class="name">
                                            <a href="{!! action("FileController@download", ['file' => $file[0]]) !!}">
                                            {!!
                                                base64_decode(pathinfo($file[0], PATHINFO_FILENAME))
                                            !!}
                                            </a>
                                        </p>
                                        <strong class="error text-danger"></strong>
                                    </td>
                                    <td>
                                        <p class="size">{!! $file[1] !!}</p>
                                    </td>

                                    <td>
                                        <input type="hidden" name="path_{!! $key !!}" value="{!! $file[2] !!}" />
                                        <button class="btn btn-danger delete" onclick="removeFile('{!! $key !!}')">
                                            <i class="glyphicon glyphicon-trash"></i>
                                            <span>Delete</span>
                                        </button>

                                    </td>

                                </tr>
                                @endforeach
                            </tbody>

                        </table>

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