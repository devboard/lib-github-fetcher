<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranches;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubFetcher\Result\GitHubFetcherResult;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BranchesPayload;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BranchPayload;

/**
 * @see RepositoryBranchesResultSpec
 * @see RepositoryBranchesResultTest
 */
class RepositoryBranchesResult implements GitHubFetcherResult
{
    /** @var RepoFullName */
    private $fullName;

    /** @var InstallationId */
    private $installationId;

    /** @var UserId */
    private $userId;

    /** @var BranchesPayload */
    private $payload;

    public function __construct(
        RepoFullName $fullName, InstallationId $installationId, UserId $userId, BranchesPayload $payload
    ) {
        $this->fullName       = $fullName;
        $this->installationId = $installationId;
        $this->userId         = $userId;
        $this->payload        = $payload;
    }

    public function getRepoFullName(): RepoFullName
    {
        return $this->fullName;
    }

    public function getFullName(): RepoFullName
    {
        return $this->fullName;
    }

    public function getInstallationId(): InstallationId
    {
        return $this->installationId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getPayload(): BranchesPayload
    {
        return $this->payload;
    }

    /**
     * @return array|BranchPayload[]
     */
    public function getRepositoryBranchesAsArray(): array
    {
        return $this->payload->toArray();
    }

    public function serialize(): array
    {
        return [
            'fullName'       => $this->fullName->serialize(),
            'installationId' => $this->installationId->serialize(),
            'userId'         => $this->userId->serialize(),
            'payloadType'    => 'RepositoryBranchesResult',
            'payload'        => $this->payload->serialize(),
        ];
    }

    public static function deserialize(array $data): self
    {
        return new self(
            RepoFullName::deserialize($data['fullName']),
            InstallationId::deserialize($data['installationId']),
            UserId::deserialize($data['userId']),
            BranchesPayload::deserialize($data['payload'])
        );
    }
}
