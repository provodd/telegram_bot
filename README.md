# PHP Telegram Bot

Тестовый бот на основе [PHP Telegram Bot][core-github] и [PHP Telegram Example bot][example-bot]

```bash
$ git clone https://github.com/provodd/telegram_bot.git
$ composer install
```
Далее переименовываем `config.example.php` на `config.php` и заполняем
все конфигурационные данные.

- `set.php` (Установка веб-хука)
- `hook.php` (Основная логика)

Требования:

- `https` (Требование телеграма для работы с веб-хуками)
- `php` (>=7.3)
- `mysql`

[core-github]: https://github.com/php-telegram-bot/core "php-telegram-bot/core"
[example-bot]: https://github.com/php-telegram-bot/core#example-bot "php-telegram-bot/core#example-bot#"
