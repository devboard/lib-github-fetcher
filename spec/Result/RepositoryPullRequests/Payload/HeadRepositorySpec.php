<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Repo\RepoDescription;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\Repo\RepoHomepage;
use DevboardLib\GitHub\Repo\RepoId;
use DevboardLib\GitHub\Repo\RepoLanguage;
use DevboardLib\GitHub\Repo\RepoMirrorUrl;
use DevboardLib\GitHub\Repo\RepoOwner;
use DevboardLib\GitHub\Repo\RepoParent;
use DevboardLib\GitHub\Repo\RepoTimestamps;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\HeadRepository;
use PhpSpec\ObjectBehavior;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class HeadRepositorySpec extends ObjectBehavior
{
    public function let(
        RepoId $id,
        RepoFullName $fullName,
        RepoOwner $owner,
        BranchName $defaultBranch,
        RepoParent $parent,
        RepoDescription $description,
        RepoHomepage $homepage,
        RepoLanguage $language,
        RepoMirrorUrl $mirrorUrl,
        RepoTimestamps $timestamps
    ) {
        $this->beConstructedWith(
            $id,
            $fullName,
            $owner,
            $private = true,
            $defaultBranch,
            $fork = true,
            $parent,
            $description,
            $homepage,
            $language,
            $mirrorUrl,
            $archived = true,
            $timestamps
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(HeadRepository::class);
    }

    public function it_exposes_id(RepoId $id)
    {
        $this->getId()->shouldReturn($id);
    }

    public function it_exposes_full_name(RepoFullName $fullName)
    {
        $this->getFullName()->shouldReturn($fullName);
    }

    public function it_exposes_owner(RepoOwner $owner)
    {
        $this->getOwner()->shouldReturn($owner);
    }

    public function it_exposes_is_private()
    {
        $this->isPrivate()->shouldReturn(true);
    }

    public function it_exposes_default_branch(BranchName $defaultBranch)
    {
        $this->getDefaultBranch()->shouldReturn($defaultBranch);
    }

    public function it_exposes_is_fork()
    {
        $this->isFork()->shouldReturn(true);
    }

    public function it_exposes_parent(RepoParent $parent)
    {
        $this->getParent()->shouldReturn($parent);
    }

    public function it_exposes_description(RepoDescription $description)
    {
        $this->getDescription()->shouldReturn($description);
    }

    public function it_exposes_homepage(RepoHomepage $homepage)
    {
        $this->getHomepage()->shouldReturn($homepage);
    }

    public function it_exposes_language(RepoLanguage $language)
    {
        $this->getLanguage()->shouldReturn($language);
    }

    public function it_exposes_mirror_url(RepoMirrorUrl $mirrorUrl)
    {
        $this->getMirrorUrl()->shouldReturn($mirrorUrl);
    }

    public function it_exposes_is_archived()
    {
        $this->isArchived()->shouldReturn(true);
    }

    public function it_exposes_timestamps(RepoTimestamps $timestamps)
    {
        $this->getTimestamps()->shouldReturn($timestamps);
    }

    public function it_has_parent()
    {
        $this->hasParent()->shouldReturn(true);
    }

    public function it_has_description()
    {
        $this->hasDescription()->shouldReturn(true);
    }

    public function it_has_homepage()
    {
        $this->hasHomepage()->shouldReturn(true);
    }

    public function it_has_language()
    {
        $this->hasLanguage()->shouldReturn(true);
    }

    public function it_has_mirror_url()
    {
        $this->hasMirrorUrl()->shouldReturn(true);
    }

    public function it_has_archived()
    {
        $this->hasArchived()->shouldReturn(true);
    }

    public function it_can_be_serialized(
        RepoId $id,
        RepoFullName $fullName,
        RepoOwner $owner,
        BranchName $defaultBranch,
        RepoParent $parent,
        RepoDescription $description,
        RepoHomepage $homepage,
        RepoLanguage $language,
        RepoMirrorUrl $mirrorUrl,
        RepoTimestamps $timestamps
    ) {
        $id->serialize()->shouldBeCalled()->willReturn(1);
        $fullName->serialize()->shouldBeCalled()->willReturn(['owner' => 'value', 'repoName' => 'name']);
        $owner->serialize()->shouldBeCalled()->willReturn(
            [
                'userId'    => 1,
                'login'     => 'value',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ]
        );
        $defaultBranch->serialize()->shouldBeCalled()->willReturn('name');
        $parent->serialize()->shouldBeCalled()->willReturn(
            ['id' => 1, 'fullName' => ['owner' => 'value', 'repoName' => 'name']]
        );
        $description->serialize()->shouldBeCalled()->willReturn('description');
        $homepage->serialize()->shouldBeCalled()->willReturn('homepage');
        $language->serialize()->shouldBeCalled()->willReturn('language');
        $mirrorUrl->serialize()->shouldBeCalled()->willReturn('mirrorUrl');
        $timestamps->serialize()->shouldBeCalled()->willReturn(
            [
                'createdAt' => '2018-01-01T00:01:00+00:00',
                'updatedAt' => '2018-01-01T00:01:00+00:00',
                'pushedAt'  => '2018-01-01T00:01:00+00:00',
            ]
        );
        $this->serialize()->shouldReturn(
            [
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
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
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

        $this->deserialize($input)->shouldReturnAnInstanceOf(HeadRepository::class);
    }
}
