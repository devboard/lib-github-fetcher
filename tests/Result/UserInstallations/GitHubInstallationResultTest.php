<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\UserInstallations;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Application\ApplicationId;
use DevboardLib\GitHub\Installation\InstallationAccessTokenUrl;
use DevboardLib\GitHub\Installation\InstallationAccount;
use DevboardLib\GitHub\Installation\InstallationCreatedAt;
use DevboardLib\GitHub\Installation\InstallationEvents;
use DevboardLib\GitHub\Installation\InstallationHtmlUrl;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Installation\InstallationPermissions;
use DevboardLib\GitHub\Installation\InstallationRepositoriesUrl;
use DevboardLib\GitHub\Installation\InstallationRepositorySelection;
use DevboardLib\GitHub\Installation\InstallationUpdatedAt;
use DevboardLib\GitHubFetcher\Result\UserInstallations\GitHubInstallationResult;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @covers \DevboardLib\GitHubFetcher\Result\UserInstallations\GitHubInstallationResult
 * @group  unit
 */
class GitHubInstallationResultTest extends TestCase
{
    /** @var InstallationId */
    private $installationId;

    /** @var InstallationAccount */
    private $installationAccount;

    /** @var ApplicationId */
    private $applicationId;

    /** @var InstallationRepositorySelection */
    private $repositorySelection;

    /** @var InstallationPermissions */
    private $permissions;

    /** @var InstallationEvents */
    private $events;

    /** @var InstallationAccessTokenUrl */
    private $accessTokenUrl;

    /** @var InstallationRepositoriesUrl */
    private $repositoriesUrl;

    /** @var InstallationHtmlUrl */
    private $htmlUrl;

    /** @var InstallationCreatedAt */
    private $createdAt;

    /** @var InstallationUpdatedAt */
    private $updatedAt;

    /** @var GitHubInstallationResult */
    private $sut;

    public function setUp(): void
    {
        $this->installationId      = new InstallationId(1);
        $this->installationAccount = new InstallationAccount(
            new AccountId(1),
            new AccountLogin('value'),
            AccountType::USER(),
            new AccountAvatarUrl('avatarUrl'),
            true
        );
        $this->applicationId       = new ApplicationId(1);
        $this->repositorySelection = new InstallationRepositorySelection\InstallationRepositoryAll();
        $this->permissions         = new InstallationPermissions(['data']);
        $this->events              = new InstallationEvents(['data']);
        $this->accessTokenUrl      = new InstallationAccessTokenUrl('accessTokenUrl');
        $this->repositoriesUrl     = new InstallationRepositoriesUrl('installationRepositoriesUrl');
        $this->htmlUrl             = new InstallationHtmlUrl('installationHtmlUrl');
        $this->createdAt           = new InstallationCreatedAt('2018-01-01T00:01:00+00:00');
        $this->updatedAt           = new InstallationUpdatedAt('2018-01-01T00:01:00+00:00');
        $this->sut                 = new GitHubInstallationResult(
            $this->installationId,
            $this->installationAccount,
            $this->applicationId,
            $this->repositorySelection,
            $this->permissions,
            $this->events,
            $this->accessTokenUrl,
            $this->repositoriesUrl,
            $this->htmlUrl,
            $this->createdAt,
            $this->updatedAt
        );
    }

    public function testGetInstallationId(): void
    {
        self::assertSame($this->installationId, $this->sut->getInstallationId());
    }

    public function testGetInstallationAccount(): void
    {
        self::assertSame($this->installationAccount, $this->sut->getInstallationAccount());
    }

    public function testGetApplicationId(): void
    {
        self::assertSame($this->applicationId, $this->sut->getApplicationId());
    }

    public function testGetRepositorySelection(): void
    {
        self::assertSame($this->repositorySelection, $this->sut->getRepositorySelection());
    }

    public function testGetPermissions(): void
    {
        self::assertSame($this->permissions, $this->sut->getPermissions());
    }

    public function testGetEvents(): void
    {
        self::assertSame($this->events, $this->sut->getEvents());
    }

    public function testGetAccessTokenUrl(): void
    {
        self::assertSame($this->accessTokenUrl, $this->sut->getAccessTokenUrl());
    }

    public function testGetRepositoriesUrl(): void
    {
        self::assertSame($this->repositoriesUrl, $this->sut->getRepositoriesUrl());
    }

    public function testGetHtmlUrl(): void
    {
        self::assertSame($this->htmlUrl, $this->sut->getHtmlUrl());
    }

    public function testGetCreatedAt(): void
    {
        self::assertSame($this->createdAt, $this->sut->getCreatedAt());
    }

    public function testGetUpdatedAt(): void
    {
        self::assertSame($this->updatedAt, $this->sut->getUpdatedAt());
    }

    public function testSerialize(): void
    {
        $expected = [
            'installationId'      => 1,
            'installationAccount' => [
                'userId'    => 1,
                'login'     => 'value',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ],
            'applicationId'       => 1,
            'repositorySelection' => InstallationRepositorySelection\InstallationRepositoryAll::NAME,
            'permissions'         => ['data'],
            'events'              => ['data'],
            'accessTokenUrl'      => 'accessTokenUrl',
            'repositoriesUrl'     => 'installationRepositoriesUrl',
            'htmlUrl'             => 'installationHtmlUrl',
            'createdAt'           => '2018-01-01T00:01:00+00:00',
            'updatedAt'           => '2018-01-01T00:01:00+00:00',
        ];

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, GitHubInstallationResult::deserialize(json_decode($serialized, true)));
    }
}
