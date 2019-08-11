<?php
	require "../conn.php";
	
	$key = 'file';
    $dir = '../../public/data/UP_img/';
    $type = '';
	
	$unix = time();
	
	if( isset( $_FILES[$key] ) ){
		$file = $_FILES[$key];
		if( $file['error'] == 0 ){
            if ($file['type'] == 'image/jpeg') {
                $type = 'jpg';
            }else if ($file['type'] == 'image/png') {
                $type = 'png';
            }

			$filename = $dir . $unix . $type;
			$urlname = '/data/UP_img/' . $unix . $type;
			$is = move_uploaded_file( $file['tmp_name'], $filename);
			if( !$is ){
				die('上传失败');
			}
			
			echo $urlname;
			
		}
	}