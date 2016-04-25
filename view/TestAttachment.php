<?php
	# Check form submitted?
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		/**
		* Builds a file path with the appropriate directory separator.
		* @param string $segments,... unlimited number of path segments
		* @return string Path
		*/
		function file_build_path(...$segments) {
		    return join(DIRECTORY_SEPARATOR, $segments);
		}
	
		$uploadfile = file_build_path("C:", "xampp", "htdocs", "mminsurance.com", "uploads", basename($_FILES['userfile']['name']));

		echo '<pre>';
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		    echo "File is valid, and was successfully uploaded.\n";
		} else {
		    echo "Possible file upload attack!\n";
		}

		echo 'Here is some more debugging info:';
		print_r($_FILES);

		print "</pre>";		
	}
  ?>
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="TestAttachment.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
    <!-- Name of input element determines name in $_FILES array -->
    Send this file: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>