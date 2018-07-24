<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\Git\Commit\CommitDate;
use DevboardLib\Git\Commit\Committer\CommitterName;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\User\UserAvatarUrl;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHub\User\UserLogin;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\FullCommitCommitterDetailsSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\FullCommitCommitterDetailsTest
 */
class FullCommitCommitterDetails implements CommitCommitter
{
    /** @var CommitterName */
    private $name;

    /** @var EmailAddress */
    private $email;

    /** @var CommitDate */
    private $commitDate;

    /** @var UserId */
    private $userId;

    /** @var UserLogin */
    private $login;

    /** @var AccountType */
    private $type;

    /** @var UserAvatarUrl */
    private $avatarUrl;

    /** @var bool */
    private $siteAdmin;

    public function __construct(
        CommitterName $name,
        EmailAddress $email,
        CommitDate $commitDate,
        UserId $userId,
        UserLogin $login,
        AccountType $type,
        UserAvatarUrl $avatarUrl,
        bool $siteAdmin
    ) {
        $this->name       = $name;
        $this->email      = $email;
        $this->commitDate = $commitDate;
        $this->userId     = $userId;
        $this->login      = $login;
        $this->type       = $type;
        $this->avatarUrl  = $avatarUrl;
        $this->siteAdmin  = $siteAdmin;
    }

    public function getName(): CommitterName
    {
        return $this->name;
    }

    public function getEmail(): EmailAddress
    {
        return $this->email;
    }

    public function getCommitDate(): CommitDate
    {
        return $this->commitDate;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getLogin(): UserLogin
    {
        return $this->login;
    }

    public function getType(): AccountType
    {
        return $this->type;
    }

    public function getAvatarUrl(): UserAvatarUrl
    {
        return $this->avatarUrl;
    }

    public function isSiteAdmin(): bool
    {
        return $this->siteAdmin;
    }

    public function hasFullDetails(): bool
    {
        return true;
    }

    public function serialize(): array
    {
        return [
            '__type'     => 'FullCommitCommitterDetails',
            'name'       => $this->name->serialize(),
            'email'      => $this->email->serialize(),
            'commitDate' => $this->commitDate->serialize(),
            'userId'     => $this->userId->serialize(),
            'login'      => $this->login->serialize(),
            'type'       => $this->type->serialize(),
            'avatarUrl'  => $this->avatarUrl->serialize(),
            'siteAdmin'  => $this->siteAdmin,
        ];
    }

    public static function deserialize(array $data): self
    {
        return new self(
            CommitterName::deserialize($data['name']),
            EmailAddress::deserialize($data['email']),
            CommitDate::deserialize($data['commitDate']),
            UserId::deserialize($data['userId']),
            UserLogin::deserialize($data['login']),
            AccountType::deserialize($data['type']),
            UserAvatarUrl::deserialize($data['avatarUrl']),
            $data['siteAdmin']
        );
    }
}
