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
use DevboardLib\GitHub\Installation\InstallationRepositorySelection\InstallationRepositoryAll;
use DevboardLib\GitHub\Installation\InstallationUpdatedAt;
use DevboardLib\GitHubFetcher\Result\UserInstallations\GitHubInstallationResult;
use DevboardLib\GitHubFetcher\Result\UserInstallations\GitHubInstallationResults;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @covers \DevboardLib\GitHubFetcher\Result\UserInstallations\GitHubInstallationResults
 * @group  unit
 */
class GitHubInstallationResultsTest extends TestCase
{
    /** @var array */
    private $elements = [];

    /** @var GitHubInstallationResults */
    private $sut;

    public function setUp(): void
    {
        $this->elements = [
            new GitHubInstallationResult(
                new InstallationId(1),
                new InstallationAccount(
                    new AccountId(1),
                    new AccountLogin('value'),
                    AccountType::USER(),
                    new AccountAvatarUrl('avatarUrl'),
                    true
                ),
                new ApplicationId(1),
                new InstallationRepositoryAll(),
                new InstallationPermissions(['data']),
                new InstallationEvents(['data']),
                new InstallationAccessTokenUrl('accessTokenUrl'),
                new InstallationRepositoriesUrl('installationRepositoriesUrl'),
                new InstallationHtmlUrl('installationHtmlUrl'),
                new InstallationCreatedAt('2018-01-01T00:01:00+00:00'),
                new InstallationUpdatedAt('2018-01-01T00:01:00+00:00')
            ),
        ];
        $this->sut = new GitHubInstallationResults($this->elements);
    }

    public function testGetElements(): void
    {
        self::assertSame($this->elements, $this->sut->toArray());
    }

    public function testSerializeAndDeserialize(): void
    {
        $serialized     = $this->sut->serialize();
        $serializedJson = json_encode($serialized);
        self::assertEquals($this->sut, $this->sut::deserialize(json_decode($serializedJson, true)));
    }
}
