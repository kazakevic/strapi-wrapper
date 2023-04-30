## Simple PHP client for https://strapi.io 🕸️

##### ⚙️ Install

```bash
composer require kazakevic/strapi-wrapper
```
##### ⚙️ Usage

* Setup Client 
  * You can use any HTTP client that implements `Psr\Http\Client\ClientInterface` 
  
```php
$httpClient = new Client(); //Guzzle http client, but can be any suitable

$strapiClient = new StrapiClient(
$httpClient,
'token',
'http://localhost:1338'
);
```

* getItems

```php
$response = $strapiClient->getItems(
    'item-identifier',
    new PageFilter(100),
    new SortFilter('id', SortOrder::DESC)
);
```

* getItemById

```php
$jsonData = $strapiClient->getItemById('seo-pages', 534546)
```

* getItemsBy
```php
    $response = $strapiClient->getItemsBy(
        'item-identifier',
        'fieldName',
        'fieldValue',
        new PageFilter(100),
        new SortFilter('id', SortOrder::DESC)
    );
```

* createItem

```php
$jsonData = $strapiClient->createItem('topics', [

'data' => [
    'Title' => 'Test Title',
    'Slug' => 'test-slug',
    'seoTitle' => 'test title',
    'seoDescription' => 'test description',
    'tags' => [1, 2, 2],
    'videoCount' => 10
]
]);
```
* updateItem

```php
$jsonData = $strapiClient->updateItem('topics', 1, [

'data' => [
    'Title' => 'Test Title',
    'Slug' => 'test-slug',
    'seoTitle' => 'test title',
    'seoDescription' => 'test description',
    'tags' => [1, 2, 2],
    'videoCount' => 10
]
]);
```

##### ⚙️ Tests

```bash
./vendor/bin/phpunit tests
