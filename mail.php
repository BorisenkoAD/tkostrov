<?php
#!/usr/bin/php -q 
// ваш секретный ключ
$secret = '6LfVfRQUAAAAAOXtGuMSkVcjuiao1NEabTaDmN-K';
// однократное включение файла autoload.php (клиентская библиотека reCAPTCHA PHP)
require_once (dirname(__FILE__).'/recaptcha/src/autoload.php');
// если в массиве $_POST существует ключ g-recaptcha-response, то...
if (isset($_POST['g-recaptcha-response'])) {
  // создать экземпляр службы recaptcha, используя секретный ключ
  $recaptcha = new \ReCaptcha\ReCaptcha($secret);
  // получить результат проверки кода recaptcha
  $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
  // если результат положительный, то...
  if ($resp->isSuccess()){
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
  } else {
    // иначе передать ошибку
    $errors = $resp->getErrorCodes();
    $data['error-captcha']=$errors;
    $data['msg']='Код капчи не прошёл проверку на сервере';
    $data['result']='error';
  }
 
} else {
  //ошибка, не существует ассоциативный массив $_POST["send-message"]
  $data['result']='error';
}


?>