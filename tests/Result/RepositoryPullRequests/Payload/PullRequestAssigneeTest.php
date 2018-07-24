<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAssignee;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAssignee
 * @group  unit
 */
class PullRequestAssigneeTest extends TestCase
{
    /** @var AccountId */
    private $userId;

    /** @var AccountLogin */
    private $login;

    /** @var AccountType */
    private $type;

    /** @var AccountAvatarUrl */
    private $avatarUrl;

    /** @var bool */
    private $siteAdmin;

    /** @var PullRequestAssignee */
    private $sut;

    public function setUp(): void
    {
        $this->userId    = new AccountId(583231);
        $this->login     = new AccountLogin('octocat');
        $this->type      = AccountType::USER();
        $this->avatarUrl = new AccountAvatarUrl('https://avatars3.githubusercontent.com/u/583231?v=4');
        $this->siteAdmin = false;
        $this->sut       = new PullRequestAssignee(
            $this->userId, $this->login, $this->type, $this->avatarUrl, $this->siteAdmin
        );
    }

    public function testGetUserId(): void
    {
        self::assertSame($this->userId, $this->sut->getUserId());
    }

    public function testGetLogin(): void
    {
        self::assertSame($this->login, $this->sut->getLogin());
    }

    public function testGetType(): void
    {
        self::assertSame($this->type, $this->sut->getType());
    }

    public function testGetAvatarUrl(): void
    {
        self::assertSame($this->avatarUrl, $this->sut->getAvatarUrl());
    }

    public function testIsSiteAdmin(): void
    {
        self::assertSame($this->siteAdmin, $this->sut->isSiteAdmin());
    }

    public function testSerialize(): void
    {
        $expected = [
            'userId'    => 583231,
            'login'     => 'octocat',
            'type'      => 'User',
            'avatarUrl' => 'https://avatars3.githubusercontent.com/u/583231?v=4',
            'siteAdmin' => false,
        ];

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, PullRequestAssignee::deserialize(json_decode($serialized, true)));
    }
}
