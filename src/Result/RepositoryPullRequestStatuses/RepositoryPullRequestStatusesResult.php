<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubFetcher\Result\GitHubFetcherResult;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\PullRequestStatusesPayload;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\PullRequestStatusPayload;

/**
 * @see RepositoryPullRequestStatusesResultSpec
 * @see RepositoryPullRequestStatusesResultTest
 */
class RepositoryPullRequestStatusesResult implements GitHubFetcherResult
{
    /** @var RepoFullName */
    private $repoFullName;

    /** @var InstallationId */
    private $installationId;

    /** @var UserId */
    private $userId;

    /** @var PullRequestStatusesPayload */
    private $payload;

    public function __construct(
        RepoFullName $repoFullName,
        InstallationId $installationId,
        UserId $userId,
        PullRequestStatusesPayload $payload
    ) {
        $this->repoFullName   = $repoFullName;
        $this->installationId = $installationId;
        $this->userId         = $userId;
        $this->payload        = $payload;
    }

    public function getRepoFullName(): RepoFullName
    {
        return $this->repoFullName;
    }

    public function getInstallationId(): InstallationId
    {
        return $this->installationId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return array|PullRequestStatusPayload[]
     */
    public function getPullRequestStatusesAsArray(): array
    {
        return $this->payload->toArray();
    }

    public function getPayload(): PullRequestStatusesPayload
    {
        return $this->payload;
    }

    public function getCredentials(): InstallationCredentials
    {
        return new InstallationCredentials($this->installationId, $this->userId);
    }

    public function serialize(): array
    {
        return [
            'repoFullName'   => $this->repoFullName->serialize(),
            'installationId' => $this->installationId->serialize(),
            'userId'         => $this->userId->serialize(),
            'payloadType'    => 'GitHubPullRequestsStatuses',
            'payload'        => $this->payload->serialize(),
        ];
    }

    public static function deserialize(array $data): self
    {
        return new self(
            RepoFullName::deserialize($data['repoFullName']),
            InstallationId::deserialize($data['installationId']),
            UserId::deserialize($data['userId']),
            PullRequestStatusesPayload::deserialize($data['payload'])
        );
    }
}
