<?php

/**
 * This file is part of the PHP Telegram Bot example-bot package.
 * https://github.com/php-telegram-bot/example-bot/
 *
 * (c) PHP Telegram Bot Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This file is used to set the webhook.
 */

// Load composer
require_once __DIR__ . '/vendor/autoload.php';

// Load all configuration options
/** @var array $config */
$config = require __DIR__ . '/config.php';

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($config['api_key'], $config['bot_username']);

// Define the list of allowed Update types manually:
    $allowed_updates = [
        \Longman\TelegramBot\Entities\Update::TYPE_MESSAGE,
        \Longman\TelegramBot\Entities\Update::TYPE_CHANNEL_POST,
        \Longman\TelegramBot\Entities\Update::TYPE_CALLBACK_QUERY
    ];

// When handling the getUpdates method.
    $telegram->handleGetUpdates(['allowed_updates' => $allowed_updates]);
    // Set the webhook
    $result = $telegram->setWebhook($config['webhook']['url'], ['allowed_updates' => $allowed_updates]);

    // To use a self-signed certificate, use this line instead
    // $result = $telegram->setWebhook($config['webhook']['url'], ['certificate' => $config['webhook']['certificate']]);

    if ($result->isOk()) {
        echo $result->getDescription();
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    echo $e->getMessage();
}
