<?php
namespace App\Services\User;

class UserDTO {
    private $user_id;
    private $username;
    private $first_name;
    private $is_bot;

    public function __construct(int $user_id, string $username, string $first_name, bool $is_bot) {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->first_name = $first_name;
        $this->is_bot = $is_bot;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }
}