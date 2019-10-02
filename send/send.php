<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $to='joomi94@yandex.ru'; // получатель письма

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $tel = htmlspecialchars($_POST['tel']);


    $subject = "Письмо с сайта";
	$message = '<html><head><title>'.$subject.'</title></head><body>
			Имя: '.$name.'<br>
			Телефон: '.$tel.'<br>
</body></html>';

	$headers="MIME-Version: 1.0\r\n"
	."Content-type: text/html; charset=UTF-8\r\n"
	."From: ".$name."  <".$to.">\r\n"
	."Reply-To: ".$to."\r\n"
	."X-Mailer: PHP/" . phpversion();
    
    $recaptcha=$_POST['g-recaptcha-response'];
	if(!empty($recaptcha)){
		$google_url="https://www.google.com/recaptcha/api/siteverify";
		$secret='6LfOJLsUAAAAAPCXGQmqNjIFSOAQTUBDooXrJsJg';
		$ip=$_SERVER['REMOTE_ADDR'];
		$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
		$res=getCurlData($url);
        $res= json_decode($res, true);
        
        if($res['success']){
			$mail = mail($to, $subject, $message, $headers);
				if($mail)
					echo 'Ваша заявка уже летит к нам';
				else 
					echo '<div class="notification_error">Что-то пошло не так, попробуйте позже.</div>';
		}
		else{
			echo 'Пройдите спам проверку!';
		}
	}
	else{
		echo 'Пройдите спам проверку!';
	}		
	
}
else echo "error";

function getCurlData($url){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
	$curlData = curl_exec($curl);
	curl_close($curl);
	return $curlData;
}
?>
 