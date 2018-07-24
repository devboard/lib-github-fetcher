<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Repo\RepoCreatedAt;
use DevboardLib\GitHub\Repo\RepoDescription;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\Repo\RepoHomepage;
use DevboardLib\GitHub\Repo\RepoId;
use DevboardLib\GitHub\Repo\RepoLanguage;
use DevboardLib\GitHub\Repo\RepoMirrorUrl;
use DevboardLib\GitHub\Repo\RepoName;
use DevboardLib\GitHub\Repo\RepoOwner;
use DevboardLib\GitHub\Repo\RepoParent;
use DevboardLib\GitHub\Repo\RepoPushedAt;
use DevboardLib\GitHub\Repo\RepoTimestamps;
use DevboardLib\GitHub\Repo\RepoUpdatedAt;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\HeadRepository;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\HeadRepository
 * @group  unit
 */
class HeadRepositoryTest extends TestCase
{
    /** @var RepoId */
    private $id;

    /** @var RepoFullName */
    private $fullName;

    /** @var RepoOwner */
    private $owner;

    /** @var bool */
    private $private;

    /** @var BranchName */
    private $defaultBranch;

    /** @var bool */
    private $fork;

    /** @var RepoParent|null */
    private $parent;

    /** @var RepoDescription|null */
    private $description;

    /** @var RepoHomepage|null */
    private $homepage;

    /** @var RepoLanguage|null */
    private $language;

    /** @var RepoMirrorUrl|null */
    private $mirrorUrl;

    /** @var bool|null */
    private $archived;

    /** @var RepoTimestamps */
    private $timestamps;

    /** @var HeadRepository */
    private $sut;

    public function setUp(): void
    {
        $this->id       = new RepoId(1);
        $this->fullName = new RepoFullName(new AccountLogin('value'), new RepoName('name'));
        $this->owner    = new RepoOwner(
            new AccountId(1),
            new AccountLogin('value'),
            AccountType::USER(),
            new AccountAvatarUrl('avatarUrl'),
            true
        );
        $this->private       = true;
        $this->defaultBranch = new BranchName('name');
        $this->fork          = true;
        $this->parent        = new RepoParent(
            new RepoId(1), new RepoFullName(new AccountLogin('value'), new RepoName('name'))
        );
        $this->description = new RepoDescription('description');
        $this->homepage    = new RepoHomepage('homepage');
        $this->language    = new RepoLanguage('language');
        $this->mirrorUrl   = new RepoMirrorUrl('mirrorUrl');
        $this->archived    = true;
        $this->timestamps  = new RepoTimestamps(
            new RepoCreatedAt('2018-01-01T00:01:00+00:00'),
            new RepoUpdatedAt('2018-01-01T00:01:00+00:00'),
            new RepoPushedAt('2018-01-01T00:01:00+00:00')
        );
        $this->sut = new HeadRepository(
            $this->id,
            $this->fullName,
            $this->owner,
            $this->private,
            $this->defaultBranch,
            $this->fork,
            $this->parent,
            $this->description,
            $this->homepage,
            $this->language,
            $this->mirrorUrl,
            $this->archived,
            $this->timestamps
        );
    }

    public function testGetId(): void
    {
        self::assertSame($this->id, $this->sut->getId());
    }

    public function testGetFullName(): void
    {
        self::assertSame($this->fullName, $this->sut->getFullName());
    }

    public function testGetOwner(): void
    {
        self::assertSame($this->owner, $this->sut->getOwner());
    }

    public function testIsPrivate(): void
    {
        self::assertSame($this->private, $this->sut->isPrivate());
    }

    public function testGetDefaultBranch(): void
    {
        self::assertSame($this->defaultBranch, $this->sut->getDefaultBranch());
    }

    public function testIsFork(): void
    {
        self::assertSame($this->fork, $this->sut->isFork());
    }

    public function testGetParent(): void
    {
        self::assertSame($this->parent, $this->sut->getParent());
    }

    public function testGetDescription(): void
    {
        self::assertSame($this->description, $this->sut->getDescription());
    }

    public function testGetHomepage(): void
    {
        self::assertSame($this->homepage, $this->sut->getHomepage());
    }

    public function testGetLanguage(): void
    {
        self::assertSame($this->language, $this->sut->getLanguage());
    }

    public function testGetMirrorUrl(): void
    {
        self::assertSame($this->mirrorUrl, $this->sut->getMirrorUrl());
    }

    public function testIsArchived(): void
    {
        self::assertSame($this->archived, $this->sut->isArchived());
    }

    public function testGetTimestamps(): void
    {
        self::assertSame($this->timestamps, $this->sut->getTimestamps());
    }

    public function testHasParent(): void
    {
        self::assertTrue($this->sut->hasParent());
    }

    public function testHasDescription(): void
    {
        self::assertTrue($this->sut->hasDescription());
    }

    public function testHasHomepage(): void
    {
        self::assertTrue($this->sut->hasHomepage());
    }

    public function testHasLanguage(): void
    {
        self::assertTrue($this->sut->hasLanguage());
    }

    public function testHasMirrorUrl(): void
    {
        self::assertTrue($this->sut->hasMirrorUrl());
    }

    public function testHasArchived(): void
    {
        self::assertTrue($this->sut->hasArchived());
    }

    public function testSerialize(): void
    {
        $expected = [
            'id'       => 1,
            'fullName' => ['owner' => 'value', 'repoName' => 'name'],
            'owner'    => [
                'userId'    => 1,
                'login'     => 'value',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ],
            'private'       => true,
            'defaultBranch' => 'name',
            'fork'          => true,
            'parent'        => ['id' => 1, 'fullName' => ['owner' => 'value', 'repoName' => 'name']],
            'description'   => 'description',
            'homepage'      => 'homepage',
            'language'      => 'language',
            'mirrorUrl'     => 'mirrorUrl',
            'archived'      => true,
            'timestamps'    => [
                'createdAt' => '2018-01-01T00:01:00+00:00',
                'updatedAt' => '2018-01-01T00:01:00+00:00',
                'pushedAt'  => '2018-01-01T00:01:00+00:00',
            ],
        ];

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, HeadRepository::deserialize(json_decode($serialized, true)));
    }
}
