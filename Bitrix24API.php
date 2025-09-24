<?php
class Bitrix24API
{
    private $webhook_url; //Где находится наш вебхук

    function __construct($webhook_url)
    {
        $this->webhook_url = rtrim($webhook_url, '/'); //запоминает вебхук
    }
    //Основная функция
    function call($method, $params = [])
    {
        $url = $this->webhook_url . '/' . $method; //Собираем полный адрес
        $curl = curl_init(); //Создаем запрос
        curl_setopt_array($curl, [ //Настраиваем параметры запроса
            CURLOPT_URL => $url, //Путь
            CURLOPT_POST => true, //Отправляем POST
            CURLOPT_RETURNTRANSFER => true, //Возврат ответа
            CURLOPT_POSTFIELDS => json_encode($params), //Декадируем в json
            CURLOPT_HTTPHEADER => [ //Верхние данные запроса 
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            CURLOPT_SSL_VERIFYPEER => false, //Отключаем проверку на ssl
            CURLOPT_TIMEOUT => 30, //Ожидаение 30 секунд
        ]);
        $response = curl_exec($curl); //Храним ответ
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($http_code !== 200) {
            throw new Exception("HTTP Error: " . $http_code);
        }
        $result = json_decode($response, true);
        if (isset($result['error'])) {
            throw new Exception("API Error: " . $result['error_description']);
        }
        return $result;
    }
    public function batch($calls)
    {
        return $this->call('batch', ['halt' => 0, 'cmd' => $calls]);
    }
    
}