<?php
require_once('Bitrix24API.php');
//Прокидывание в объект вебхука
$api_client_list = new Bitrix24API('https://b24-nqu9t2.bitrix24.ru/rest/1/mv9b5p37b5x87wj8/');
$api_deal_list = new Bitrix24API('https://b24-nqu9t2.bitrix24.ru/rest/1/wclo0shu5qb3kkua/');

try {
    $user = $api_client_list->call(
        'crm.contact.list',
        [
            'select' => ['ID', 'NAME', 'SECOND_NAME', 'LAST_NAME', 'PHONE', 'EMAIL',],
        ]
    );

    if (!$user['result']) {
        echo json_encode(['error' => 'Контакты не найдены']);
        exit;
    }
    $result = [];

    foreach ($user['result'] as $contact) {
        $contact_data = [
            'user_id' => $contact['ID'],
            'Name' => $contact['NAME'],
            'Second_Name' => $contact['SECOND_NAME'],
            'Last_Name' => $contact['LAST_NAME'],
            'Сделки контакта: ' => [],
        ];
        echo 'Контакт: ' . $contact['NAME'] . " " . $contact['LAST_NAME'] . ".\n";

        $deal_list = $api_deal_list->call('crm.deal.list', [
            'filter' => ['CONTACT_ID' => $contact['ID']],
            'select' => ['ID', 'TITLE']
        ]);

        if ($deal_list['result']) {
            foreach ($deal_list['result'] as $deal) {
                $contact_data['Сделки контакта: '][] = [
                    'deal_id' => $deal['ID'],
                    'deal_title' => $deal['TITLE']
                ];
            }
        } else {
            echo json_encode(['error' => "Сделки не найдены"]);
        }
        $result[] = $contact_data;
        echo "- " . json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    }
} catch (Exception $e) {
    echo "Ошибка Api: " . $e->getMessage();
}
