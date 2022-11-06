## Simple PHP client for https://strapi.io 🕸️


##### ⚙️ Install
> composer require kazakevic/strapi-wrapper
##### ⚙️ Usage

* Setup Client
> $httpClient = new Client(); //Guzzle http client, but can be any suitable
>
> $strapiClient = new StrapiClient(
$httpClient,
'token',
'http://localhost:1338'
);
* GetItem
> $jsonData = $strapiClient->getItems('seo-pages', 100)
* CreateItem
> $jsonData = $strapiClient->createItem('topics', [
'data' => [
    'Title' => 'Test Title',
    'Slug' => 'test-slug',
    'seoTitle' => 'test title',
    'seoDescription' => 'test description',
    'tags' => [1, 2, 2],
    'videoCount' => 10
]
]);

##### ⚙️ Tests
> ./vendor/bin/phpunit tests
