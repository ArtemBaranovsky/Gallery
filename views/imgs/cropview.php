<!doctype html>
<html lang="ru">
<head> 
	<meta charset="utf-8"> 
	<meta http-equiv="x-ua-compatible" content="ie=edge"> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta name="description" content="Полный пример Cropper."> 
	<meta name="keywords" content="HTML, CSS, JS, JavaScript, jQuery plugin, image cropping, image crop, image move, image zoom, image rotate, image scale, front-end, frontend, web development"> 
	<meta name="author" content="AndreyEx"> <title>Демо - простая обрезка изображения с помощью jQuery и плагина cropper.js</title> 
	<link rel="stylesheet" href="//andreyex.ru/wp-content/themes/sunrain/css/cropper/bootstrap.min.css"> 
	<link rel="stylesheet" href="//andreyex.ru/wp-content/themes/sunrain/css/cropper/cropper.min.css"> 
	<link rel="stylesheet" href="//andreyex.ru/wp-content/themes/sunrain/css/cropper/main.css">
</head>
<body> 
<div class="container" id="crop-avatar"> 
	<!-- Current avatar --> 
	<div class="avatar-view" title="Смена аватара"> 
		<img src="//andreyex.ru/wp-content/themes/sunrain/images/cropper/picture.jpg" alt="Аватар"> 
	</div><!-- Обрезка --> <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1"> 
	<div class="modal-dialog modal-lg"> 
		<div class="modal-content"> 
			<form class="avatar-form" action="web/crop.php" enctype="multipart/form-data" method="post"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button> 
				<h4 class="modal-title" id="avatar-modal-label">Изменить аватар</h4> 
			</div> 
				<div class="modal-body"> 
					<div class="avatar-body"> 
					<!-- Загрузка изображения и данных --> 
						<div class="avatar-upload"> 
							<input type="hidden" class="avatar-src" name="avatar_src"> 
							<input type="hidden" class="avatar-data" name="avatar_data"> 
							<label for="avatarInput">Локальная загрузка</label> 
							<input type="file" class="avatar-input" id="avatarInput" name="avatar_file"> 
						</div> 
					<!-- Кадрирование и просмотр --> 
					<div class="row"> 
						<div class="col-md-9"> 
							<div class="avatar-wrapper">
							</div> 
						</div> 
					<div class="col-md-3"> 
						<div class="avatar-preview preview-lg">
						</div> 
							<div class="avatar-preview preview-md">
							</div> 
							<div class="avatar-preview preview-sm">
							</div> 
						</div> 
					</div> 
					<div class="row avatar-btns"> 
						<div class="col-md-9"> 
							<div class="btn-group"> 
							<button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">Поворот налево</button> 
							<button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-15 град</button> 
							<button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-30 град</button> 
							<button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-45 град</button> 
						</div> 
						<div class="btn-group"> 
							<button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees">Поворот направо</button> 
							<button type="button" class="btn btn-primary" data-method="rotate" data-option="15">15 град</button> 
							<button type="button" class="btn btn-primary" data-method="rotate" data-option="30">30 град</button> 
							<button type="button" class="btn btn-primary" data-method="rotate" data-option="45">45 град</button> 
						</div> 
					</div> 
					<div class="col-md-3"> 
						<button type="submit" class="btn btn-primary btn-block avatar-save">Готово</button> 
					</div> 
				</div> 
			</div> 
		</div> 
		</form> 
	</div> 
</div> 
</div>
	<!-- /.modal --> 
	<!-- Loading state --> 
	<div class="loading" aria-label="Loading" role="img" tabindex="-1">
	</div> 
</div>
	<!-- include Stylesheet -->
	<link href="//andreyex.ru/wp-content/themes/sunrain/css/cropper/bootstrap.min.css" rel="stylesheet" />
	<header style="width: 600px; margin: 0 auto;"> 
	<!--<img src="//andreyex.ru/wp-content/uploads/2017/01/Prostaya-obrezka-izobrazheniya-s-pomoshhyu-cropper.js-i-PHP.jpg" />-->
	<div style="margin: 20px 0;">
		<!--<a href="https://andreyex.ru/blog-platforma-wordpress/prostaya-obrezka-izobrazheniya-s-pomoshhyu-cropper-js-i-php/" class="stuts">Простое кадрирование изображения с помощью cropper.js и PHP - обратно в учебник</a>-->
		</div>
		</header> 
		<!-- Container with last photos --> 
		<div class="container" style="display: none;"> 
		<h4></h4> 
		<h3>Credit Card Validation </h3> 
		<form method="post"> 
			<input type="text" name="cctype" class="txtbox" placeholder="enter credit card type"> 
			<input type="submit" name="submit" class="btn btn-primary" value="Validate Credit card"> 
		</form> 
		<!-- include the email subscriber form --> 
		<div class="section-links" style="display: none;"> 
			<form action="https://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('https://feedburner.google.com/fb/a/mailverify?uri=AndreyEx', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"> 
				<h3>Получите доступ к 150+ демо скриптов бесплатно!</h3> 
				<input type="text" class="txtbox" name="email" placeholder="Enter your email address"> 
				<input type="submit" value="Subscribe" class="btn btn-primary"> 
				<input type="hidden" value="Webmentor" name="uri">
					<br> 
				<input type="hidden" name="loc" value="en_US"><br> 
			</form> 
		</div> 
		<!-- include the email subscriber form --> 
	</div> 
<script src="//andreyex.ru/wp-content/themes/sunrain/js/cropper/jquery.min.js"></script> 
<script src="//andreyex.ru/wp-content/themes/sunrain/js/cropper/bootstrap.min.js"></script> 
<script src="//andreyex.ru/wp-content/themes/sunrain/js/cropper/cropper.min.js"></script> 
<script src="//andreyex.ru/wp-content/themes/sunrain/js/cropper/main.js"></script></body></html>