<?php
declare(strict_types=1);


namespace InteropApp\Application\Usecases\ShowPage;


use InteropApp\Domain\Post\Page;

// Presenter creates yet another model - ViewModel for the view to render
interface Presenter
{
    public function present(Page $page): void;
}