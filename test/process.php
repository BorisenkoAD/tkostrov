<?php
#!/usr/bin/php -q 
  // открываем сессию
  session_start();
  		$recepient = "info@tkostrov.spb.ru";
		$sitename = "ОСТРОВ на Индустриальном 19";

  // переменная в которую будем сохранять результат работы
  $data['result']='error';

  // ваш секретный ключ
  $secret = '6LfVfRQUAAAAAOXtGuMSkVcjuiao1NEabTaDmN-K';

  // функция для проверки длины строки
  function validStringLength($string,$min,$max) {
    $length = mb_strlen($string,'UTF-8');
    if (($length<$min) || ($length>$max)) {
      return false;
    }
    else {
      return true;
    }
  }

  // если данные были отправлены методом POST, то...
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data['result']='success';

    //получить имя, которое ввёл пользователь
    if (isset($_POST['name'])) {
      $name = $_POST['name'];
      if (!validStringLength($name,2,30)) {
        $data['name']='Поля имя содержит недопустимое количество символов.';
        $data['result']='error';
      }
    } else {
      $data['result']='error';
    }
    //получить email, которое ввёл пользователь
    if (isset($_POST['email'])) {
      $email = $_POST['email'];
      if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $data['email']='Поле email введено неправильно';
        $data['result']='error';
      }
    } else {
      $data['result']='error';
    }
    //получить сообщение, которое ввёл пользователь
    if (isset($_POST['message'])) {
      $message = $_POST['message'];
      if (!validStringLength($message,20,500)) {
        $data['message']='Поле сообщение содержит недопустимое количество символов.';
        $data['result']='error';
      }
    } else {
      $data['result']='error';
    }
    //получить телефон, который ввёл пользователь
    if (isset($_POST['phone'])) {
      $phone = $_POST['phone'];
      if (empty($phone)) {
        $data['result']='error';
      }
    } else {
      $data['result']='error';
    }
    //получить адрес сайта, который ввёл пользователь
    if (isset($_POST['siteurl'])) {
      $siteurl = $_POST['siteurl'];
      if (empty($siteurl)) {
        $data['result']='error';
      }
    } else {
      $data['result']='error';
    }

    // если не существует ни одной ошибки, то прододжаем...
    if ($data['result']=='success') {
      // однократное включение файла autoload.php (клиентская библиотека reCAPTCHA PHP)
      require_once (dirname(__FILE__).'/recaptcha/autoload.php');
      // если в массиве $_POST существует ключ g-recaptcha-response, то...
      if (isset($_POST['g-recaptcha-response'])) {
        // создать экземпляр службы recaptcha, используя секретный ключ
        $recaptcha = new \ReCaptcha\ReCaptcha($secret);
        // получить результат проверки кода recaptcha
        $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        // если результат положительный, то...
        if (!$resp->isSuccess()){
          // действия, если код captcha не прошёл проверку
          $errors = $resp->getErrorCodes();
          $data['error-captcha']=$errors;
          $data['msg']='Код капчи не прошёл проверку на сервере';
          $data['result']='error';
        }
      } else {
        $data['result']='error';
      }
    }
  } else {
    //ошибка, запрос к странице осуществлён не методом POST
    $data['result']='error';
  }

  // дальнейшие действия (ошибок не обнаружено)
  if ($data['result']=='success') {
    //1. Сохрание формы в файл
    $output = "---------------------------------" . "\n";
    $output .= date("d-m-Y H:i:s") . "\n";
    $output .= "Имя пользователя: " . $name . "\n";
    $output .= "Адрес email: " . $email . "\n";
    $output .= "Номер телефона: " . $phone . "\n";
    $output .= "Адрес сайта: " . $siteurl . "\n";
    $output .= "Сообщение: " . "\n" . $message . "\n";
    if (file_put_contents(dirname(__FILE__).'/message.txt', $output, FILE_APPEND | LOCK_EX)) {
      $data['result']='success';
    } else {
      $data['result']='error';
    }

    //2. Отправляем на почту
		$pagetitle = "Новый feedback с сайта \"$sitename\"";
		$mes = "Имя: $name \nТелефон: $phone \nEmail: $email \nТекст: $message";
		$head="Content-type:text/plain; \n\t charset=utf-8;"; 
		mail($recepient, $pagetitle, $mes, $head);

  }

  echo json_encode($data);

?>
