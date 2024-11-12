<?php
/* 
от Tok1shu
в случае нахождения бага вы можете обратится мне на рабочую почту
konstantinka.work@gmail.com



Вы должны настроить файл config.php
После чего вы должны направить на данную страничку пользователя с GET запросом
Пример запроса https://localhost/php/pay.php?customer=Tokishu&ware=12345&coupon=LOX12&email=tok1shus@gmail.com
вот примерно так.





 */


// Берем данные
require_once("config.php"); // Путь к конфигу!
$customer = $_GET['customer']; // ник
$ware = $_GET['ware']; // ID продукта(можно найти сделав запрос по апи)
$coupon = $_GET['coupon']; // Купон на скидку
$email = $_GET['email'];
// Текст в случае ошибки.
echo "В случае если вы видите данный текст, то произошла какая-то ошибка, обратитесь к администрации.<br>Ошибка: ";
// Переменная curl
$curl = curl_init();
// делаем запрос

if ($coupon == "") {
  curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://easydonate.ru/api/v3/shop/payment/create?customer='.$customer.'&email='.$email.'&server_id='.$server_id.'&products={"'.$ware.'":1}&success_url='.$redirect_url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Shop-key: '.$api_key,
    'Cookie: __ddg1_=cpT046KlUZrZ2F3gmQs8'
  ),
));
}else{
  curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://easydonate.ru/api/v3/shop/payment/create?customer='.$customer.'&email='.$email.'&coupon='.$coupon.'&server_id='.$server_id.'&products={"'.$ware.'":1}&success_url='.$redirect_url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Shop-key: '.$api_key,
    'Cookie: __ddg1_=cpT046KlUZrZ2F3gmQs8'
  ),
));
}
  
// Вытягиваем JSON и перенаправляем на указанный URL.
$response = curl_exec($curl);
echo $response;
curl_close($curl);
$array = json_decode($response);
$array = $array->{'response'};
$array = $array->{'url'};
// Редирект
header("Location: $array");
exit();

?>


