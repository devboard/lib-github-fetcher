<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Label\LabelColor;
use DevboardLib\GitHub\Label\LabelId;
use DevboardLib\GitHub\Label\LabelName;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabel;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabels;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabels
 * @group  unit
 */
class PullRequestLabelsTest extends TestCase
{
    /** @var array */
    private $elements = [];

    /** @var PullRequestLabels */
    private $sut;

    public function setUp(): void
    {
        $this->elements = [new PullRequestLabel(new LabelId(1), new LabelName('value'), new LabelColor('color'), true)];
        $this->sut      = new PullRequestLabels($this->elements);
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
