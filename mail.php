<?php
$recepient = "paz001@yandex.ru";
$sitename = "ОСТРОВ на Индустриальном 19";

$name = trim($_POST["exampleInputName1"]);
$phone = trim($_POST["exampleInputTel1"]);
$email = trim($_POST["exampleInputEmail1"]);
$text = trim($_POST["exampleInputTextArea1"]);

$pagetitle = "Новая заявка с сайта \"$sitename\"";
$message = "Имя: $name \nТелефон: $phone \nEmail: $email \nТекст: $text";
mail($recepient, $pagetitle, $message, "Content-type: text/plain; charset=\"utf-8\"\n From: $recepient");
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

?>