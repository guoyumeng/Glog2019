<?php  
    header('content-type:text/html;charset=utf-8'); 
    
    

	$searchData=file_get_contents('https://suggest.taobao.com/sug?code=utf-8&q=%E5%B0%8F%E7%B1%B3&_ksTS=1531875451151_4360&callback=jsonp4361&area=b2c&code=utf-8&k=1&bucketid=9&src=tmall_pc');
	echo $searchData;
?>