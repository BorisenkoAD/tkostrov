<?php
#!/usr/bin/php -q 
		$recepient = "info@tkostrov.spb.ru";
		$sitename = "ОСТРОВ на Индустриальном 19";

		$name = substr(htmlspecialchars(trim($_POST['Name'])), 0, 100);
		$email = substr(htmlspecialchars(trim($_POST['Email'])), 0, 30);
		$phone = substr(htmlspecialchars(trim($_POST['Tel'])), 0, 30);
		$text = substr(htmlspecialchars(trim($_POST['Text'])), 0, 1500);

if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
	$secret = '6LfVfRQUAAAAAOXtGuMSkVcjuiao1NEabTaDmN-K';
	$ip = $_SERVER['REMOTE_ADDR'];
	$response = $_POST['g-recaptcha-response'];
	$rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
	$arr = json_decode($rsp, TRUE);
	if($arr['success']){

    // действия, если код captcha прошёл проверку
		$recepient = "info@tkostrov.spb.ru";
		$sitename = "ОСТРОВ на Индустриальном 19";

		$name = substr(htmlspecialchars(trim($_POST['Name'])), 0, 100);
		$email = substr(htmlspecialchars(trim($_POST['Email'])), 0, 30);
		$phone = substr(htmlspecialchars(trim($_POST['Tel'])), 0, 30);
		$text = substr(htmlspecialchars(trim($_POST['Text'])), 0, 1500);

		$pagetitle = "Новый feedback с сайта \"$sitename\"";
		$message = "Имя: $name \nТелефон: $phone \nEmail: $email \nТекст: $text";
		$head="Content-type:text/plain; \n\t charset=utf-8;"; 
		mail($recepient, $pagetitle, $message, $head);
		if (!headers_sent($filename, $linenum)) {
			header('Location: http://tkostrov.spb.ru/');
			exit;
		} else {
			echo "Заголовки уже отправлены в $filename на строке $linenum\n" .
				  "Редирект невозможен, пожалуйста нажмите <a " .
				  "href=\"http://tkostrov.spb.ru/\">Здесь</a> самостоятельно\n";
			exit;
		}
	}
}
?>