<?php
declare(strict_types=1);


namespace InteropApp\Infrastructure\UI\HTTP\Presenters\Homepage;


use InteropApp\Domain\Post\Page;
use InteropApp\Infrastructure\UI\HTTP\UrlFactory;

class Presenter implements \InteropApp\Application\Usecases\ShowPage\Presenter
{
    /** @var ViewModel */
    protected $viewModel;
    /** @var UrlFactory */
    protected $urlFactory;

    public function __construct(UrlFactory $urlFactory) { $this->urlFactory = $urlFactory; }

    public function present(Page $page): void
    {
        $this->viewModel = new ViewModel();

        for ($i = 0; $i < $page->pages(); $i++) {
            $this->viewModel->pages[] = (object)[
                'number' => $i + 1,
                'isCurrent' => ($i + 1) === $page->page(),
                'url' => $this->urlFactory->makePageUrl($page->page())
            ];
        }

        foreach ($page->posts() as $post) {
            $this->viewModel->posts[] = (object)[
                'title' => $post->meta()->title(),
                'date' => $post->meta()->publish()->format('l, d M Y'),
                'url' => $this->urlFactory->makePostUrl($post->meta()),
            ];
        }
    }

    public function viewModel(): ViewModel
    {
        return $this->viewModel;
    }
}