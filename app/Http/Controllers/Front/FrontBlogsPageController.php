<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\SuperAboutusModel;
use App\Models\SuperBlogModel;
use App\Models\SuperOtherBannerModel;
use Illuminate\Support\Facades\Auth;

class FrontBlogsPageController extends Controller
{

    protected $guard = 'dwuser';


    public function index(){

        $aboutDetails = SuperAboutusModel::get();
        $otherBanners = SuperOtherBannerModel::get();
        $blogs = SuperBlogModel::latest()->paginate(6);

        $user = Auth::guard('dwuser')->user();
    
        return view('blog', compact('aboutDetails', 'otherBanners', 'blogs', 'user')); 

    }

    public function blogdetails($slug){

        $aboutDetails = SuperAboutusModel::get();
        $otherBanners = SuperOtherBannerModel::get();
        $blog = SuperBlogModel::where('slug', $slug)->first();
        $user = Auth::guard('dwuser')->user();
    
        return view('blog-details', compact('aboutDetails', 'otherBanners', 'blog', 'user')); 

    }
}
