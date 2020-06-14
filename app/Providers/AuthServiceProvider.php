<?php

namespace PacketPrep\Providers;


use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use PacketPrep\Policies\UserPolicy;
use PacketPrep\Policies\RolePolicy;
use PacketPrep\Policies\DocsPolicy;
use PacketPrep\User;
use PacketPrep\Models\User\Role;
use PacketPrep\Models\Content\Doc;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Doc::class => DocsPolicy::class,
        \PacketPrep\Models\Content\Chapter::class => \PacketPrep\Policies\ChapterPolicy::class,
        \PacketPrep\Models\System\Update::class => \PacketPrep\Policies\UpdatePolicy::class,
        \PacketPrep\Models\System\Finance::class => \PacketPrep\Policies\FinancePolicy::class,
        \PacketPrep\Models\System\Goal::class => \PacketPrep\Policies\GoalPolicy::class,
        \PacketPrep\Models\System\Report::class => \PacketPrep\Policies\ReportPolicy::class,
        \PacketPrep\Models\Social\Blog::class => \PacketPrep\Policies\BlogPolicy::class,
        \PacketPrep\Models\Social\Social::class => \PacketPrep\Policies\SocialPolicy::class,

        \PacketPrep\Models\Dataentry\Project::class => \PacketPrep\Policies\Dataentry\ProjectPolicy::class,
        \PacketPrep\Models\Dataentry\Category::class => \PacketPrep\Policies\Dataentry\CategoryPolicy::class,
        \PacketPrep\Models\Dataentry\Tag::class => \PacketPrep\Policies\Dataentry\TagPolicy::class,
        \PacketPrep\Models\Dataentry\Passage::class => \PacketPrep\Policies\Dataentry\PassagePolicy::class,
        \PacketPrep\Models\Dataentry\Question::class => \PacketPrep\Policies\Dataentry\QuestionPolicy::class,

        \PacketPrep\Models\Recruit\Job::class => \PacketPrep\Policies\Recruit\JobPolicy::class,
        \PacketPrep\Models\Recruit\Form::class => \PacketPrep\Policies\Recruit\FormPolicy::class,

        \PacketPrep\Models\Library\Repository::class => \PacketPrep\Policies\Library\RepositoryPolicy::class,
        \PacketPrep\Models\Library\Structure::class => \PacketPrep\Policies\Library\StructurePolicy::class,
        \PacketPrep\Models\Library\Ltag::class => \PacketPrep\Policies\Library\LtagPolicy::class,
        \PacketPrep\Models\Library\Lpassage::class => \PacketPrep\Policies\Library\LpassagePolicy::class,
        \PacketPrep\Models\Library\Lquestion::class => \PacketPrep\Policies\Library\LquestionPolicy::class,
        \PacketPrep\Models\Library\Version::class => \PacketPrep\Policies\Library\VersionPolicy::class,
        \PacketPrep\Models\Library\Video::class => \PacketPrep\Policies\Library\VideoPolicy::class,
        \PacketPrep\Models\Library\Document::class => \PacketPrep\Policies\Library\DocumentPolicy::class,

        \PacketPrep\Models\Course\Course::class => \PacketPrep\Policies\Course\CoursePolicy::class,
        \PacketPrep\Models\Course\Index::class => \PacketPrep\Policies\Course\IndexPolicy::class,


        \PacketPrep\Models\Product\Client::class => \PacketPrep\Policies\Product\ClientPolicy::class,
        \PacketPrep\Models\Product\Client::class => \PacketPrep\Policies\Product\AdminPolicy::class,
        \PacketPrep\Models\Product\Product::class => \PacketPrep\Policies\Product\ProductPolicy::class,
        \PacketPrep\Models\Product\Coupon::class => \PacketPrep\Policies\Product\CouponPolicy::class,

        \PacketPrep\Models\College\College::class => \PacketPrep\Policies\College\CollegePolicy::class,
        \PacketPrep\Models\College\Branch::class => \PacketPrep\Policies\College\BranchPolicy::class,
        \PacketPrep\Models\College\Zone::class => \PacketPrep\Policies\College\ZonePolicy::class,
        \PacketPrep\Models\College\Metric::class => \PacketPrep\Policies\College\MetricPolicy::class,
        \PacketPrep\Models\College\Service::class => \PacketPrep\Policies\College\ServicePolicy::class,
        \PacketPrep\Models\College\Ambassador::class => \PacketPrep\Policies\College\AmbassadorPolicy::class,
         \PacketPrep\Models\College\Batch::class => \PacketPrep\Policies\College\BatchPolicy::class,
        \PacketPrep\Models\College\Campus::class => \PacketPrep\Policies\College\CampusPolicy::class,

        \PacketPrep\Models\Job\Company::class => \PacketPrep\Policies\Job\CompanyPolicy::class,
        \PacketPrep\Models\Job\Opening::class => \PacketPrep\Policies\Job\OpeningPolicy::class,
        \PacketPrep\Models\Job\Location::class => \PacketPrep\Policies\Job\LocationPolicy::class,
        \PacketPrep\Models\Job\Stream::class => \PacketPrep\Policies\Job\StreamPolicy::class,
        \PacketPrep\Models\Job\Post::class => \PacketPrep\Policies\Job\PostPolicy::class,

        \PacketPrep\Models\Exam\Exam::class => \PacketPrep\Policies\Exam\ExamPolicy::class,
        \PacketPrep\Models\Exam\Examtype::class => \PacketPrep\Policies\Exam\ExamtypePolicy::class,
        \PacketPrep\Models\Exam\Section::class => \PacketPrep\Policies\Exam\SectionPolicy::class,

        \PacketPrep\Models\Content\Company::class => \PacketPrep\Policies\Content\CompanyPolicy::class,
        \PacketPrep\Models\Content\Article::class => \PacketPrep\Policies\Content\ArticlePolicy::class,
        \PacketPrep\Models\Content\Label::class => \PacketPrep\Policies\Content\LabelPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
