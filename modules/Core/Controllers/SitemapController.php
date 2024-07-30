<?php


namespace Modules\Core\Controllers;


use Modules\Core\Helpers\SitemapHelper;
use Modules\FrontendController;

class SitemapController extends FrontendController
{

    protected $sitemapHelper;

    public function index(SitemapHelper $sitemapHelper){

       $all = $sitemapHelper->all();
       if(empty($all)) abort(404);

       return response(view('Core::frontend.sitemap',['rows'=>$all])->render(),200,[
            'Content-Type' => 'application/xml']);
    }

    public function path(SitemapHelper $sitemapHelper,$path_id){

        $rows =  $sitemapHelper->path($path_id);
        if(empty($rows)) abort(404);

        return response(view('Core::frontend.sitemap-path',['rows'=>$rows])->render(),200,[
            'Content-Type' => 'application/xml']);
    }
}
