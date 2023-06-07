<?php

namespace App\Services\Log;

use App\Services\Database\DatabaseService;
use Longman\TelegramBot\DB;

class LogService
{
    private $table;
    private $post;
    private $update;

    public function __construct($update)
    {
        $this->update = $update;
        $this->post = json_decode(file_get_contents('php://input'), true);
        $this->table = 'logs';
    }

    public function add()
    {

        if ($this->update->getCallbackQuery() !== null) {
            $message = $this->update->getCallbackQuery();
            $callback_type = 'callback_query';
            $data = $message->message;
            $from = $message->from;
        } else {
            $message = $this->update->getMessage();
            $callback_type = 'message';
            $data = $this->post['message'];
            $from = $data['from'];
        }

        $add = DatabaseService::dispense($this->table);
        $add->callback_type = $callback_type;
        $add->update_id = $this->update->raw_data['update_id'] ?? NULL;
        $add->message_id = $data['message_id'];
        $add->from = (string)$from['id'];
        $add->from_first_name = $from['first_name'];
        $add->from_username = $from['username'];
        $add->chat_id = $data['chat']['id'];
        $add->bot_username = $this->update->bot_username;
        $add->date = $data['date'];
        $add->text = $data['text'];
        $add->post_data = var_export($data, true);
        $add->callback_data = $message->raw_data['data'] ?? NULL;
        $add->created_at = date('Y-m-d H:i:s');
        return DatabaseService::store($add);
    }

    public static function test($data)
    {
        $pdo = DatabaseService::getPdo();
        $statement = $pdo->prepare("INSERT INTO test (test) VALUES (?)");
        if ($statement->execute(array(var_export($data, true)))) {
            return true;
        }
        return false;
    }
}
