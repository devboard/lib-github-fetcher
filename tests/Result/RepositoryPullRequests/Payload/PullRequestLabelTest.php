<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Label\LabelColor;
use DevboardLib\GitHub\Label\LabelId;
use DevboardLib\GitHub\Label\LabelName;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabel;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabel
 * @group  unit
 */
class PullRequestLabelTest extends TestCase
{
    /** @var LabelId */
    private $id;

    /** @var LabelName */
    private $name;

    /** @var LabelColor */
    private $color;

    /** @var bool */
    private $default;

    /** @var PullRequestLabel */
    private $sut;

    public function setUp(): void
    {
        $this->id      = new LabelId(1);
        $this->name    = new LabelName('value');
        $this->color   = new LabelColor('color');
        $this->default = true;
        $this->sut     = new PullRequestLabel($this->id, $this->name, $this->color, $this->default);
    }

    public function testGetId(): void
    {
        self::assertSame($this->id, $this->sut->getId());
    }

    public function testGetName(): void
    {
        self::assertSame($this->name, $this->sut->getName());
    }

    public function testGetColor(): void
    {
        self::assertSame($this->color, $this->sut->getColor());
    }

    public function testIsDefault(): void
    {
        self::assertSame($this->default, $this->sut->isDefault());
    }

    public function testSerialize(): void
    {
        $expected = ['id' => 1, 'name' => 'value', 'color' => 'color', 'default' => true];

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, PullRequestLabel::deserialize(json_decode($serialized, true)));
    }
}
