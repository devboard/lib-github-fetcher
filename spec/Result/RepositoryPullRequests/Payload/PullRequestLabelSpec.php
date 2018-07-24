<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Label\LabelColor;
use DevboardLib\GitHub\Label\LabelId;
use DevboardLib\GitHub\Label\LabelName;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabel;
use PhpSpec\ObjectBehavior;

class PullRequestLabelSpec extends ObjectBehavior
{
    public function let(LabelId $id, LabelName $name, LabelColor $color)
    {
        $this->beConstructedWith($id, $name, $color, $default = true);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestLabel::class);
    }

    public function it_exposes_id(LabelId $id)
    {
        $this->getId()->shouldReturn($id);
    }

    public function it_exposes_name(LabelName $name)
    {
        $this->getName()->shouldReturn($name);
    }

    public function it_exposes_color(LabelColor $color)
    {
        $this->getColor()->shouldReturn($color);
    }

    public function it_exposes_is_default()
    {
        $this->isDefault()->shouldReturn(true);
    }

    public function it_can_be_serialized(LabelId $id, LabelName $name, LabelColor $color)
    {
        $id->serialize()->shouldBeCalled()->willReturn(1);
        $name->serialize()->shouldBeCalled()->willReturn('value');
        $color->serialize()->shouldBeCalled()->willReturn('color');
        $this->serialize()->shouldReturn(['id' => 1, 'name' => 'value', 'color' => 'color', 'default' => true]);
    }

    public function it_can_be_deserialized()
    {
        $input = ['id' => 1, 'name' => 'value', 'color' => 'color', 'default' => true];

        $this->deserialize($input)->shouldReturnAnInstanceOf(PullRequestLabel::class);
    }
}
