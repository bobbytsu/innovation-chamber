<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Post;
use App\Upload;
use App\Event;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman Home
     */
    public function index(){

        $populars = Post::withCount('likes')->orderByDesc('likes_count')->take(5)->get();

        $thisyear = Carbon::now()->format('Y');

        $springs = Post::withCount('likes')->orderByDesc('likes_count')->where('season', 'Spring')->take(4)->get();
        $summers = Post::withCount('likes')->orderByDesc('likes_count')->where('season', 'Summer')->take(4)->get();
        $autumns = Post::withCount('likes')->orderByDesc('likes_count')->where('season', 'Autumn')->take(4)->get();
        $winters = Post::withCount('likes')->orderByDesc('likes_count')->where('season', 'Winter')->take(4)->get();

        $uploads = Upload::orderBy('created_at', 'desc')->take(2)->get();

        $events = Event::all();
        
        return view('home.index', compact('populars', 'thisyear', 'springs', 'summers', 'autumns', 'winters', 'uploads', 'events'));
    }

    /**
     * Menampilkan halaman About
     */
    public function about(){
        
        return view('home.about');
    }

    /**
     * Menampilkan halaman Credits
     */
    public function credits(){
        
        return view('home.credits');
    }
}