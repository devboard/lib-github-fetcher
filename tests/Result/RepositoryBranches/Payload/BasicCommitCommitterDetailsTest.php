<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\Git\Commit\CommitDate;
use DevboardLib\Git\Commit\Committer\CommitterName;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BasicCommitCommitterDetails;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BasicCommitCommitterDetails
 * @group  unit
 */
class BasicCommitCommitterDetailsTest extends TestCase
{
    /** @var CommitterName */
    private $name;

    /** @var EmailAddress */
    private $email;

    /** @var CommitDate */
    private $commitDate;

    /** @var BasicCommitCommitterDetails */
    private $sut;

    public function setUp(): void
    {
        $this->name       = new CommitterName('Jane Johnson');
        $this->email      = new EmailAddress('jane@example.com');
        $this->commitDate = new CommitDate('2018-01-02T20:21:22+00:00');
        $this->sut        = new BasicCommitCommitterDetails($this->name, $this->email, $this->commitDate);
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

    public function testSerialize(): void
    {
        $expected = [
            '__type'     => 'BasicCommitCommitterDetails',
            'name'       => 'Jane Johnson',
            'email'      => 'jane@example.com',
            'commitDate' => '2018-01-02T20:21:22+00:00',
        ];

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, BasicCommitCommitterDetails::deserialize(json_decode($serialized, true)));
    }
}
