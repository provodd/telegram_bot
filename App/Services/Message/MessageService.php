<?php

namespace App\Services\Message;

use App\Services\Database\DatabaseService;
use App\Services\Keyboard\KeyboardDTO;
use App\Services\Log\LogService;

class MessageService
{
    const PARSE_HTML = 'HTML';
    const PARSE_MARKDOWN = 'Markdown';

    private $chat_id;
    private $support_id;

    public function __construct($chat_id)
    {
        $this->chat_id = $chat_id;
        $config = require $_SERVER['DOCUMENT_ROOT'] . '/tg/config.php';
        $this->support_id = $config['support_id'];
    }

    public function price()
    {

        $msg = "<b>Прайс-лист</b>";
        $msg .= "\n";
        $msg .= "1. Демо  - 100р\n";
        $msg .= "2. Фул  - 350р\n";
        $msg .= "\n";
        $msg .= "\n";

        return [
            'chat_id' => $this->chat_id,
            'text'    => $msg,
            'parse_mode' => self::PARSE_HTML,
            'reply_markup' => KeyboardDTO::priceKeyboard
        ];
    }

    public function profile($user): array
    {
        $user_name = $user->first_name ?? $user->username;

        $msg = 'Информация о <a href="tg://user?id=' . $user->user_id . '">' . $user_name . '</a>';
        $msg .= "\n";
        $msg .= "🆔 ID: {$user->user_id} \n";
        $msg .= "💰 Баланс: 0 руб.\n";
        $msg .= "\n";
        $msg .= "Всего потрачено: 0 руб.\n";
        $msg .= "Всего пополнено: 0 руб.";

        return [
            'chat_id' => $this->chat_id,
            'text'    => $msg,
            'parse_mode' => self::PARSE_HTML
        ];
    }

    public function support(): array
    {
        $msg = 'Связь с администратором <a href="tg://user?id=' . $this->support_id . '">Саппорт</a>';
        return [
            'chat_id' => $this->chat_id,
            'text'    => $msg,
            'parse_mode' => self::PARSE_HTML
        ];
    }

    public function buy(): array
    {
        $msg = 'Купить  <a href="https://my.qiwi.com/Ruslan-NSlWt9EywG">по ссылке</a>';
        return [
            'chat_id' => $this->chat_id,
            'text'    => $msg,
            'parse_mode' => self::PARSE_HTML
        ];
    }
}
