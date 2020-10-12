<?php

namespace App\Console\Commands;

use App\Models\Blog\Post;
use App\Models\CourseChapters;
use App\Models\Courses;
use App\Models\JobCircular;
use App\Models\McqQuestions;
use App\Models\QuestionPapers;
use Illuminate\Console\Command;

use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Sitemap;
use Spatie\Sitemap\Sitemap as SM;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            SitemapIndex::create()
                ->add(Sitemap::create('/questions_sitemap.xml'))
                ->add(Sitemap::create('/question_papers_sitemap.xml'))
                ->add(Sitemap::create('/job_circulars_sitemap.xml'))
                ->add(Sitemap::create('/courses_sitemap.xml'))
                ->add(Sitemap::create('/course_chapters_sitemap.xml'))
                ->add(Sitemap::create('/posts_sitemap.xml'))
                ->add(Sitemap::create('/pages_sitemap.xml'))
                ->add(Sitemap::create('/categories_sitemap.xml'))
                ->writeToFile(public_path('sitemap_index.xml'));
            $this->info('Sitemap Index Generated Successfully');

            $mcq = SM::create();
            McqQuestions::all()->each(function ($question) use ($mcq) {
                $mcq->add(
                    Url::create(route('Questions.View', $question->only('id', 'slug')))
                        ->setLastModificationDate($question->updated_at)
                );
            });
            $mcq->writeToFile(public_path('questions_sitemap.xml'));
            $this->info('MCQ Questions added to questions_sitemap.xml');

            $mcqPapers = SM::create();
            QuestionPapers::all()->each(function ($paper) use ($mcqPapers) {
                $mcqPapers->add(
                    Url::create(route('Questions.Papers.View', $paper->only('id', 'slug')))
                        ->setLastModificationDate($paper->updated_at)
                );
            });
            $mcqPapers->writeToFile(public_path('question_papers_sitemap.xml'));
            $this->info('Question Papers added to question_papers_sitemap.xml');

            $jobCirculars = SM::create();
            JobCircular::all()->each(function ($item) use ($jobCirculars) {
                $jobCirculars->add(
                    Url::create(route('Job.Circulars.View', $item->only('id', 'slug')))
                        ->setLastModificationDate($item->updated_at)
                );
            });
            $jobCirculars->writeToFile(public_path('job_circulars_sitemap.xml'));
            $this->info('Job Circulars added to job_circulars_sitemap.xml');

            $courses = SM::create();
            Courses::all()->each(function ($item) use ($courses) {
                $courses->add(
                    Url::create(route('Courses.View', $item->only('id', 'slug')))
                        ->setLastModificationDate($item->updated_at)
                );
            });
            $courses->writeToFile(public_path('courses_sitemap.xml'));
            $this->info('Courses added to courses_sitemap.xml');

            $courseChapters = SM::create();
            CourseChapters::all()->each(function ($item) use ($courseChapters) {
                $courseChapters->add(
                    Url::create(route('Courses.Chapter.View', array_merge($item->only('id', 'slug'), ["course_slug" => $item->course->slug])))
                        ->setLastModificationDate($item->updated_at)
                );
            });
            $courseChapters->writeToFile(public_path('course_chapters_sitemap.xml'));
            $this->info('Course Chapters added to course_chapters_sitemap.xml');


            $posts = SM::create();
            Post::all()->each(function ($item) use ($posts) {
                $posts->add(
                    Url::create(route('Blog.Post', $item->only('id', 'slug')))
                        ->setLastModificationDate($item->updated_at)
                );
            });
            $posts->writeToFile(public_path('posts_sitemap.xml'));
            $this->info('Blog Posts added to posts_sitemap.xml');

            SM::create()
                ->add(Url::create(route('Home'))->setChangeFrequency('weekly'))
                ->add(Url::create(route('Questions.Forum'))->setChangeFrequency('weekly'))
                ->add(Url::create(route('Job.Circulars'))->setChangeFrequency('weekly'))
                ->add(Url::create(route('Courses'))->setChangeFrequency('weekly'))
                ->add(Url::create(route('Blog.Posts'))->setChangeFrequency('weekly'))
                ->add(Url::create(route('About'))->setChangeFrequency('weekly'))
                ->writeToFile(public_path('pages_sitemap.xml'));
            $this->info('Pages added to pages_sitemap.xml');


        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}
