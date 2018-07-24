<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload;

use DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload\UserGitHubRepositoryPermissions;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload\UserGitHubRepositoryPermissions
 * @group  unit
 */
class UserGitHubRepositoryPermissionsTest extends TestCase
{
    /** @var bool */
    private $admin;

    /** @var bool */
    private $pushAllowed;

    /** @var bool */
    private $pullAllowed;

    /** @var UserGitHubRepositoryPermissions */
    private $sut;

    public function setUp(): void
    {
        $this->admin       = true;
        $this->pushAllowed = true;
        $this->pullAllowed = true;
        $this->sut         = new UserGitHubRepositoryPermissions($this->admin, $this->pushAllowed, $this->pullAllowed);
    }

    public function testIsAdmin(): void
    {
        self::assertSame($this->admin, $this->sut->isAdmin());
    }

    public function testIsPushAllowed(): void
    {
        self::assertSame($this->pushAllowed, $this->sut->isPushAllowed());
    }

    public function testIsPullAllowed(): void
    {
        self::assertSame($this->pullAllowed, $this->sut->isPullAllowed());
    }

    public function testSerialize(): void
    {
        $expected = ['admin' => true, 'pushAllowed' => true, 'pullAllowed' => true];

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, UserGitHubRepositoryPermissions::deserialize(json_decode($serialized, true)));
    }
}
