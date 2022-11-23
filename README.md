# Настройки

#swagger-php

В bitrix/.settings.php добавить:
'routing' =>
array(
'value' => array(
'config' => array('web.php', 'api.php')
)
),

#в .htaccess удалить(закомментировать) строки:
RewriteCond %{REQUEST_FILENAME} !/bitrix/urlrewrite.php$
RewriteRule ^(.*)$ /bitrix/urlrewrite.php [L]
и вставить
RewriteCond %{REQUEST_FILENAME} !/bitrix/routing_index.php$
RewriteRule ^(.*)$ /bitrix/routing_index.php [L]

#Устанавливаем: https://github.com/webpractik/bitrixoa
1. composer require webpractik/bitrixoa
2. php ./vendor/bin/bitrixoa --bitrix-generate // Генерация (можно поставить на крон)

#Команда для генерации:
php /swagger-php/bin/openapi -o openapi.yaml local/modules/sp.tools/lib/Controller/

#JWT token
Устанавливаем
composer require firebase/php-jwt
В ините подключить DIR.'/../vendor/autoload.php',
