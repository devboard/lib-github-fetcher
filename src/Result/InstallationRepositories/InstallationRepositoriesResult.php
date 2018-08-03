<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\InstallationRepositories;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubFetcher\Result\GitHubFetcherResult;
use DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload\GitHubRepositoriesPayload;
use DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload\GitHubRepositoryPayload;

/**
 * @see InstallationRepositoriesResultSpec
 */
class InstallationRepositoriesResult implements GitHubFetcherResult
{
    /** @var InstallationId */
    private $installationId;

    /** @var UserId */
    private $userId;

    /** @var GitHubRepositoriesPayload */
    private $payload;

    public function __construct(InstallationId $installationId, UserId $userId, GitHubRepositoriesPayload $payload)
    {
        $this->installationId = $installationId;
        $this->userId         = $userId;
        $this->payload        = $payload;
    }

    public function getInstallationId(): InstallationId
    {
        return $this->installationId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getPayload(): GitHubRepositoriesPayload
    {
        return $this->payload;
    }

    /**
     * @return array|GitHubRepositoryPayload[]
     */
    public function getRepositoriesAsArray(): array
    {
        return $this->payload->toArray();
    }

    public function serialize(): array
    {
        return [
            'installationId' => $this->installationId->serialize(),
            'userId'         => $this->userId->serialize(),
            'payloadType'    => 'InstallationRepositoriesResult',
            'payload'        => $this->payload->serialize(),
        ];
    }

    public static function deserialize(array $data): self
    {
        return new self(
            InstallationId::deserialize($data['installationId']),
            UserId::deserialize($data['userId']),
            GitHubRepositoriesPayload::deserialize($data['payload'])
        );
    }
}
