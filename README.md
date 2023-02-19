# Selectel DNS SDK

Selectel DNS SDK - Библиотека для работы с DNS услугой хостера Selectel по публичному API.

## Конфигурация

Библиотека имеет конфигурационный файл использующий для стандартной работы env переменные с определенными по умолчанию данными.
Если вы подключаете пакет в рамках проекта с поддержкой enviroinment переменных, используйте переменные для определения настроек:
```dotenv
SELECTEL_DOMAIN_REPOSITORY=SelectelDnsSdk\Repositories\DomainRepository
SELECTEL_RECORD_REPOSITORY=SelectelDnsSdk\Repositories\DomainRepository
SELECTEL_DNS_CLIENT_NAME=default
SELECTEL_DNS_CLIENT_CLASS=SelectelDnsSdk\Client
SELECTELD_DNS_CLIENT_TOKEN=#Укажите API TOKEN#
```

## Менеджер

Библиотека реализует менеджера, которого требуется инициализировать для начала работы.
Пример:
```php
$manager = new \SelectelDnsSdk\Manager(require __DIR__ . '/vendor/lemax10/selectel-dns-sdk/config/config.php');
```

### Клиент

Библиотека реализует клиент для запросов к API Selectel через промежуточный класс, в основе стандартного клиента используется GuzzleHttp библиотека.
Пример:
```php
$manager->getClient()
```

### Домены

Библиотека реализует репозиторий для работы с доменами, доступ к репозиторию возможен через менеджера:
```php
$manager->getDomains()
```

Все методы репозитория работают с результативным DTO - SelectelDnsSdk\\Dtos\\Domain.

#### Получить список доменов

При работе со списками, репозиторий использует генераторы. 
Из API выгружается весь список доменов постранично с лимитом 1000 доменов за раз, таким образом при вызове метода вы получите все имеющиеся домены
```php
$domainList = $manager->getDomains()->all();
foreach($domainList as $domain) {
    echo "\n". $domain->name;
}
```

P.S> Получение списка записей домена не реализовано из соображений необходимости работы с данными через репозиторий Записей

#### Получение данных домена по названию
```php
$domain = $manager->getDomain()->findByName('example.com');
if ($domain === null) {
    die("Домен не найден");
}

echo $domain->name; // example.com
```

#### Получение данных домена по ID
```php
$domain = $manager->getDomain()->find(2);
if ($domain === null) {
    die("Домен не найден");
}

echo $domain->id; // 2
```

#### Добавить домен

Для добавления домена, необходимо воспользоваться DTO - SelectelDnsSdk\\Dtos\\DomainCreate
Пример:
```php
$domainCreateDTO = new \SelectelDnsSdk\Dtos\DomainCreate(
    name: 'example.com'
);

$domain = $manager->getDomain()->add($domainCreateDTO);
echo $domain->name; // example.com
```

#### Удалить домен
```php
$state = $manager->getDomain()->delete(2);
echo "\n". $state; // true

// or...
$domain = $manager->getDomain()->findByName('example.com');
$state = $manager->getDomain()->delete($domain);
echo "\n". $state; // true
```

## Установка

Рекомендуется установка с использованием [Composer](https://getcomposer.org/).

```bash
composer require lemax10/selectel-dns-sdk
```

## Безопасность

В случае обнаружения уязвимости в этом пакете, отправте электронное письмо по адресу vladimir@pyankov.pro. Все уязвимости безопасности будут оперативно устранены. Пожалуйста не расскрывайте уязвимости публично.

## Лицензия

Распространяется по лицензии MIT License (MIT). Please see [License File](LICENSE) for more information.
