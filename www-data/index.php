<?php
$fonts = array();
$files = @scandir('fonts');
foreach($files as $file) {
	$ext = substr($file, -4);
	if($ext == '.ttf' || $ext == '.ttc' || $ext == '.otf') {
		$fonts[$file] = ucfirst(substr($file, 0, -4));
	}
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invisible mask demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="container-fluid text-center">
      <form action="action.php" method="post" enctype="multipart/form-data" style="width: 100%;max-width: 360px;padding: 15px;margin: auto;">
        <h1 class="h2">Invisible mask demo</h1>
        <div class="form-group row">
          <label for="image" class="col-4 col-form-label">Image</label>
          <div class="col-8">
            <input id="image" name="image" type="file" class="form-control-file" />
          </div>
        </div>
        <div class="form-group row">
          <label for="text" class="col-4 col-form-label">Mark</label>
          <div class="col-8">
            <input id="text" name="text" type="text" class="form-control" />
          </div>
        </div>
        <div class="form-group row">
          <label for="font" class="col-4 col-form-label">Font</label>
          <div class="col-8">
            <select id="font" name="font" class="form-control">
              <?php foreach($fonts as $file => $font) { ?>
              <option value="<?=$file;?>"><?=$font;?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </body>
</html>