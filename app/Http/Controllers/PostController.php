<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;

use App\Models\Post;
use Yajra\Datatables\Datatables;

use Carbon\Carbon;
use Auth;
use DB;
use Validator;

class PostController extends BaseController{
    
    public function indexDetail(Request $request, $post_id = 0){
        if($post = Post::find($post_id)){
            return view('pages/post', compact('post'));
        }else{
            return abort(404);
        }
    }
}