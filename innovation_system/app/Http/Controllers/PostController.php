<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Storage;
use App\Post;
use App\Category;
use App\Stage1;
use App\Stage2;
use App\Stage3;
use App\Stage4;
use App\Stage5;
use App\Review;
use App\Like;
use App\Comment;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
        $this->middleware(['checkPostOwner', 'checkPostStage:1'])->only('edit', 'update', 'destroy_img', 'destroy_file');
        $this->middleware(['checkPostOwner', 'checkPostStage:2'])->only('edit2', 'update2', 'destroy_img2', 'destroy_file2', 'resetpost2');
        $this->middleware(['checkPostOwner', 'checkPostStage:3'])->only('edit3', 'update3', 'destroy_img3', 'destroy_file3', 'resetpost3');
        $this->middleware(['checkPostOwner', 'checkPostStage:4'])->only('edit4', 'update4', 'destroy_img4', 'destroy_file4', 'resetpost4');
        $this->middleware(['checkPostOwner', 'checkPostStage:5'])->only('edit5', 'update5', 'destroy_img5', 'destroy_file5', 'resetpost5');
        $this->middleware('checkPostOwner')->only('destroyidea');
        $this->middleware(['checkRole:Administrator' || 'checkRole:Master', 'checkPostStage:1'])->only('updatestatus');
        $this->middleware(['checkRole:Administrator' || 'checkRole:Master', 'checkPostStage:2'])->only('updatestatus2');
        $this->middleware(['checkRole:Administrator' || 'checkRole:Master', 'checkPostStage:3'])->only('updatestatus3');
        $this->middleware(['checkRole:Administrator' || 'checkRole:Master', 'checkPostStage:4'])->only('updatestatus4');
        $this->middleware(['checkRole:Administrator' || 'checkRole:Master', 'checkPostStage:5'])->only('updatestatus5');
        $this->middleware('checkPostReviewOwner')->only(
            'approvestatus', 'disapprovestatus', 'declinestatus', 'rereviewstatus', 'destroystatus',
            'approvestatus2', 'disapprovestatus2', 'declinestatus2', 'rereviewstatus2', 'destroystatus2',
            'approvestatus3', 'disapprovestatus3', 'declinestatus3', 'rereviewstatus3', 'destroystatus3',
            'approvestatus4', 'disapprovestatus4', 'declinestatus4', 'rereviewstatus4', 'destroystatus4',
            'approvestatus5', 'disapprovestatus5', 'declinestatus5', 'rereviewstatus5', 'destroystatus5'
        );
    }
    
    /**
     * Menampilkan halaman Bank of Idea
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();

        return view('bankofidea.index', compact('posts'));
    }

    /**
     * Menampilkan halaman membuat Post
     */
    public function create()
    {
        $categories = Category::all();

        return view('bankofidea.submit', compact('categories'));
    }

    /**
     * Menyimpan data Post kedalam database
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_img' => 'nullable|image|max:20000|mimes:jpeg,jpg,png,svg,bmp',
            'category_id' => 'required',
            'title' => 'required|max:191',
            'description' => 'required',
            'post_file' => 'nullable|file|max:100000|mimes:pdf,jpeg,jpg,png,svg,bmp',
            'contributor' => 'nullable|max:191'
        ]);

        // Upload Files
        $postpicture_field = $request->file('post_img');
        $supportingfile_field = $request->file('post_file');

        if($postpicture_field && $supportingfile_field){

            $review = Review::create();

            $post_img = $request->file('post_img')->store('bank of idea');
            $post_file = $request->file('post_file')->store('bank of idea');

            $stage1 = Stage1::create([
                'post_img' => $post_img,
                'title' => $request->title,
                'description' => $request->description,
                'post_file' => $post_file,
                'review_id' => $review->id
            ]);

        } elseif($postpicture_field){

            $review = Review::create();

            $post_img = $request->file('post_img')->store('bank of idea');

            $stage1 = Stage1::create([
                'post_img' => $post_img,
                'title' => $request->title,
                'description' => $request->description,
                'review_id' => $review->id
            ]);

        } elseif($supportingfile_field){

            $review = Review::create();

            $post_file = $request->file('post_file')->store('bank of idea');

            $stage1 = Stage1::create([
                'title' => $request->title,
                'description' => $request->description,
                'post_file' => $post_file,
                'review_id' => $review->id
            ]);

        } else {

            $review = Review::create();

            $stage1 = Stage1::create([
                'title' => $request->title,
                'description' => $request->description,
                'review_id' => $review->id
            ]);
        }

        $review2 = Review::create();

        $stage2 = Stage2::create([
            'post_img' => NULL,
            'title' => NULL,
            'description' => NULL,
            'post_file' => NULL,
            'review_id' => $review2->id
        ]);

        $review3 = Review::create();

        $stage3 = Stage3::create([
            'post_img' => NULL,
            'title' => NULL,
            'description' => NULL,
            'post_file' => NULL,
            'review_id' => $review3->id
        ]);

        $review4 = Review::create();

        $stage4 = Stage4::create([
            'post_img' => NULL,
            'title' => NULL,
            'description' => NULL,
            'post_file' => NULL,
            'review_id' => $review4->id
        ]);

        $review5 = Review::create();

        $stage5 = Stage5::create([
            'post_img' => NULL,
            'title' => NULL,
            'description' => NULL,
            'post_file' => NULL,
            'review_id' => $review5->id
        ]);

        $idea = Post::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'contributor' => $request->contributor,
            'stage1_id' => $stage1->id,
            'stage2_id' => $stage2->id,
            'stage3_id' => $stage3->id,
            'stage4_id' => $stage4->id,
            'stage5_id' => $stage5->id
        ]);

        // Insert Season
        if($idea->created_at->format('n') == 3 || $idea->created_at->format('n') == 4 || $idea->created_at->format('n') == 5){
            $idea->update([
                'season' => 'Spring'
            ]);
        } elseif($idea->created_at->format('n') == 6 || $idea->created_at->format('n') == 7 || $idea->created_at->format('n') == 8){
            $idea->update([
                'season' => 'Summer'
            ]);
        } elseif($idea->created_at->format('n') == 9 || $idea->created_at->format('n') == 10 || $idea->created_at->format('n') == 11){
            $idea->update([
                'season' => 'Autumn'
            ]);
        } else {
            $idea->update([
                'season' => 'Winter'
            ]);
        }
            
        return redirect()->route('bankofidea')->with('status', 'Successfully submitted your idea!');
    }

    /**
     * Menampilkan halaman Post
     */
    public function show(Post $post)
    {
        $totallike = Like::where('post_id', $post->id)->count();
        $likers = Like::where('post_id', $post->id)->get();

        $comments = Comment::where('post_id', $post->id)->get();
        $totalcomment = Comment::where('post_id', $post->id)->count();

        return view('bankofidea.idea', compact('post', 'totallike', 'likers', 'comments', 'totalcomment'));
    }

    /**
     * Menampilkan halaman edit Post Stage 1
     */
    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('bankofidea.stage1panel', compact('post', 'categories'));
    }

    /**
     * Memperbarui data Post Stage 1 kedalam database
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'post_img' => 'nullable|image|max:20000|mimes:jpeg,jpg,png,svg,bmp',
            'category_id' => 'required',
            'title' => 'required|max:191',
            'description' => 'required',
            'post_file' => 'nullable|file|max:100000|mimes:pdf,jpeg,jpg,png,svg,bmp',
            'contributor' => 'nullable|max:191'
        ]);

        // Upload Files
        $postpicture_field = $request->file('post_img');
        $supportingfile_field = $request->file('post_file');

        if($postpicture_field && $supportingfile_field){

            if($post->stage1->post_img && $post->stage1->post_file){
                Storage::delete($post->stage1->post_img, $post->stage1->post_file);
            }

            $post_img = $request->file('post_img')->store('bank of idea');
            $post_file = $request->file('post_file')->store('bank of idea');

            Stage1::where('id', $post->stage1_id)->update([
                'post_img' => $post_img,
                'title' => $request->title,
                'description' => $request->description,
                'post_file' => $post_file
            ]);

        } elseif($postpicture_field){

            if($post->stage1->post_img){
                Storage::delete($post->stage1->post_img);
            }

            $post_img = $request->file('post_img')->store('bank of idea');

            Stage1::where('id', $post->stage1_id)->update([
                'post_img' => $post_img,
                'title' => $request->title,
                'description' => $request->description
            ]);

        } elseif($supportingfile_field){

            if($post->stage1->post_file){
                Storage::delete($post->stage1->post_file);
            }

            $post_file = $request->file('post_file')->store('bank of idea');

            Stage1::where('id', $post->stage1_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'post_file' => $post_file
            ]);

        } else {

            Stage1::where('id', $post->stage1_id)->update([
                'title' => $request->title,
                'description' => $request->description 
            ]);
        }

        $category_field = $request->category_id;

        if($category_field){
            
            Post::where('id', $post->id)->update([
                'contributor' => $request->contributor,
            ]);

        }

        Post::where('id', $post->id)->update([
            'category_id' => $request->category_id,
            'contributor' => $request->contributor
        ]);

        return redirect()->route('post', $post->id)->with('status', 'Successfully updated your idea!');
    }

    /**
     * Menghapus data gambar Post Stage 1 dari database
     */
    public function destroy_img(Post $post)
    {
        if($post->stage1->post_img){
            Storage::delete($post->stage1->post_img);

        }

        Stage1::where('id', $post->stage1_id)->update([
            'post_img' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully removed your picture!');
    }

    /**
     * Menghapus data file Post Stage 1 dari database
     */
    public function destroy_file(Post $post)
    {
        if($post->stage1->post_file){
            Storage::delete($post->stage1->post_file);

        }

        Stage1::where('id', $post->stage1_id)->update([
            'post_file' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully removed your file!');
    }

    /**
     * Menampilkan halaman edit Post Stage 2
     */
    public function edit2(Post $post)
    {
        return view('bankofidea.stage2panel', compact('post'));
    }

    /**
     * Memperbarui data Post Stage 2 kedalam database
     */
    public function update2(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'nullable|max:191',
            'post_img' => 'nullable|image|max:20000|mimes:jpeg,jpg,png,svg,bmp',
            'description' => 'nullable',
            'post_file' => 'nullable|file|max:100000|mimes:pdf,jpeg,jpg,png,svg,bmp'
        ]);

        // Upload Files
        $postpicture_field = $request->file('post_img');
        $supportingfile_field = $request->file('post_file');

        if($postpicture_field && $supportingfile_field){

            if($post->stage2->post_img && $post->stage2->post_file){
                Storage::delete($post->stage2->post_img, $post->stage2->post_file);
            }

            $post_img = $request->file('post_img')->store('bank of idea');
            $post_file = $request->file('post_file')->store('bank of idea');

            Stage2::where('id', $post->stage2_id)->update([
                'post_img' => $post_img,
                'title' => $request->title,
                'description' => $request->description,
                'post_file' => $post_file
            ]);

        } elseif($postpicture_field){

            if($post->stage2->post_img){
                Storage::delete($post->stage2->post_img);
            }

            $post_img = $request->file('post_img')->store('bank of idea');

            Stage2::where('id', $post->stage2_id)->update([
                'post_img' => $post_img,
                'title' => $request->title,
                'description' => $request->description
            ]);

        } elseif($supportingfile_field){

            if($post->stage2->post_file){
                Storage::delete($post->stage2->post_file);
            }

            $post_file = $request->file('post_file')->store('bank of idea');

            Stage2::where('id', $post->stage2_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'post_file' => $post_file
            ]);

        } else {

            Stage2::where('id', $post->stage2_id)->update([
                'title' => $request->title,
                'description' => $request->description 
            ]);
        }

        return redirect()->route('post', $post->id)->with('status', 'Successfully updated your idea!');
    }

    /**
     * Menghapus data gambar Post Stage 2 dari database
     */
    public function destroy_img2(Post $post)
    {
        if($post->stage2->post_img){
            Storage::delete($post->stage2->post_img);

        }

        Stage2::where('id', $post->stage2_id)->update([
            'post_img' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully removed your picture!');
    }

    /**
     * Menghapus data file Post Stage 2 dari database
     */
    public function destroy_file2(Post $post)
    {
        if($post->stage2->post_file){
            Storage::delete($post->stage2->post_file);

        }

        Stage2::where('id', $post->stage2_id)->update([
            'post_file' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully removed your file!');
    }

    /**
     * Menghapus data Post Stage 2 dari database
     */
    public function resetpost2(Post $post)
    {
        Storage::delete($post->stage2->post_img, $post->stage2->post_file);

        Stage2::where('id', $post->stage2_id)->update([
            'title' => NULL,
            'post_img' => NULL,
            'description' => NULL,
            'post_file' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully resetted your idea!');
    }

    /**
     * Menampilkan halaman edit Post Stage 3
     */
    public function edit3(Post $post)
    {
        return view('bankofidea.stage3panel', compact('post'));
    }

    /**
     * Memperbarui data Post Stage 3 kedalam database
     */
    public function update3(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'nullable|max:191',
            'post_img' => 'nullable|image|max:20000|mimes:jpeg,jpg,png,svg,bmp',
            'description' => 'nullable',
            'post_file' => 'nullable|file|max:100000|mimes:pdf,jpeg,jpg,png,svg,bmp'
        ]);

        // Upload Files
        $postpicture_field = $request->file('post_img');
        $supportingfile_field = $request->file('post_file');

        if($postpicture_field && $supportingfile_field){

            if($post->stage3->post_img && $post->stage3->post_file){
                Storage::delete($post->stage3->post_img, $post->stage3->post_file);
            }

            $post_img = $request->file('post_img')->store('bank of idea');
            $post_file = $request->file('post_file')->store('bank of idea');

            Stage3::where('id', $post->stage3_id)->update([
                'post_img' => $post_img,
                'title' => $request->title,
                'description' => $request->description,
                'post_file' => $post_file
            ]);

        } elseif($postpicture_field){

            if($post->stage3->post_img){
                Storage::delete($post->stage3->post_img);
            }

            $post_img = $request->file('post_img')->store('bank of idea');

            Stage3::where('id', $post->stage3_id)->update([
                'post_img' => $post_img,
                'title' => $request->title,
                'description' => $request->description
            ]);

        } elseif($supportingfile_field){

            if($post->stage3->post_file){
                Storage::delete($post->stage3->post_file);
            }

            $post_file = $request->file('post_file')->store('bank of idea');

            Stage3::where('id', $post->stage3_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'post_file' => $post_file
            ]);

        } else {

            Stage3::where('id', $post->stage3_id)->update([
                'title' => $request->title,
                'description' => $request->description 
            ]);
        }

        return redirect()->route('post', $post->id)->with('status', 'Successfully updated your idea!');
    }

    /**
     * Menghapus data gambar Post Stage 3 dari database
     */
    public function destroy_img3(Post $post)
    {
        if($post->stage3->post_img){
            Storage::delete($post->stage3->post_img);

        }

        Stage3::where('id', $post->stage3_id)->update([
            'post_img' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully removed your picture!');
    }

    /**
     * Menghapus data file Post Stage 3 dari database
     */
    public function destroy_file3(Post $post)
    {
        if($post->stage3->post_file){
            Storage::delete($post->stage3->post_file);

        }

        Stage3::where('id', $post->stage3_id)->update([
            'post_file' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully removed your file!');
    }

    /**
     * Menghapus data Post Stage 3 dari database
     */
    public function resetpost3(Post $post)
    {
        Storage::delete($post->stage3->post_img, $post->stage3->post_file);

        Stage3::where('id', $post->stage3_id)->update([
            'title' => NULL,
            'post_img' => NULL,
            'description' => NULL,
            'post_file' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully resetted your idea!');
    }

    /**
     * Menampilkan halaman edit Post Stage 4
     */
    public function edit4(Post $post)
    {
        return view('bankofidea.stage4panel', compact('post'));
    }

    /**
     * Memperbarui data Post Stage 4 kedalam database
     */
    public function update4(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'nullable|max:191',
            'post_img' => 'nullable|image|max:20000|mimes:jpeg,jpg,png,svg,bmp',
            'description' => 'nullable',
            'post_file' => 'nullable|file|max:100000|mimes:pdf,jpeg,jpg,png,svg,bmp'
        ]);

        // Upload Files
        $postpicture_field = $request->file('post_img');
        $supportingfile_field = $request->file('post_file');

        if($postpicture_field && $supportingfile_field){

            if($post->stage4->post_img && $post->stage4->post_file){
                Storage::delete($post->stage4->post_img, $post->stage4->post_file);
            }

            $post_img = $request->file('post_img')->store('bank of idea');
            $post_file = $request->file('post_file')->store('bank of idea');

            Stage4::where('id', $post->stage4_id)->update([
                'post_img' => $post_img,
                'title' => $request->title,
                'description' => $request->description,
                'post_file' => $post_file
            ]);

        } elseif($postpicture_field){

            if($post->stage4->post_img){
                Storage::delete($post->stage4->post_img);
            }

            $post_img = $request->file('post_img')->store('bank of idea');

            Stage4::where('id', $post->stage4_id)->update([
                'post_img' => $post_img,
                'title' => $request->title,
                'description' => $request->description
            ]);

        } elseif($supportingfile_field){

            if($post->stage4->post_file){
                Storage::delete($post->stage4->post_file);
            }

            $post_file = $request->file('post_file')->store('bank of idea');

            Stage4::where('id', $post->stage4_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'post_file' => $post_file
            ]);

        } else {

            Stage4::where('id', $post->stage4_id)->update([
                'title' => $request->title,
                'description' => $request->description 
            ]);
        }

        return redirect()->route('post', $post->id)->with('status', 'Successfully updated your idea!');
    }

    /**
     * Menghapus data gambar Post Stage 4 dari database
     */
    public function destroy_img4(Post $post)
    {
        if($post->stage4->post_img){
            Storage::delete($post->stage4->post_img);

        }

        Stage4::where('id', $post->stage4_id)->update([
            'post_img' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully removed your picture!');
    }

    /**
     * Menghapus data file Post Stage 4 dari database
     */
    public function destroy_file4(Post $post)
    {
        if($post->stage4->post_file){
            Storage::delete($post->stage4->post_file);

        }

        Stage4::where('id', $post->stage4_id)->update([
            'post_file' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully removed your file!');
    }

    /**
     * Menghapus data Post Stage 4 dari database
     */
    public function resetpost4(Post $post)
    {
        Storage::delete($post->stage4->post_img, $post->stage4->post_file);

        Stage4::where('id', $post->stage4_id)->update([
            'title' => NULL,
            'post_img' => NULL,
            'description' => NULL,
            'post_file' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully resetted your idea!');
    }

    /**
     * Menampilkan halaman edit Post Stage 5
     */
    public function edit5(Post $post)
    {
        return view('bankofidea.stage5panel', compact('post'));
    }

    /**
     * Memperbarui data Post Stage 5 kedalam database
     */
    public function update5(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'nullable|max:191',
            'post_img' => 'nullable|image|max:20000|mimes:jpeg,jpg,png,svg,bmp',
            'description' => 'nullable',
            'post_file' => 'nullable|file|max:100000|mimes:pdf,jpeg,jpg,png,svg,bmp'
        ]);

        // Upload Files
        $postpicture_field = $request->file('post_img');
        $supportingfile_field = $request->file('post_file');

        if($postpicture_field && $supportingfile_field){

            if($post->stage5->post_img && $post->stage5->post_file){
                Storage::delete($post->stage5->post_img, $post->stage5->post_file);
            }

            $post_img = $request->file('post_img')->store('bank of idea');
            $post_file = $request->file('post_file')->store('bank of idea');

            Stage5::where('id', $post->stage5_id)->update([
                'post_img' => $post_img,
                'title' => $request->title,
                'description' => $request->description,
                'post_file' => $post_file
            ]);

        } elseif($postpicture_field){

            if($post->stage5->post_img){
                Storage::delete($post->stage5->post_img);
            }

            $post_img = $request->file('post_img')->store('bank of idea');

            Stage5::where('id', $post->stage5_id)->update([
                'post_img' => $post_img,
                'title' => $request->title,
                'description' => $request->description
            ]);

        } elseif($supportingfile_field){

            if($post->stage5->post_file){
                Storage::delete($post->stage5->post_file);
            }

            $post_file = $request->file('post_file')->store('bank of idea');

            Stage5::where('id', $post->stage5_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'post_file' => $post_file
            ]);

        } else {

            Stage5::where('id', $post->stage5_id)->update([
                'title' => $request->title,
                'description' => $request->description 
            ]);
        }

        return redirect()->route('post', $post->id)->with('status', 'Successfully updated your idea!');
    }

    /**
     * Menghapus data gambar Post Stage 5 dari database
     */
    public function destroy_img5(Post $post)
    {
        if($post->stage5->post_img){
            Storage::delete($post->stage5->post_img);

        }

        Stage5::where('id', $post->stage5_id)->update([
            'post_img' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully removed your picture!');
    }

    /**
     * Menghapus data file Post Stage 5 dari database
     */
    public function destroy_file5(Post $post)
    {
        if($post->stage5->post_file){
            Storage::delete($post->stage5->post_file);

        }

        Stage5::where('id', $post->stage5_id)->update([
            'post_file' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully removed your file!');
    }
 
    /**
     * Menghapus data Post Stage 5 dari database
     */
    public function resetpost5(Post $post)
    {
        Storage::delete($post->stage5->post_img, $post->stage5->post_file);
        
        Stage5::where('id', $post->stage5_id)->update([
            'title' => NULL,
            'post_img' => NULL,
            'description' => NULL,
            'post_file' => NULL
            ]);
            
            return redirect()->back()->with('status', 'Successfully resetted your idea!');
    }
        
    /**
     * Menghapus data Post dari database
     */
    public function destroyidea(Post $post)
    {
        Comment::where('post_id', $post->id)->delete();
        Like::where('post_id', $post->id)->delete();

        Review::destroy($post->stage1->review_id, $post->stage2->review_id, $post->stage3->review_id, $post->stage4->review_id, $post->stage5->review_id);

        Storage::delete($post->stage1->post_img, $post->stage1->post_file, $post->stage2->post_img, $post->stage2->post_file, $post->stage3->post_img, $post->stage3->post_file, $post->stage4->post_img, $post->stage4->post_file, $post->stage5->post_img, $post->stage5->post_file);
        
        Stage5::destroy($post->stage5_id);
        Stage4::destroy($post->stage4_id);
        Stage3::destroy($post->stage3_id);
        Stage2::destroy($post->stage2_id);
        Stage1::destroy($post->stage1_id);
        Post::destroy($post->id);

        return redirect()->route('bankofidea')->with('status', 'Successfully deleted your idea!');
    }

    /**
     * Memperbarui data status review Stage 1 dari 'Waiting' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function updatestatus(Post $post)
    {
        $reviewer = Auth::user();

        Review::where('id', $post->stage1->review_id)->update([
            'switch' => 1,
            'status' => 'In Progress',
            'reviewerid' => $reviewer->id,
            'reviewername' => $reviewer->name,
            'reviewerunit' => $reviewer->unit->name
        ]);

        return redirect()->back()->with('status', 'You are now the reviewer of this idea!');
    }

    /**
     * Memperbarui data status review Stage 1 dari 'In Progress' menjadi 'Approved' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function approvestatus(Post $post)
    {
        Review::where('id', $post->stage1->review_id)->update([
            'status' => 'Approved'
        ]);

        Post::where('id', $post->id)->update([
            'stage' => $post->stage+1
        ]);
            
        return redirect()->back()->with('status', 'Successfully approved this idea!');
    }

    /**
     * Memperbarui data status review Stage 1 dari 'Approved' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function disapprovestatus(Post $post)
    {
        Storage::delete($post->stage2->post_img, $post->stage2->post_file);

        Stage2::where('id', $post->stage2_id)->update([
            'title' => NULL,
            'post_img' => NULL,
            'description' => NULL,
            'post_file' => NULL
        ]);

        Review::where('id', $post->stage1->review_id)->update([
            'status' => 'In Progress'
        ]);

        Post::where('id', $post->id)->update([
            'stage' => $post->stage-1
        ]);
            
        return redirect()->back()->with('status', 'Successfully disapproved this idea!');
    }

    /**
     * Memperbarui data status review Stage 1 dari 'In Progress' menjadi 'Declined' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function declinestatus(Post $post)
    {
        Review::where('id', $post->stage1->review_id)->update([
            'status' => 'Declined'
        ]);
            
        return redirect()->back()->with('status', 'Successfully declined this idea!');
    }

    /**
     * Memperbarui data status review Stage 1 dari 'Declined' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function rereviewstatus(Post $post)
    {
        Review::where('id', $post->stage1->review_id)->update([
            'status' => 'In Progress'
        ]);
            
        return redirect()->back()->with('status', 'Successfully re-reviewed this idea!');
    }

    /**
     * Memperbarui data status review Stage 1 dari 'In Progress' menjadi 'Waiting' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function destroystatus(Post $post)
    {
        Review::where('id', $post->stage1->review_id)->update([
            'switch' => 0,
            'status' => 'Waiting',
            'reviewerid' => NULL,
            'reviewername' => NULL,
            'reviewerunit' => NULL
        ]);

        return redirect()->back()->with('status', 'You are no longer the reviewer of this idea!');
    }

    /**
     * Memperbarui data status review Stage 2 dari 'Waiting' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function updatestatus2(Post $post)
    {
        $reviewer = Auth::user();

        Review::where('id', $post->stage2->review_id)->update([
            'switch' => 1,
            'status' => 'In Progress',
            'reviewerid' => $reviewer->id,
            'reviewername' => $reviewer->name,
            'reviewerunit' => $reviewer->unit->name
        ]);

        return redirect()->back()->with('status', 'You are now the reviewer of this idea!');
    }

    /**
     * Memperbarui data status review Stage 2 dari 'In Progress' menjadi 'Approved' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function approvestatus2(Post $post)
    {
        Review::where('id', $post->stage2->review_id)->update([
            'status' => 'Approved'
        ]);

        Post::where('id', $post->id)->update([
            'stage' => $post->stage+1
        ]);
            
        return redirect()->back()->with('status', 'Successfully approved this idea!');
    }

    /**
     * Memperbarui data status review Stage 2 dari 'Approved' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function disapprovestatus2(Post $post)
    {
        Storage::delete($post->stage3->post_img, $post->stage3->post_file);

        Stage3::where('id', $post->stage3_id)->update([
            'title' => NULL,
            'post_img' => NULL,
            'description' => NULL,
            'post_file' => NULL
        ]);

        Review::where('id', $post->stage2->review_id)->update([
            'status' => 'In Progress'
        ]);

        Post::where('id', $post->id)->update([
            'stage' => $post->stage-1
        ]);
            
        return redirect()->back()->with('status', 'Successfully disapproved this idea!');
    }

    /**
     * Memperbarui data status review Stage 2 dari 'In Progress' menjadi 'Declined' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function declinestatus2(Post $post)
    {
        Review::where('id', $post->stage2->review_id)->update([
            'status' => 'Declined'
        ]);
            
        return redirect()->back()->with('status', 'Successfully declined this idea!');
    }

    /**
     * Memperbarui data status review Stage 2 dari 'Declined' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function rereviewstatus2(Post $post)
    {
        Review::where('id', $post->stage2->review_id)->update([
            'status' => 'In Progress'
        ]);
            
        return redirect()->back()->with('status', 'Successfully re-reviewed this idea!');
    }

    /**
     * Memperbarui data status review Stage 2 dari 'In Progress' menjadi 'Waiting' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function destroystatus2(Post $post)
    {
        Review::where('id', $post->stage2->review_id)->update([
            'switch' => 0,
            'status' => 'Waiting',
            'reviewerid' => NULL,
            'reviewername' => NULL,
            'reviewerunit' => NULL
        ]);

        return redirect()->back()->with('status', 'You are no longer the reviewer of this idea!');
    }

    /**
     * Memperbarui data status review Stage 3 dari 'Waiting' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function updatestatus3(Post $post)
    {
        $reviewer = Auth::user();

        Review::where('id', $post->stage3->review_id)->update([
            'switch' => 1,
            'status' => 'In Progress',
            'reviewerid' => $reviewer->id,
            'reviewername' => $reviewer->name,
            'reviewerunit' => $reviewer->unit->name
        ]);

        return redirect()->back()->with('status', 'You are now the reviewer of this idea!');
    }

    /**
     * Memperbarui data status review Stage 3 dari 'In Progress' menjadi 'Approved' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function approvestatus3(Post $post)
    {
        Review::where('id', $post->stage3->review_id)->update([
            'status' => 'Approved'
        ]);

        Post::where('id', $post->id)->update([
            'stage' => $post->stage+1
        ]);
            
        return redirect()->back()->with('status', 'Successfully approved this idea!');
    }

    /**
     * Memperbarui data status review Stage 3 dari 'Approved' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function disapprovestatus3(Post $post)
    {
        Storage::delete($post->stage4->post_img, $post->stage4->post_file);

        Stage4::where('id', $post->stage4_id)->update([
            'title' => NULL,
            'post_img' => NULL,
            'description' => NULL,
            'post_file' => NULL
        ]);

        Review::where('id', $post->stage3->review_id)->update([
            'status' => 'In Progress'
        ]);

        Post::where('id', $post->id)->update([
            'stage' => $post->stage-1
        ]);
            
        return redirect()->back()->with('status', 'Successfully disapproved this idea!');
    }

    /**
     * Memperbarui data status review Stage 3 dari 'In Progress' menjadi 'Declined' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function declinestatus3(Post $post)
    {
        Review::where('id', $post->stage3->review_id)->update([
            'status' => 'Declined'
        ]);
            
        return redirect()->back()->with('status', 'Successfully declined this idea!');
    }

    /**
     * Memperbarui data status review Stage 3 dari 'Declined' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function rereviewstatus3(Post $post)
    {
        Review::where('id', $post->stage3->review_id)->update([
            'status' => 'In Progress'
        ]);
            
        return redirect()->back()->with('status', 'Successfully re-reviewed this idea!');
    }

    /**
     * Memperbarui data status review Stage 3 dari 'In Progress' menjadi 'Waiting' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function destroystatus3(Post $post)
    {
        Review::where('id', $post->stage3->review_id)->update([
            'switch' => 0,
            'status' => 'Waiting',
            'reviewerid' => NULL,
            'reviewername' => NULL,
            'reviewerunit' => NULL
        ]);

        return redirect()->back()->with('status', 'You are no longer the reviewer of this idea!');
    }

    /**
     * Memperbarui data status review Stage 4 dari 'Waiting' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function updatestatus4(Post $post)
    {
        $reviewer = Auth::user();

        Review::where('id', $post->stage4->review_id)->update([
            'switch' => 1,
            'status' => 'In Progress',
            'reviewerid' => $reviewer->id,
            'reviewername' => $reviewer->name,
            'reviewerunit' => $reviewer->unit->name
        ]);

        return redirect()->back()->with('status', 'You are now the reviewer of this idea!');
    }

    /**
     * Memperbarui data status review Stage 4 dari 'In Progress' menjadi 'Approved' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function approvestatus4(Post $post)
    {
        Review::where('id', $post->stage4->review_id)->update([
            'status' => 'Approved'
        ]);

        Post::where('id', $post->id)->update([
            'stage' => $post->stage+1
        ]);
            
        return redirect()->back()->with('status', 'Successfully approved this idea!');
    }

    /**
     * Memperbarui data status review Stage 4 dari 'Approved' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function disapprovestatus4(Post $post)
    {
        Storage::delete($post->stage5->post_img, $post->stage5->post_file);

        Stage5::where('id', $post->stage5_id)->update([
            'title' => NULL,
            'post_img' => NULL,
            'description' => NULL,
            'post_file' => NULL
        ]);

        Review::where('id', $post->stage4->review_id)->update([
            'status' => 'In Progress'
        ]);

        Post::where('id', $post->id)->update([
            'stage' => $post->stage-1
        ]);
            
        return redirect()->back()->with('status', 'Successfully disapproved this idea!');
    }

    /**
     * Memperbarui data status review Stage 4 dari 'In Progress' menjadi 'Declined' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function declinestatus4(Post $post)
    {
        Review::where('id', $post->stage4->review_id)->update([
            'status' => 'Declined'
        ]);
            
        return redirect()->back()->with('status', 'Successfully declined this idea!');
    }

    /**
     * Memperbarui data status review Stage 4 dari 'Declined' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function rereviewstatus4(Post $post)
    {
        Review::where('id', $post->stage4->review_id)->update([
            'status' => 'In Progress'
        ]);
            
        return redirect()->back()->with('status', 'Successfully re-reviewed this idea!');
    }

    /**
     * Memperbarui data status review Stage 4 dari 'In Progress' menjadi 'Waiting' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function destroystatus4(Post $post)
    {
        Review::where('id', $post->stage4->review_id)->update([
            'switch' => 0,
            'status' => 'Waiting',
            'reviewerid' => NULL,
            'reviewername' => NULL,
            'reviewerunit' => NULL
        ]);

        return redirect()->back()->with('status', 'You are no longer the reviewer of this idea!');
    }

    /**
     * Memperbarui data status review Stage 5 dari 'Waiting' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function updatestatus5(Post $post)
    {
        $reviewer = Auth::user();

        Review::where('id', $post->stage5->review_id)->update([
            'switch' => 1,
            'status' => 'In Progress',
            'reviewerid' => $reviewer->id,
            'reviewername' => $reviewer->name,
            'reviewerunit' => $reviewer->unit->name
        ]);

        return redirect()->back()->with('status', 'You are now the reviewer of this idea!');
    }

    /**
     * Memperbarui data status review Stage 5 dari 'In Progress' menjadi 'Approved' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function approvestatus5(Post $post)
    {
        Review::where('id', $post->stage5->review_id)->update([
            'status' => 'Approved'
        ]);

        Post::where('id', $post->id)->update([
            'stage' => $post->stage+1
        ]);
            
        return redirect()->back()->with('status', 'Successfully approved this idea!');
    }

    /**
     * Memperbarui data status review Stage 5 dari 'Approved' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function disapprovestatus5(Post $post)
    {

        Review::where('id', $post->stage5->review_id)->update([
            'status' => 'In Progress'
        ]);

        Post::where('id', $post->id)->update([
            'stage' => $post->stage-1
        ]);
            
        return redirect()->back()->with('status', 'Successfully disapproved this idea!');
    }

    /**
     * Memperbarui data status review Stage 5 dari 'In Progress' menjadi 'Declined' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function declinestatus5(Post $post)
    {
        Review::where('id', $post->stage5->review_id)->update([
            'status' => 'Declined'
        ]);
            
        return redirect()->back()->with('status', 'Successfully declined this idea!');
    }

    /**
     * Memperbarui data status review Stage 5 dari 'Declined' menjadi 'In Progress' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function rereviewstatus5(Post $post)
    {
        Review::where('id', $post->stage5->review_id)->update([
            'status' => 'In Progress'
        ]);
            
        return redirect()->back()->with('status', 'Successfully re-reviewed this idea!');
    }

    /**
     * Memperbarui data status review Stage 5 dari 'In Progress' menjadi 'Waiting' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function destroystatus5(Post $post)
    {
        Review::where('id', $post->stage5->review_id)->update([
            'switch' => 0,
            'status' => 'Waiting',
            'reviewerid' => NULL,
            'reviewername' => NULL,
            'reviewerunit' => NULL
        ]);

        return redirect()->back()->with('status', 'You are no longer the reviewer of this idea!');
    }
}