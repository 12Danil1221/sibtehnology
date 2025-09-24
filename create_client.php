<?php
require_once('Bitrix24API.php');
//Прокидывание в объект вебхука
$api = new Bitrix24API('https://b24-nqu9t2.bitrix24.ru/rest/1/8su2am9kesopftc7/');

// Создание нового клиента
$contact_data = [
    [
        'NAME' => 'Анна',
        'SECOND_NAME' => 'Ахиярововна',
        'LAST_NAME' => 'Смирнова',
        'EMAIL' => [
            ['VALUE' => 'anna@company.ru', 'VALUE_TYPE' => 'WORK'],
        ],
        'PHONE' => [s
            ['VALUE' => '+7 (495) 123-45-67', 'VALUE_TYPE' => 'WORK'],
        ],
    ],
    [
        'NAME' => 'Петр',
        'SECOND_NAME' => 'Ахиярович',
        'LAST_NAME' => 'Сидоров',
        'EMAIL' => [['VALUE' => 'petr.sidorov@example.com', 'VALUE_TYPE' => 'WORK']],
        'PHONE' => [['VALUE' => '+7 (900) 444-55-66', 'VALUE_TYPE' => 'WORK']],
    ],
    [
        'NAME' => 'Елена',
        'SECOND_NAME' => 'Ахиярововна',
        'LAST_NAME' => 'Кузнецова',
        'EMAIL' => [], // Без email
        'PHONE' => [['VALUE' => '+7 (900) 777-88-99', 'VALUE_TYPE' => 'MOBILE']],
    ],
    [
        'NAME' => 'Мария',
        'SECOND_NAME' => 'Ахиярововна',
        'LAST_NAME' => 'Иванова',
        'EMAIL' => [['VALUE' => 'maria@example.com', 'VALUE_TYPE' => 'WORK']],
        'PHONE' => [['VALUE' => '+79993332211', 'VALUE_TYPE' => 'MOBILE']],
    ],
    [
        'NAME' => 'Алексей',
        'SECOND_NAME' => 'Ахиярович',
        'LAST_NAME' => 'Козлов',
        'EMAIL' => [], // Без email
        'PHONE' => [['VALUE' => '+79995556677', 'VALUE_TYPE' => 'MOBILE']],
    ],
];
foreach ($contact_data as $user) {
    try {
        $result = $api->call('crm.contact.add', ['fields' => $user]);
        echo "Контакт создан с ID: " . $result['result'];
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}