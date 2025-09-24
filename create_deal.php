<?php
require_once('Bitrix24API.php');
//Прокидывание в объект вебхука
$api_client_list = new Bitrix24API('https://b24-nqu9t2.bitrix24.ru/rest/1/mv9b5p37b5x87wj8/');

try {
    $user = $api_client_list->call('crm.contact.list', [
        'select' => ['ID'],
    ]);
} catch (Exception $e) {
    echo $e->getMessage();
}

$contactIds = array_column($user['result'], 'ID');


$api_deal_add = new Bitrix24API('https://b24-nqu9t2.bitrix24.ru/rest/1/4w1ut9fcu1sgiz65/');

$deal_data = [];

for ($i = 1; $i <= 15; $i++) {

    $randomContactId = $contactIds[array_rand($contactIds, 1)];

    $deal_data = [
        'TITLE' => "Продажа оборудования $i",
        'TYPE_ID' => 'SALE',
        'STAGE_ID' => 'NEW',
        'CONTACT_ID' => $randomContactId,
        'OPPORTUNITY' => 150000,
        'CURRENCY_ID' => 'RUB',
        'PROBABILITY' => 50,
        'BEGINDATE' => date('Y-m-d'),
        'CLOSEDATE' => date('Y-m-d', strtotime('+30 days')),
        'ASSIGNED_BY_ID' => 1,
        'COMMENTS' => 'Сделка создана через API',
    ];

    try {
        $result = $api_deal_add->call('crm.deal.add', ['fields' => $deal_data]);
        echo 'Deal added id:' . $result['result'];
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
