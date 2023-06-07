<?php

namespace App\Services\Keyboard;

class KeyboardDTO
{

    const priceKeyboard = [
        'inline_keyboard' => [
            [
                [
                    'text' => 'Купить 1',
                    'callback_data' => 'buy_1'
                ],
                [
                    'text' => 'Купить 2',
                    'callback_data' => 'buy_2'
                ]
            ]
        ]
    ];

    const customKeyboard = array(
        array(
            array(
                'text' => 'Пополнить баланс',
                'url' => 'https://ruslan-dev.ru/',
            ),
            array(
                'text' => 'Прайс-лист',
                'callback_data' => '/start',
            ),
            array(
                'text' => 'Поддержка',
                'callback_data' => 'YOUR BUTTON URL',
            ),
            array(
                'text' => 'Профиль',
                'callback_data' => 'YOUR BUTTON URL',
            ),
        ));


    public static function getPriceKeyboard(): array
    {
        return self::priceKeyboard;
    }
}