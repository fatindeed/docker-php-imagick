<?php

if($_FILES['image']['error']) {
	throw new RuntimeException('Image upload failed #'.$_FILES['image']['error'], $_FILES['image']['error']);
}
$uploadImage = tempnam(sys_get_temp_dir(), 'Tmp');
if(!move_uploaded_file($_FILES['image']['tmp_name'], $uploadImage)) {
	throw new RuntimeException('Image upload failed');
}
if(empty($_POST['text'])) {
	throw new InvalidArgumentException('Invalid text');
}
if(empty($_POST['font']) || !file_exists('fonts/'.$_POST['font'])) {
	throw new InvalidArgumentException('Invalid font');
}

require('ImageMark.php');

if(!file_exists('output')) {
	mkdir('output');
}
$tempnam = basename($uploadImage);
$combinedImgPath = 'output/combined_'.$tempnam.'.png';
$maskImgPath = 'output/mask_'.$tempnam.'.png';

$combined = ImageMark::write($uploadImage, $_POST['text'], $_POST['font']);
$combined->setImageFormat('png');
file_put_contents($combinedImgPath, $combined->getImageBlob());

$mask = ImageMark::read($combined);
$mask->setImageFormat('png');
file_put_contents($maskImgPath, $mask->getImageBlob());

?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invisible Mask Demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </head>
  <body class="text-center">
    <h1 class="h2">Invisible Mask Demo</h1>
    <div id="carousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carousel" data-slide-to="0" class="active"></li>
        <li data-target="#carousel" data-slide-to="1"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100" src="<?=$combinedImgPath;?>" alt="First slide">
          <div class="carousel-caption d-none d-md-block">
            <h5>Combined Image</h5>
          </div>
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="<?=$maskImgPath;?>" alt="Second slide">
          <div class="carousel-caption d-none d-md-block">
            <h5>Mask Image</h5>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>