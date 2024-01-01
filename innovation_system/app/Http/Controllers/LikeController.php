<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menyimpan data like kedalam database
     */
    public function store(Request $request)
    {
        Like::create([
            'user_id' => auth()->id(),
            'post_id' => $request->input('post_id'),
            'upload_id' => $request->input('upload_id'),
            'like' => 1
        ]);

        if($request->post_id){
            
            return redirect()->back()->with('status', 'You\'ve liked this idea!');

        } else if($request->upload_id){

            return redirect()->back()->with('status', 'You\'ve liked this video!');
        }
    }

    /**
     * Menghapus data like dari database
     */
    public function destroy(Like $like)
    {
        Like::destroy($like->id);

        if($like->post_id){
            
            return redirect()->back()->with('status', 'You\'ve unliked this idea!');

        } else if($like->upload_id){

            return redirect()->back()->with('status', 'You\'ve unliked this video!');
        }
    }
}