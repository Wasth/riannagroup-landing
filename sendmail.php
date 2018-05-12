<?php
$from = "lp@opora-rg.ru";
$to = "riasta@yandex.ru";
$subject = "Заявка";
$message = "Имя - ".(isset($_POST['name'])?$_POST['name']."\n":"не введено\n"); //Текст письма
$message .= "Телефон - ".(isset($_POST['phone'])?$_POST['phone']."\n":"не введено\n"); //Текст письма
$message .= "Эл. почта - ".(isset($_POST['email'])?$_POST['email']."\n":"не введено\n"); //Текст письма
$message .= "Текст заказа - ".(isset($_POST['ordertext'])?$_POST['ordertext']."\n":"не введено\n"); //Текст письма

function sendMailAttachment($mailTo, $From, $subject_text, $message){

    $to = $mailTo;

    $EOL = "\r\n"; // ограничитель строк, некоторые почтовые сервера требуют \n - подобрать опытным путём
    $boundary     = "--".md5(uniqid(time()));  // любая строка, которой не будет ниже в потоке данных.

    $subject= '=?utf-8?B?' . base64_encode($subject_text) . '?=';

    $headers    = "MIME-Version: 1.0;$EOL";
    $headers   .= "Content-Type: multipart/mixed; boundary=\"$boundary\"$EOL";
    $headers   .= "From: $From\nReply-To: $From\n";

    $multipart  = "--$boundary$EOL";
    $multipart .= "Content-Type: text/html; charset=utf-8$EOL";
    $multipart .= "Content-Transfer-Encoding: base64$EOL";
    $multipart .= $EOL; // раздел между заголовками и телом html-части
    $multipart .= chunk_split(base64_encode($message));


    foreach($_FILES["order"]["name"] as $key => $value){
        $filename = $_FILES["order"]["tmp_name"][$key];
        $file = fopen($filename, "rb");
        $data = fread($file,  filesize( $filename ) );
        fclose($file);
        $NameFile = $_FILES["order"]["name"][$key]; // в этой переменной надо сформировать имя файла (без всякого пути);
        $File = $data;
        $multipart .=  "$EOL--$boundary$EOL";
        $multipart .= "Content-Type: application/octet-stream; name=\"$NameFile\"$EOL";
        $multipart .= "Content-Transfer-Encoding: base64$EOL";
        $multipart .= "Content-Disposition: attachment; filename=\"$NameFile\"$EOL";
        $multipart .= $EOL; // раздел между заголовками и телом прикрепленного файла
        $multipart .= chunk_split(base64_encode($File));

    }

    $multipart .= "$EOL--$boundary--$EOL";

    if(!mail($to, $subject, $multipart, $headers)){
        echo 'Письмо не отправлено';
    } //Отправляем письмо
    else{
        echo 'Письмо отправлено';
    }

}
sendMailAttachment($to,$from,$subject,$message);
//$filename = "form.txt"; //Имя файла для прикрепления
//$to = "riasta@yandex.ru"; //Кому
//$from = "lp@opora-rg.ru"; //От кого
//$subject = "Заявка"; //Тема
//$message = "\n"; //Текст письма
//$message .= "Имя - ".(isset($_POST['name'])?$_POST['name']."\n":"не введено\n"); //Текст письма
//$message .= "Телефон - ".(isset($_POST['phone'])?$_POST['phone']."\n":"не введено\n"); //Текст письма
//$message .= "Эл. почта - ".(isset($_POST['email'])?$_POST['email']."\n":"не введено\n"); //Текст письма
//$message .= "Текст заказа - ".(isset($_POST['ordertext'])?$_POST['ordertext']."\n":"не введено\n"); //Текст письма
//$boundary = "---"; //Разделитель
///* Заголовки */
//$headers = "From: $from\nReply-To: $from\n";
//$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
//$body = "--$boundary\n";
///* Присоединяем текстовое сообщение */
//$body .= "Content-type: text/html; charset='utf-8'\n";
//$body .= "Content-Transfer-Encoding: quoted-printablenn";
////$body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($filename)."?=\n\n";
//$body .= $message."\n";
////$body .= "--$boundary\n";
////var_dump($_FILES);
//if(!empty($_FILES['order']['name'])) {
//    $file = fopen($_FILES['order']['tmp_name'], "r"); //Открываем файл
//    $text = fread($file, filesize($_FILES['order']['tmp_name'])); //Считываем весь файл
//    fclose($file); //Закрываем файл
//    /* Добавляем тип содержимого, кодируем текст файла и добавляем в тело письма */
//    $body .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode($_FILES['order']['name'])."?=\n";
//    $body .= "Content-Transfer-Encoding: base64\n";
//    $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($_FILES['order']['name'])."?=\n\n";
//    $body .= chunk_split(base64_encode($text))."\n";
////    $body .= "--$boundary\n";
//}
//if(!empty($_FILES['rekv']['name'])) {
//    $file = fopen($_FILES['rekv']['tmp_name'], "r"); //Открываем файл
//    $text = fread($file, filesize($_FILES['rekv']['tmp_name'])); //Считываем весь файл
//    fclose($file); //Закрываем файл
//    /* Добавляем тип содержимого, кодируем текст файла и добавляем в тело письма */
//    $body .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode($_FILES['rekv']['name'])."?=\n";
//    $body .= "Content-Transfer-Encoding: base64\n";
//    $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($_FILES['rekv']['name'])."?=\n\n";
//    $body .= chunk_split(base64_encode($text))."\n";
////    $body .= "--$boundary\n";
//}
//$body .= "---".$boundary ."--\n";
//mail($to, $subject, $body, $headers); //Отправляем письмо
//header('Location: index.html');