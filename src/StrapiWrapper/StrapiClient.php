<?php

declare(strict_types=1);

namespace Kazakevic\StrapiWrapper;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

class StrapiClient
{
    private ClientInterface $client;
    private string $token;
    private string $baseUrl;

    public function __construct(ClientInterface $client, string $authToken, string $baseUrl)
    {
        $this->client = $client;
        $this->token = $authToken;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $itemIdentifier
     * @return string
     * @throws ClientExceptionInterface
     */
    public function getItems(string $itemIdentifier): string
    {
        $uri = (new StrapiUriBuilder($this->baseUrl))->forItems($itemIdentifier)->withMedia()->getUri();
        $request = new Request(
            method: 'GET',
            uri: $uri,
            headers: $this->getHeaders()
        );

        $response = $this->client->sendRequest($request);

        return $response->getBody()->getContents();
    }

    public function getItem(string $itemIdentifier, int $id): string
    {
        $uri = (new StrapiUriBuilder($this->baseUrl))->forItem($itemIdentifier, $id)->withMedia()->getUri();

        $request = new Request(
            method: 'GET',
            uri: $uri,
            headers: $this->getHeaders()
        );

        $response = $this->client->sendRequest($request);

        return $response->getBody()->getContents();
    }

    private function getUriString(): string
    {
        return "{$this->baseUrl}/api/";
    }

    /**
     * @return array<string>
     */
    private function getHeaders(): array
    {
        return [
            'Authorization' => "Bearer {$this->token}"
        ];
    }
}
