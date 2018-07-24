<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Query\UserInstallations;

use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use DevboardLib\GitHubFetcher\Query\GitHubFetcherQuery;

/**
 * @see FetchAllUserInstallationsQuerySpec
 */
class FetchAllUserInstallationsQuery implements GitHubFetcherQuery
{
    /** @var UserId */
    private $userId;

    /** @var JwtTokenAuth */
    private $token;

    public function __construct(UserId $userId, JwtTokenAuth $token)
    {
        $this->userId = $userId;
        $this->token  = $token;
    }

    public function getToken(): JwtTokenAuth
    {
        return $this->token;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function serialize(): array
    {
        return ['userId' => $this->userId->serialize(), 'token' => $this->token->serialize()];
    }

    public static function deserialize(array $data): self
    {
        return new self(UserId::deserialize($data['userId']), JwtTokenAuth::deserialize($data['token']));
    }

    public function asString(): string
    {
        $data = [self::class, 'userId:'.$this->userId->asString()];

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
