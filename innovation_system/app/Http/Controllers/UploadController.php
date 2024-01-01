<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use File;
use Validator;
use VideoThumbnail;
use App\Upload;
use App\Like;
use App\Comment;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
        $this->middleware('checkRole:Administrator' || 'checkRole:Master')->only('create', 'store');
        $this->middleware('checkUploadOwner')->only('edit', 'update', 'destroy');
    }

    /**
     * Menampilkan halaman Knowledge System
     */
    public function index()
    {
        $uploads = Upload::orderBy('created_at', 'desc')->get();

        return view('knowledgesystem.index', compact('uploads'));
    }

    /**
     * Menampilkan halaman Upload Video
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function create()
    {
        return view('knowledgesystem.upload');
    }

    /**
     * Menyimpan data video kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function store(Request $request)
    {
        $rules = array(
            'upload_video' => 'required|max:500000|mimes:mp4,ogg,flv,m3u8,ts,3gp,mov,avi,wmv',
            'title' => 'required|max:191',
            'description' => 'nullable'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        // Upload Video
        $upload = $request->file('upload_video');
        $upload_video = time().$upload->getClientOriginalName();
        $path = public_path().'/data/knowledge system/';
        $upload->move($path, $upload_video);

        // Create Thumbnail
        $thumbnail = $upload_video.".jpg";
        VideoThumbnail::createThumbnail(
            $path.$upload_video, 
            $path, 
            $thumbnail,
            30, 1920, 1080
        );

        Upload::create([
            'user_id' => auth()->id(),
            'upload_video' => $upload_video,
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $thumbnail
        ]);

        $output = array('success' => 'Success!');

        return response()->json($output);
    }

    /**
     * Menampilkan halaman Video
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function show(Upload $upload)
    {
        $totallike = Like::where('upload_id', $upload->id)->count();
        $likers = Like::where('upload_id', $upload->id)->get();
        
        $comments = Comment::where('upload_id', $upload->id)->get();
        $totalcomment = Comment::where('upload_id', $upload->id)->count();

        $thumbs = Upload::all()->shuffle()->take(5);

        return view('knowledgesystem.video', compact('upload', 'totallike', 'likers', 'comments', 'totalcomment', 'thumbs'));
    }

    /**
     * Menampilkan halaman edit data video
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function edit(Upload $upload)
    {

        return view('knowledgesystem.editupload', compact('upload'));
    }

    /**
     * Memperbarui data video kedalam database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function update(Request $request, Upload $upload)
    {
        $request->validate([
            'title' => 'required|max:191',
            'description' => 'nullable'
        ]);

        Upload::where('id', $upload->id)->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect()->route('video', $upload->id)->with('status', 'Successfully edited your upload!');
    }

    /**
     * Menghapus data video dari database
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function destroy(Upload $upload)
    {
        Comment::where('upload_id', $upload->id)->delete();
        Like::where('upload_id', $upload->id)->delete();

        File::delete('data/knowledge system/'.$upload->upload_video, 'data/knowledge system/'.$upload->thumbnail);
        
        Upload::destroy($upload->id);

        return redirect()->route('knowledgesystem')->with('status', 'Successfully deleted your video!');
    }
}