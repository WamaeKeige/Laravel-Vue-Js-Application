<?php

namespace App\Http\Controllers;
use App\Article;
use App\Http\Requests;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //display and paginate array
        $articles = Article::orderBy('created_at', 'desc')->paginate(5);
        return ArticleResource::collection($articles);
    }
    public function store(Request $request)
    {
        //create and editing
        $article = $request->isMethod('put') ? Article::findOrFail
        ($request->article_id) : new Article;

        $article->id = $request->input('article_id');
        $article->title = $request->input('title');
        $article->body = $request->input('body');

        if($article -> save()){
          return new ArticleResources($article);
        }
    }
    public function show($id)
    {
      //show specific
      $article = Article::findOrFail($id);
      return new ArticleResource($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete
        $article = Article::findOrFail($id);
        if($article -> delete()){
            return new ArticleResource($article);
        }

    }
}
