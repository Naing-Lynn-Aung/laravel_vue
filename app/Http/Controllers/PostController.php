<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Exports\PostsExport;
use App\Imports\PostsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        if( $user->user_type == 0){
            if(request('search')){
                return Post::where('title', 'like', '%'. request('search'). '%')
                         ->orderBy('id', 'desc')->get();
             }
             return Post::orderBy('id','desc')->get();
        }
        if(request('search')){
            return Post::where('title', 'like', '%'. request('search'). '%')
                     ->orderBy('id', 'desc')->get();
         }
         return Post::where('created_user_id', $id)->orderBy('id','desc')->get();
        
    }
    public function show(Post $post)
    {
        return $post;
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable'
        ]);
        $requestData =$request->all();
        $requestData['created_user_id'] = Auth::user()->id;
        if($request->hasFile('image')){
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $fileName);
            $requestData['image'] = '/images/'.$fileName;
        }
        return Post::create($requestData);
    }

    public function update(Request $request)
    {
        $post = Post::find($request->id);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        
        $requestData =$request->all();
        $requestData['created_user_id'] = Auth::user()->id;
        if($request->hasFile('image')) {
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $fileName);
            $requestData['image'] = '/images/'.$fileName;
        }
        return $post->update($requestData);
    }
    public function destroy(Post $post)
    {
        return $post->delete();
    }

    public function import_file(){
        return view('layouts.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import' => 'required|mimes:xls,xlsx,csv,pdf'
        ]);
        $rows = [];
        $path = $request->file('import')->getRealPath();
        $records = array_map('str_getcsv', file($path));
        if(!count($records) > 0){
            return 'Error';
        }
        $fields = array_map('strtolower', $records[0]);
        array_shift($records);

        foreach ($records as $record) {
            if(count($fields) != count($record)){
                return redirect('/')->with('error', 'Csv upload invalid data');
            }
            $record = array_map("html_entity_decode", $record);
            $record = array_combine($fields, $record);
            $rows[] = $record;
        }
        foreach($rows as $row){
            
            Post::updateOrCreate([
                'title' => $row['title'],
                'description' => $row['description'],
                'image' => $row['image'],
                'created_user_id' => $row['userid'],
            ]);
        }
        return redirect('/api/posts');   
      
    }

    public function export()
    {
        return Excel::download(new PostsExport, 'posts.csv');
    }
}
