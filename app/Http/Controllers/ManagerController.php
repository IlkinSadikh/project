<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function createArticle(Request $request)
    {
        //validation
        $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
        ]);

        return Article::create([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ]);
    }

    public function getArticle(Request $request)
    {
        return Article::orderBy('id', 'desc')->get();
    }

    public function editArticle(Request $request)
    {
        //validation
        $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
        ]);
        return Article::where('id', $request->id)->update([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ]);
    }

    public function deleteArticle(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        return Article::where('id', $request->id)->delete();
    }
}
