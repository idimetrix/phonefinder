<?php

namespace App\Http\Controllers;

use App\Helpers\DataCacheHelper;
use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    private $image;
    private $google_analytics;

    public function __construct()
    {
        $this->image            = DataCacheHelper::getAds('image logo')->value;
        $this->google_analytics = DataCacheHelper::getAds('google analytics');
    }

    public function index()
    {
        return view('pages.articles', [
            'articles'         => Article::orderBy('created_at',
                'DESC')->withCount('articleComments')->with('user')->paginate(10),
            'image'            => $this->image,
            'google_analytics' => $this->google_analytics,
            'team'             => DataCacheHelper::getAds('team name')
        ]);
    }

    public function create()
    {
        return view('pages.article_create', [
            'image'            => $this->image,
            'google_analytics' => $this->google_analytics
        ]);
    }

    public function store(Request $request)
    {
        Article::create(array_merge(['user_id' => Auth::id()], $request->all()));

        return redirect('blog');
    }

    public function show($id)
    {
        return view('pages.article_show', [
            'article'          => Article::with('articleComments')->with('user')->find($id),
            'comments'         => Article::find($id)->articleComments()->paginate(10),
            'image'            => $this->image,
            'google_analytics' => $this->google_analytics,
            'team'             => DataCacheHelper::getAds('team name')

        ]);
    }

    public function edit($id)
    {
        return view('pages.article_edit', [
            'article'          => Article::find($id),
            'image'            => $this->image,
            'google_analytics' => $this->google_analytics
        ]);
    }

    public function update(Request $request, $id)
    {
        Article::find($id)->update($request->all());

        return redirect('blog');
    }

    public function destroy($id)
    {
        Article::destroy($id);
        ArticleComment::where('article_id', $id)->delete();

        return redirect('blog');
    }

    public function storeComment(Request $request, $id)
    {
        ArticleComment::create(array_merge(['article_id' => $id], $request->all()));

        return redirect('blog/' . $id);
    }
}
