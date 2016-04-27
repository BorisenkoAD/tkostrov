<?php
$recepient = "paz001@yandex.ru";
$sitename = "ТК ОСТРОВ";

$name = trim($_POST["exampleInputName1"]);
$phone = trim($_POST["exampleInputTel1"]);
$text = trim($_POST["exampleInputTextArea1"]);

$pagetitle = "Новая заявка с сайта \"$sitename\"";
$message = "Имя: $name \nТелефон: $phone \nТекст: $text";
mail($recepient, $pagetitle, $message, "Content-type: text/plain; charset=\"utf-8\"\n From: $recepient");
if (!headers_sent($filename, $linenum)) {
    header('Location: http://tkostrov.spb.ru/test/index.html');
    exit;
} else {
    echo "Заголовки уже отправлены в $filename на строке $linenum\n" .
          "Редирект невозможен, пожалуйста нажмите <a " .
          "href=\"http://www.istria-spb.ru\">Здесь</a> самостоятельно\n";
    exit;
}
}

?>