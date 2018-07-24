<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Query\InstallationRepositories;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubFetcher\Query\GitHubFetcherQuery;

/**
 * @see FetchAllInstallationRepositoriesQuerySpec
 */
class FetchAllInstallationRepositoriesQuery implements GitHubFetcherQuery
{
    /** @var InstallationId */
    private $installationId;

    /** @var UserId */
    private $userId;

    public function __construct(InstallationId $installationId, UserId $userId)
    {
        $this->installationId = $installationId;
        $this->userId         = $userId;
    }

    public function getInstallationId(): InstallationId
    {
        return $this->installationId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getCredentials(): InstallationCredentials
    {
        return new InstallationCredentials($this->installationId, $this->userId);
    }

    public function serialize(): array
    {
        return ['installationId' => $this->installationId->serialize(), 'userId' => $this->userId->serialize()];
    }

    public static function deserialize(array $data): self
    {
        return new self(InstallationId::deserialize($data['installationId']), UserId::deserialize($data['userId']));
    }

    public function asString(): string
    {
        $data = [
            self::class,
            'installationId:'.$this->installationId->asString(),
            'userId:'.$this->userId->asString(),
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
