<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkCommentOwner')->only('edit');
    }
    
    /**
     * Menyimpan data komentar kedalam database
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment'=>'required'
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->input('post_id'),
            'upload_id' => $request->input('upload_id'),
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('status', 'Successfully added your comment!');
    }

    /**
     * Menampilkan halaman edit komentar
     */
    public function edit(Comment $comment)
    {
        return view('comment.edit', compact('comment'));
    }

    /**
     * Memperbarui data komentar kedalam database
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        Comment::where('id', $comment->id)->update([
            'comment' => $request->comment
        ]);

        if($comment->post_id){
            
            return redirect()->route('post', $comment->post_id)->with('status', 'Successfully updated your comment!');

        } else if($comment->upload_id){

            return redirect()->route('video', $comment->upload_id)->with('status', 'Successfully updated your comment!');
        }
    }

    /**
     * Menghapus data komentar dari database
     */
    public function destroy(Comment $comment)
    {
        Comment::where('parent_id', '=', $comment->id)->delete();
        Comment::destroy($comment->id);

        if($comment->post_id){
            
            return redirect()->route('post', $comment->post_id)->with('status', 'Successfully deleted your comment!');

        } else if($comment->upload_id){

            return redirect()->route('video', $comment->upload_id)->with('status', 'Successfully deleted your comment!');
        }
    }

    /**
     * Menyimpan data balas komentar kedalam database
     */
    public function replystore(Request $request)
    {
        $request->validate([
            'comment'=>'required'
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->input('post_id'),
            'upload_id' => $request->input('upload_id'),
            'parent_id' => $request->input('parent_id'),
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('status', 'Successfully added your reply!');
    }
}