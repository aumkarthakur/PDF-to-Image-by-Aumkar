<!DOCTYPE html>
<html>
<head>
	<title>PDF to Image by Aumkar Thakur</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>

	<div class="container"><br/><br/>
	
	<div class="jumbotron">
	<h1 class="display-4">PDF to Image by Aumkar Thakur</h1><br/>
	<form method="post" enctype="multipart/form-data">
		<div class="form-group">
			<input type="file" name="pdf" value="" class="form-control-file" aria-describedby="fileHelp"> 
			<br/><input type="submit" name="Upload" value="Upload" class="btn btn-primary">
		</div>
	</form>
	</div>
	

		<?php
		$target_dir = "upload/pdf/";
		$target_file = $target_dir . "pdf.pdf";
		if(isset($_POST["Upload"])) {

		// PDF VALIDATION
		$finfo = finfo_open(FILEINFO_MIME_TYPE); 
		$filetype = finfo_file($finfo, $_FILES["pdf"]["tmp_name"]);
		finfo_close($finfo);

		if($filetype == 'application/pdf'){

		    if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
					$im = new Imagick();
					$im->setResolution(300, 300);     //set the resolution of the resulting jpg
					$im->pingImage('upload/pdf/pdf.pdf');
					$pdfpagecount = $im->getNumberImages() -1;

					array_map('unlink', glob("upload/image/*")); // Emptying Directory

					for($i=0;$i<=$pdfpagecount;$i++){

					$im->readImage('upload/pdf/pdf.pdf['.$i.']');
					$im->setImageFormat('jpg');
					$im->writeImage('upload/image/image'.$i.'.jpg');
					}

					// Now Getting All Images in Image Directory.
					$allimages = glob("upload/image/*.jpg");
					echo '<hr><h2>Result:</h2><br/>';
					foreach($allimages as $image) {
					    echo '<img src="'.$image.'" class="img-fluid"/><hr><br />';
					}
		    } else {
		        echo '<div class="alert alert-danger" role="alert">Sorry, there was an error uploading your file.</div>';
		    }

		}else{
		        echo '<div class="alert alert-danger" role="alert"> Please Upload Valid <strong>PDF</strong> file.</div>';
		}


		}
		?>

	</div>



</body>
</html>









