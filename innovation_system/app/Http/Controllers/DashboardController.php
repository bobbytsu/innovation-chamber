<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Storage;
use File;
use Auth;
use App\Unit;
use App\User;
use App\Event;
use Carbon\Carbon;
use App\Post;
use App\Stage1;
use App\Stage2;
use App\Stage3;
use App\Stage4;
use App\Stage5;
use App\Review;
use App\Upload;
use App\Like;
use App\Comment;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:Administrator' || 'checkRole:Master')->only('createevent', 'storeevent', 'editevent', 'updateevent', 'destroyevent');
        $this->middleware('checkEventOwner')->only('editevent', 'updateevent', 'destroyevent');
        $this->middleware('checkRole:Master')->only('upgradeuser', 'downgradeuser');
    }
 
    /**
     * Menampilkan halaman edit Dashboard
     */
    public function index()
    {
        $now = Carbon::now();
        $thisyear = Carbon::now()->format('Y');
        $events = Event::orderBy('start')->get();

        $posts = Post::orderBy('created_at', 'desc')->get();

        $uploads = Upload::orderBy('created_at', 'desc')->get();

        $users = User::orderBy('name')->get();

        return view('dashboard.index', compact('now', 'thisyear', 'events', 'posts',  'uploads', 'users'));
    }

    /**
     * Menampilkan halaman edit profil
     */
    public function editprofile()
    {
        // Dropdown Unit
        $units = Unit::all();

        return view('dashboard.editprofile', compact('units'));
    }

    /**
     * Memperbarui data profil kedalam database
     */
    public function updateprofile(Request $request, User $user)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required',
            'unit_id' => 'required',
            'email' => 'required|email',
            'phonenumber' => 'nullable|max:14',
            'bio' => 'nullable|max:191',
            'profile_img' => 'nullable|image'
        ]);

        $unit_field = $request->unit_id;

        if($unit_field){
            
            User::where('id', $user->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phonenumber' => $request->phonenumber,
                'bio' => $request->bio
            ]);
        }

        User::where('id', $user->id)->update([
            'name' => $request->name,
            'unit_id' => $request->unit_id,
            'email' => $request->email,
            'phonenumber' => $request->phonenumber,
            'bio' => $request->bio
        ]);


        // Upload Profile Picture

        $img_field = $request->file('profile_img');

        if($img_field) {
            
            if($request->user()->profile_img){
                Storage::delete($request->user()->profile_img);
            }
    
            $profile_img = $request->file('profile_img')->store('profile');
            $request->user()->update([
                'profile_img' => $profile_img
            ]);
        }
        
        return redirect()->route('dashboard')->with('status', 'Successfully updated your profile!');
    }

    /**
     * Menghapus data gambar profil dari database
     */
    public function destroyprofile_img(Request $request){

        if($request->user()->profile_img){
            Storage::delete($request->user()->profile_img);
        }

        $request->user()->update([
            'profile_img' => NULL
        ]);

        return redirect()->back()->with('status', 'Successfully removed your profile picture!');
    }

    /**
     * Menampilkan halaman edit password
     */
    public function editpassword()
    {
        return view('dashboard.changepassword');
    }

    /**
     * Memperbarui data password kedalam database
     */
    public function updatepassword(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'oldpassword' => ['required', 'min:6', new MatchOldPassword],
            'newpassword' => ['required', 'min:6'],
            'confirmnewpassword' => ['required', 'min:6', 'same:newpassword']
        ]);

        User::where('id', $user->id)->update([
            'password'=> Hash::make($request->newpassword)
        ]);

        return redirect()->route('dashboard')->with('status', 'Successfully changed your password!');
    }

    /**
     * Menghapus data pengguna dari database
     */
    public function destroy(User $user)
    {
        $user = Auth::user();

        // Comment
        $comments = Comment::where('user_id', $user->id)->get();

        foreach($comments as $comment){
            
            Comment::where('parent_id', '=', $comment->id)->delete();
            Comment::destroy($comment->id);
        }

        // Like
        Like::where('user_id', $user->id)->delete();

        // Upload
        $uploads = Upload::where('user_id', $user->id)->get();

        foreach($uploads as $upload){

            Comment::where('upload_id', $upload->id)->delete();
    
            Like::where('upload_id', $upload->id)->delete();
    
            File::delete('data/knowledge system/'.$upload->upload_video, 'data/knowledge system/'.$upload->thumbnail);
            
            Upload::destroy($upload->id);
        }


        // Post
        $posts = Post::where('user_id', $user->id)->get();

        foreach($posts as $post){

            Comment::where('post_id', $post->id)->delete();
    
            Like::where('post_id', $post->id)->delete();
    
            $stage5s = Stage5::where('id', $post->stage5_id)->get();

            foreach($stage5s as $stage5){

                Review::where('id', $stage5->review_id)->delete();
                Storage::delete($stage5->post_img, $stage5->post_file);
                Stage5::destroy($stage5->id);
            }

            $stage4s = Stage4::where('id', $post->stage4_id)->get();

            foreach($stage4s as $stage4){

                Review::where('id', $stage4->review_id)->delete();
                Storage::delete($stage4->post_img, $stage4->post_file);
                Stage4::destroy($stage4->id);
            }

            $stage3s = Stage3::where('id', $post->stage3_id)->get();

            foreach($stage3s as $stage3){

                Review::where('id', $stage3->review_id)->delete();
                Storage::delete($stage3->post_img, $stage3->post_file);
                Stage3::destroy($stage3->id);
            }

            $stage2s = Stage2::where('id', $post->stage2_id)->get();

            foreach($stage2s as $stage2){

                Review::where('id', $stage2->review_id)->delete();
                Storage::delete($stage2->post_img, $stage2->post_file);
                Stage2::destroy($stage2->id);
            }

            $stage1s = Stage1::where('id', $post->stage1_id)->get();

            foreach($stage1s as $stage1){

                Review::where('id', $stage1->review_id)->delete();
                Storage::delete($stage1->post_img, $stage1->post_file);
                Stage1::destroy($stage1->id);
            }
            
            Post::destroy($post->id);
    
        }
        
        // Event
        Event::where('user_id', $user->id)->delete();

        if($user->profile_img){
            Storage::delete($user->profile_img);
        }
        
        Auth::logout();

        if ($user->delete()) {

            return redirect()->route('login')->with('status', 'Account Deleted');
       }
    }

    /**
     * Menampilkan halaman membuat event
     */
    public function createevent()
    {
        return view('dashboard.addevent');
    }

    /**
     * Menyimpan data event kedalam database
     */
    public function storeevent(Request $request)
    {
        $request->validate([
            'title' => 'required|max:191',
            'start' => 'required',
            'end' => 'nullable',
            'description' => 'nullable'
        ]);

        // End date + 1
        if($request->end){
            
            $end = $request->end;
            $endplus = date('Y-m-d', strtotime($end. '+ 1 day'));

            Event::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'start' => $request->start,
                'end' => $end,
                'endplus' => $endplus,
                'description' => $request->description
            ]);

        } else {

            Event::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'start' => $request->start,
                'end' => $request->end,
                'description' => $request->description
            ]);
        }

        return redirect()->route('dashboard')->with('status', 'Successfully added your event!');
    }

    /**
     * Menampilkan halaman edit event
     */
    public function editevent(Event $event)
    {
        return view('dashboard.editevent', compact('event'));
    }

    /**
     * Memperbarui data event kedalam database
     */
    public function updateevent(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|max:191',
            'start' => 'required',
            'end' => 'nullable',
            'description' => 'nullable'
        ]);

        // End date + 1
        if($request->end){
            
            $end = $request->end;
            $endplus = date('Y-m-d', strtotime($end. '+ 1 day'));

            Event::where('id', $event->id)->update([
                'title' => $request->title,
                'start' => $request->start,
                'end' => $end,
                'endplus' => $endplus,
                'description' => $request->description
            ]);

        } else {

            Event::where('id', $event->id)->update([
                'title' => $request->title,
                'start' => $request->start,
                'end' => $request->end,
                'endplus' => NULL,
                'description' => $request->description
            ]);
        }

        return redirect()->route('dashboard')->with('status', 'Successfully edited your event!');
    }

    /**
     * Menghapus data event dari database
     */
    public function destroyevent(Event $event)
    {
        Event::destroy($event->id);
        return redirect()->route('dashboard')->with('status', 'Successfully deleted your event!');
    }

    /**
     * Memperbarui data role pengguna dari 'User' menjadi 'Administrator' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master'
     */
    public function upgradeuser(User $user){

        User::where('id', $user->id)->update([
            'role' => 'Administrator'
        ]);

        return redirect()->back()->with('status', 'Successfully upgraded a user!');
    }

    /**
     * Memperbarui data role pengguna dari 'Administrator' menjadi 'User' kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master'
     */
    public function downgradeuser(User $user){

        User::where('id', $user->id)->update([
            'role' => 'User'
        ]);

        return redirect()->back()->with('status', 'Successfully downgraded a user!');
    }

    /**
     * Me-reset password pengguna menjadi default kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master'
     */
    public function resetpassword(User $user){

        User::where('id', $user->id)->update([
            'password' => Hash::make('berangberang')
        ]);

        return redirect()->back()->with('status', 'Successfully resetted password!');
    }
}