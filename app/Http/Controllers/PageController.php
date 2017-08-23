<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\DomCrawler\Crawler;

class PageController extends Controller
{

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * PageController constructor.
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Shows a certain page from blade or markdown files.
     *
     * @param $page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function showPage($page)
    {
        if (view()->exists('pages.' . $page))
            return view('pages.' . $page);

        $path = base_path('resources/pages/' . app()->getLocale() . '/' . $page . '.md');
        $fallback_path = base_path('resources/pages/' . config('app.fallback_locale') . '/' . $page . '.md');

        if ($this->files->exists($path)) {
            $content = markdown($this->files->get($path));
            $crawler = new Crawler();
            $crawler->addHtmlContent($content);
            $title = $crawler->filterXPath('//h1')->text();

            return view('pages.index', compact('content', 'title'));
        }

        if ($this->files->exists($fallback_path)) {
            $content = markdown($this->files->get($fallback_path));
            $crawler = new Crawler();
            $crawler->addHtmlContent($content);
            $title = $crawler->filterXPath('//h1')->text();

            return view('pages.index', compact('content', 'title'));
        }

        return abort(404);
    }
}
