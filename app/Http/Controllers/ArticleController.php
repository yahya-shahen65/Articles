<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        return view('articles.articles',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'title'=>['required', 'string', 'max:255'],
                'body'=>['required', 'string', 'max:255'],
                'description'=>['required', 'string', 'max:255'],
                // 'image'=>['rquired'],
            ]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(['errors'=>$e->getMessage()]);
        }
        if(!empty($request->image)){
            $file=$request->file('image');
            $name=$file->getClientOriginalName();
            Article::create([
                'title'=>$request->title,
                'body'=>$request->body,
                'description'=>$request->description,
                'user_id'=>$request->user_id,
                'image'=>$name
            ]);
            $file->storeAs(Auth::user()->id.'/'.$request->title,$name,'images');
            session()->flash('add','add successfully');
            return redirect()->back();
        }
        Article::create([
            'title'=>$request->title,
            'body'=>$request->body,
            'description'=>$request->description,
            'user_id'=>$request->user_id,
        ]);
        session()->flash('add','add successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article=Article::find($id);
        $user=User::find($article->user_id);
        return view('articles.show',compact('article','user'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{

            $request->validate([
                'body'=>['required', 'string', 'max:255'],
                'description'=>['required', 'string', 'max:255'],
            ]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(['errors'=>$e->getMessage()]);
        }
        $article=Article::find($request->id);
        if(Auth::user()->id ==$article->user_id){
            if(!empty($request->image) && $request->img==null){
                // dd($request->image);
                $file=$request->file('image');
                $name=$file->getClientOriginalName();
                $file->storeAs($article->user_id .'/'.$request->title,$name,'images');
                $article->update([
                    'body'=>$request->body,
                    'description'=>$request->description,
                    'image'=>$name
                ]);
                session()->flash('edit','edit successfully');
                return redirect()->back();
            }
            if(!empty($request->image)){
                $file=$request->file('image');
                $name_img=$article->image;
                $name=$file->getClientOriginalName();
                Storage::disk('images')->delete($article->user_id .'/'.$article->title .'/'.$name_img);
                $file->storeAs($article->user_id .'/'.$request->title,$name,'images');
            }
            else{
                $article->update([
                    'body'=>$request->body,
                    'description'=>$request->description,
                ]);
                session()->flash('edit','edit successfully');
                return redirect()->back();
            }
            $article->update([
                'body'=>$request->body,
                'description'=>$request->description,
                'image'=>$name
            ]);
            session()->flash('edit','edit successfully');
            return redirect()->back();
        }
        else{
            session()->flash('not_allow','not allow to edit this article');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $article=Article::find($request->id);
        $name=$article->image;
        if(Auth::user()->id ==$article->user_id){
            Storage::disk('images')->deleteDirectory ($article->user_id .'/'.$article->title);
            Article::find($request->id)->delete();
            session()->flash('delete','the article deleted ');
            return redirect()->back();
        }
        else{
            session()->flash('not_allow','not allow to delete this article');
            return redirect()->back();
        }
    }
}
