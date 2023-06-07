<?php

namespace App\Services\User;

use App\Services\Database\DatabaseService;

class UserService
{
    private $user_data;
    private $bot_username;

    public function __construct(array $user_data, string $bot_username)
    {
        $this->user_data = $user_data;
        $this->bot_username = $bot_username;
    }

    public function checkUser()
    {
        try {
            $callback_type = isset($this->user_data['callback_query']) ? 'callback_query' : 'message';
            $fetchedUser = DatabaseService::findOne('users', 'user_id=?', array($this->user_data[$callback_type]['from']['id']));

            if ($fetchedUser) {
                $user = new UserDTO(
                    $fetchedUser->user_id,
                    $fetchedUser->username ?? '',
                    $fetchedUser->first_name ?? '',
                    $fetchedUser->is_bot
                );
            } else {
                $user = new UserDTO(
                    $this->user_data['message']['from']['id'],
                    $this->user_data['message']['from']['username'] ?? '',
                    $this->user_data['message']['from']['first_name'] ?? '',
                    $this->user_data['message']['from']['is_bot'],
                );

                if (!$this->create($user)) {
                    return false;
                }
            }

            return $user;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function create(UserDTO $user)
    {
        $create = DatabaseService::dispense('users');
        $create->user_id = $user->user_id;
        $create->username = $user->username;
        $create->first_name = $user->first_name;
        $create->is_bot = $user->is_bot;
        $create->created_at = date('Y-m-d H:i:s');
        $id = DatabaseService::store($create);
        return $id ?? false;
    }
}