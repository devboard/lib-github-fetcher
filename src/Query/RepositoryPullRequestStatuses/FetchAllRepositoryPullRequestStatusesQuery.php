<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Query\RepositoryPullRequestStatuses;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubFetcher\Query\GitHubFetcherQuery;

/**
 * @see FetchAllRepositoryPullRequestStatusesQuerySpec
 */
class FetchAllRepositoryPullRequestStatusesQuery implements GitHubFetcherQuery
{
    /** @var RepoFullName */
    private $repoFullName;

    /** @var InstallationId */
    private $installationId;

    /** @var UserId */
    private $userId;

    /** @var null|string */
    private $cursor;

    public function __construct(
        RepoFullName $repoFullName, InstallationId $installationId, UserId $userId, ?string $cursor = null
    ) {
        $this->repoFullName   = $repoFullName;
        $this->installationId = $installationId;
        $this->userId         = $userId;
        $this->cursor         = $cursor;
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

    public function getCursor(): ?string
    {
        return $this->cursor;
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
            'cursor'         => $this->cursor,
        ];
    }

    public static function deserialize(array $data): self
    {
        return new self(
            RepoFullName::deserialize($data['repoFullName']),
            InstallationId::deserialize($data['installationId']),
            UserId::deserialize($data['userId']),
            $data['cursor']
        );
    }

    public function asString(): string
    {
        $data = [
            self::class,
            'repoFullName:'.$this->repoFullName->asString(),
            'installationId:'.$this->installationId->asString(),
            'userId:'.$this->userId->asString(),
            'cursor:'.$this->cursor,
        ];

        return implode(' | ', $data);
    }

    /**
     * @deprecated Please use `asString`
     */
    public function __toString(): string
    {
        return $this->asString();
    }
}
