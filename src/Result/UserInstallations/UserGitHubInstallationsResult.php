<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\UserInstallations;

use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubFetcher\Result\GitHubFetcherResult;

/**
 * @see UserGitHubInstallationsResultSpec
 */
class UserGitHubInstallationsResult implements GitHubFetcherResult
{
    /** @var UserId */
    private $userId;

    /** @var GitHubInstallationResults */
    private $payload;

    public function __construct(UserId $userId, GitHubInstallationResults $payload)
    {
        $this->userId  = $userId;
        $this->payload = $payload;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getPayload(): GitHubInstallationResults
    {
        return $this->payload;
    }

    /**
     * @return array|GitHubInstallationResult[]
     */
    public function getInstallationResultsAsArray(): array
    {
        return $this->payload->toArray();
    }

    public function serialize(): array
    {
        return [
            'userId'      => $this->userId->serialize(),
            'payloadType' => 'GitHubInstallationResults',
            'payload'     => $this->payload->serialize(),
        ];
    }

    public static function deserialize(array $data): self
    {
        return new self(
            UserId::deserialize($data['userId']), GitHubInstallationResults::deserialize($data['payload'])
        );
    }
}
