<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\Git\Commit\Author\AuthorName;
use DevboardLib\Git\Commit\CommitDate;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\User\UserAvatarUrl;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHub\User\UserLogin;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\FullCommitAuthorDetails;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\FullCommitAuthorDetails
 * @group  unit
 */
class FullCommitAuthorDetailsTest extends TestCase
{
    /** @var AuthorName */
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

    /** @var FullCommitAuthorDetails */
    private $sut;

    public function setUp(): void
    {
        $this->name       = new AuthorName('Jane Johnson');
        $this->email      = new EmailAddress('jane@example.com');
        $this->commitDate = new CommitDate('2018-01-02T20:21:22+00:00');
        $this->userId     = new UserId(6752317);
        $this->login      = new UserLogin('baxterthehacker');
        $this->type       = new AccountType('User');
        $this->avatarUrl  = new UserAvatarUrl('https://avatars.githubusercontent.com/u/6752317?v=3');
        $this->siteAdmin  = false;
        $this->sut        = new FullCommitAuthorDetails(
            $this->name,
            $this->email,
            $this->commitDate,
            $this->userId,
            $this->login,
            $this->type,
            $this->avatarUrl,
            $this->siteAdmin
        );
    }

    public function testGetName(): void
    {
        self::assertSame($this->name, $this->sut->getName());
    }

    public function testGetEmail(): void
    {
        self::assertSame($this->email, $this->sut->getEmail());
    }

    public function testGetCommitDate(): void
    {
        self::assertSame($this->commitDate, $this->sut->getCommitDate());
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
            '__type'     => 'FullCommitAuthorDetails',
            'name'       => 'Jane Johnson',
            'email'      => 'jane@example.com',
            'commitDate' => '2018-01-02T20:21:22+00:00',
            'userId'     => 6752317,
            'login'      => 'baxterthehacker',
            'type'       => 'User',
            'avatarUrl'  => 'https://avatars.githubusercontent.com/u/6752317?v=3',
            'siteAdmin'  => false,
        ];

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, FullCommitAuthorDetails::deserialize(json_decode($serialized, true)));
    }
}
