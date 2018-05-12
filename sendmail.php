<?php
//$filename = "form.txt"; //Имя файла для прикрепления
$to = "sales@opora-rg.ru"; //Кому
$from = "lp@opora-rg.ru"; //От кого
$subject = "Заявка"; //Тема
$message = "\n"; //Текст письма
$message .= "Имя - ".(isset($_POST['name'])?$_POST['name']."\n":"не введено\n"); //Текст письма
$message .= "Телефон - ".(isset($_POST['phone'])?$_POST['phone']."\n":"не введено\n"); //Текст письма
$message .= "Эл. почта - ".(isset($_POST['email'])?$_POST['email']."\n":"не введено\n"); //Текст письма
$message .= "Текст заказа - ".(isset($_POST['ordertext'])?$_POST['ordertext']."\n":"не введено\n"); //Текст письма
$boundary = "---"; //Разделитель
/* Заголовки */
$headers = "From: $from\nReply-To: $from\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
$body = "--$boundary\n";
/* Присоединяем текстовое сообщение */
$body .= "Content-type: text/html; charset='utf-8'\n";
$body .= "Content-Transfer-Encoding: quoted-printablenn";
//$body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($filename)."?=\n\n";
$body .= $message."\n";
$body .= "--$boundary\n";
//var_dump($_FILES);
if(isset($_FILES['order'])) {
    $file = fopen($_FILES['order']['tmp_name'], "r"); //Открываем файл
    $text = fread($file, filesize($_FILES['order']['tmp_name'])); //Считываем весь файл
    fclose($file); //Закрываем файл
    /* Добавляем тип содержимого, кодируем текст файла и добавляем в тело письма */
    $body .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode($_FILES['order']['name'])."?=\n";
    $body .= "Content-Transfer-Encoding: base64\n";
    $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($_FILES['order']['name'])."?=\n\n";
    $body .= chunk_split(base64_encode($text))."\n";
}
if(isset($_FILES['rekv'])) {
    $file = fopen($_FILES['rekv']['tmp_name'], "r"); //Открываем файл
    $text = fread($file, filesize($_FILES['rekv']['tmp_name'])); //Считываем весь файл
    fclose($file); //Закрываем файл
    /* Добавляем тип содержимого, кодируем текст файла и добавляем в тело письма */
    $body .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode($_FILES['order']['name'])."?=\n";
    $body .= "Content-Transfer-Encoding: base64\n";
    $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($_FILES['order']['name'])."?=\n\n";
    $body .= chunk_split(base64_encode($text))."\n";
}
$body .= "--".$boundary ."--\n";
mail($to, $subject, $body, $headers); //Отправляем письмо
header('Location: index.html');