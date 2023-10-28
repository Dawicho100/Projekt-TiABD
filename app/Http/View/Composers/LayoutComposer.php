<?php
use App\Page;
use Illuminate\View\View;

class LayoutComposer
{
    public function compose(View $view)
    {
        $pages = Page::all();
        $view->with('pages', $pages);
    }
    public function register()
    {
        view()->composer('Components.layout', LayoutComposer::class);
    }
}
