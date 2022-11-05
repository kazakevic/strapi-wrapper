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
     * @param int $limit
     * @return string
     * @throws ClientExceptionInterface
     */
    public function getItems(string $itemIdentifier, int $limit): string
    {
        $uri = (new StrapiUriBuilder($this->baseUrl))->forItems($itemIdentifier)
            ->withMedia()
            ->withOffsetAndLimit($limit)
            ->getUri();

        $response = $this->client->sendRequest($this->getRequest($uri));

        return $response->getBody()->getContents();
    }

    public function getItemById(string $itemIdentifier, int $id): string
    {
        $uri = (new StrapiUriBuilder($this->baseUrl))
            ->forItem($itemIdentifier, $id)
            ->withMedia()
            ->getUri();

        $response = $this->client->sendRequest($this->getRequest($uri));

        return $response->getBody()->getContents();
    }

    public function getItemsBy(
        string $itemIdentifier,
        string $byFieldName,
        string $byFieldValue,
        int $limit = 50
    ): string {
        $uri = (new StrapiUriBuilder($this->baseUrl))
            ->forItems($itemIdentifier)
            ->withFilter($byFieldName, $byFieldValue)
            ->withOffsetAndLimit($limit)
            ->withMedia()
            ->getUri();

        $response = $this->client->sendRequest($this->getRequest($uri));

        return $response->getBody()->getContents();
    }

    private function getRequest(string $uri) : Request
    {
        return new Request(
            method: 'GET',
            uri: $uri,
            headers: $this->getHeaders()
        );
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
