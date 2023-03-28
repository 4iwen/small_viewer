<?php
require_once "../bootstrap/bootstrap.php";

class IndexPage extends Page
{
    public string $title = "Prohlížeč databáze";

    protected function pageBody(): string
    {
        return "<a class='a-no-decoration' href='https://github.com/4iwen/small_viewer/'>github</a>";
    }
}

$page = new IndexPage();
$page->render();
