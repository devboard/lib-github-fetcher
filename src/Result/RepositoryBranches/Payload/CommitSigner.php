<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitSignerSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitSignerTest
 */
class CommitSigner
{
    /** @var AccountId */
    private $userId;

    /** @var AccountLogin */
    private $login;

    /** @var string */
    private $name;

    /** @var AccountType */
    private $type;

    /** @var AccountAvatarUrl */
    private $avatarUrl;

    /** @var bool */
    private $siteAdmin;

    public function __construct(
        AccountId $userId,
        AccountLogin $login,
        string $name,
        AccountType $type,
        AccountAvatarUrl $avatarUrl,
        bool $siteAdmin
    ) {
        $this->userId    = $userId;
        $this->login     = $login;
        $this->name      = $name;
        $this->type      = $type;
        $this->avatarUrl = $avatarUrl;
        $this->siteAdmin = $siteAdmin;
    }

    public function getUserId(): AccountId
    {
        return $this->userId;
    }

    public function getLogin(): AccountLogin
    {
        return $this->login;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): AccountType
    {
        return $this->type;
    }

    public function getAvatarUrl(): AccountAvatarUrl
    {
        return $this->avatarUrl;
    }

    public function isSiteAdmin(): bool
    {
        return $this->siteAdmin;
    }

    public function serialize(): array
    {
        return [
            'userId'    => $this->userId->serialize(),
            'login'     => $this->login->serialize(),
            'name'      => $this->name,
            'type'      => $this->type->serialize(),
            'avatarUrl' => $this->avatarUrl->serialize(),
            'siteAdmin' => $this->siteAdmin,
        ];
    }

    public static function deserialize(array $data): self
    {
        return new self(
            AccountId::deserialize($data['userId']),
            AccountLogin::deserialize($data['login']),
            $data['name'],
            AccountType::deserialize($data['type']),
            AccountAvatarUrl::deserialize($data['avatarUrl']),
            $data['siteAdmin']
        );
    }
}
