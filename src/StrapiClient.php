<?php

declare(strict_types=1);

namespace Kazakevic\StrapiWrapper;

use GuzzleHttp\Psr7\Request;
use Kazakevic\StrapiWrapper\Constants\SortOrder;
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
     * @param string $sortByField
     * @param SortOrder $sortOrder
     * @return string
     * @throws ClientExceptionInterface
     */
    public function getItems(
        string $itemIdentifier,
        int $limit,
        string $sortByField,
        SortOrder $sortOrder = SortOrder::ASC
    ): string {
        $uri = (new StrapiUriBuilder($this->baseUrl))->forItems($itemIdentifier)
            ->withMedia()
            ->withOffsetAndLimit($limit)
            ->sortBy($sortByField, $sortOrder)
            ->getUri();

        $response = $this->client->sendRequest($this->getRequest($uri));

        return $response->getBody()->getContents();
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getItemById(string $itemIdentifier, int $id): string
    {
        $uri = (new StrapiUriBuilder($this->baseUrl))
            ->forItem($itemIdentifier, $id)
            ->withMedia()
            ->getUri();

        $response = $this->client->sendRequest($this->getRequest($uri));

        return $response->getBody()->getContents();
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getItemsBy(
        string $itemIdentifier,
        string $byFieldName,
        string $byFieldValue,
        string $sortByField,
        SortOrder $sortOrder = SortOrder::ASC,
        int $limit = 50
    ): string {
        $uri = (new StrapiUriBuilder($this->baseUrl))
            ->forItems($itemIdentifier)
            ->withFilter($byFieldName, $byFieldValue)
            ->withOffsetAndLimit($limit)
            ->withMedia()
            ->sortBy($sortByField, $sortOrder)
            ->getUri();

        $response = $this->client->sendRequest($this->getRequest($uri));

        return $response->getBody()->getContents();
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function createItem(string $itemIdentifier, array $data): string
    {
        $response = $this->client->sendRequest($this->getPostRequest($itemIdentifier, $data));

        return $response->getBody()->getContents();
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function updateItem(string $itemIdentifier, int $id, array $data): string
    {
        $response = $this->client->sendRequest($this->getPutRequest($itemIdentifier, $id, $data));

        return $response->getBody()->getContents();
    }

    private function getPostRequest(string $itemIdentifier, array $data): Request
    {
        return new Request(
            method: 'POST',
            uri: $this->getUriString() . $itemIdentifier,
            headers: [
                ...$this->getHeaders(),
                'Content-Type' => 'application/json'
            ],
            body: json_encode($data)
        );
    }

    private function getPutRequest(string $itemIdentifier, int $id, array $data): Request
    {
        return new Request(
            method: 'PUT',
            uri: $this->getUriString() . $itemIdentifier . '/' .$id,
            headers: [
                        ...$this->getHeaders(),
                        'Content-Type' => 'application/json'
                    ],
            body: json_encode($data)
        );
    }

    private function getRequest(string $uri): Request
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
