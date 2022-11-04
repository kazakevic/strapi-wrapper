## Simple PHP client for https://strapi.io 🕸️

##### ⚙️ Install
> composer require kazakevic/strapi-wrapper
##### ⚙️ Usage

> $httpClient = new Client();
> 
> $strapiClient = new StrapiClient(
$httpClient,
'token',
'http://localhost:1338'
);
> 
> $jsonData = $strapiClient->getItems('seo-pages')

##### ⚙️ Tests
> ./vendor/bin/phpunit tests
