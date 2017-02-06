<?php
#!/usr/bin/php -q 
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
?>