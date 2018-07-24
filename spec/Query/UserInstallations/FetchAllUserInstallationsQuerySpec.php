<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Query\UserInstallations;

use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use DevboardLib\GitHubFetcher\Query\GitHubFetcherQuery;
use DevboardLib\GitHubFetcher\Query\UserInstallations\FetchAllUserInstallationsQuery;
use PhpSpec\ObjectBehavior;

class FetchAllUserInstallationsQuerySpec extends ObjectBehavior
{
    public function let(UserId $userId, JwtTokenAuth $token)
    {
        $this->beConstructedWith($userId, $token);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(FetchAllUserInstallationsQuery::class);
        $this->shouldImplement(GitHubFetcherQuery::class);
    }

    public function it_exposes_token(JwtTokenAuth $token)
    {
        $this->getToken()->shouldReturn($token);
    }

    public function it_exposes_github_user_id(UserId $userId)
    {
        $this->getUserId()->shouldReturn($userId);
    }

    public function it_can_be_serialized_for_queue(JwtTokenAuth $token, UserId $userId)
    {
        $token->serialize()->shouldBeCalled()->willReturn('token');
        $userId->serialize()->shouldBeCalled()->willReturn(123);

        $this->serialize()->shouldReturn(['userId' => 123, 'token' => 'token']);
    }

    public function it_can_be_deserialized_from_queue_data()
    {
        $input = ['userId' => 123, 'token' => 'token'];
        $this->deserialize($input)->shouldReturnAnInstanceOf(FetchAllUserInstallationsQuery::class);
    }
}
