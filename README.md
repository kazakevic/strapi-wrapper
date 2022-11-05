## Simple PHP client for https://strapi.io 🕸️


##### ⚙️ Install
> composer require kazakevic/strapi-wrapper
##### ⚙️ Usage

> $httpClient = new Client(); //Guzzle http client, but can be any suitable
> 
> $strapiClient = new StrapiClient(
$httpClient,
'token',
'http://localhost:1338'
);
> 
> $jsonData = $strapiClient->getItems('seo-pages', 100)

##### ⚙️ Tests
> ./vendor/bin/phpunit tests
