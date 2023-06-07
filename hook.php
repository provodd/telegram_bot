<?php
ini_set("error_log", "./tg.log");
require_once __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/config.php';

use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use App\Services\User\UserService;
use App\Services\Log\LogService;
use App\Services\Database\DatabaseService;
use App\Services\Message\MessageService;

try {
    $telegram = new Telegram($config['api_key'], $config['bot_username']);
    $telegram->enableMySql($config['mysql']);

    //redbean и pdo
    DatabaseService::instance();

    $telegram->enableAdmins($config['admins']);
    $telegram->addCommandsPaths($config['commands']['paths']);
    $telegram->enableLimiter($config['limiter']);

    $post = json_decode(Request::getInput(), true);

    $update = new Update($post, $config['bot_username']);
    $message = $update->getCallbackQuery() !== null ? $update->getCallbackQuery()->getMessage() : $update->getMessage();
    $text = $update->getCallbackQuery() !== null ? $update->getCallbackQuery()->getData() : $message->getText();
    $chat_id = $message->getChat()->getId();

    //просто для себя
    $logService = new LogService($update);
    $logService->add();

    //кастомная таблица пользователей
    $userService = new UserService($post, $config['bot_username']);
    $user = $userService->checkUser();

    $messageService = new MessageService($chat_id);

    $x = $telegram->handle();

    //можно делать через команды $telegram->runCommands([/start, ...]);
    //в дальнейшем разобраться как и почему срабатывают команды в папке commands
    switch ($text) {
        case 'buy_1':
        case 'buy_2':
            return Request::sendMessage($messageService->buy());
        case '/payment':
        case 'Пополнить баланс':
            $data = [];
            return Request::sendMessage(array_merge([
                'chat_id' => $chat_id,
                'text' => 'BTC или картой?',
            ], $data));
        case '/profile':
        case 'Профиль':
            $data = [];
            return Request::sendMessage($messageService->profile($user));
        case '/support':
        case 'Поддержка':
            $data = [];
            return Request::sendMessage($messageService->support());
        case '/pricelist':
        case 'Прайс-лист':
            $data = [];
            return Request::sendMessage($messageService->price());
        default:
            break;

    }

} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    LogService::test($e->getMessage());
}
