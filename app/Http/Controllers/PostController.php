<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Posts;
use App\Models\Images;
use Image;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Posts::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('site.post.index',[
            'posts' => $posts,
        ]);
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
        $input = $request->all();

        $validate = Validator::make($input,[
            'text' => 'required',
        ]);
        if( $validate->fails()){
            return back()->withErrors( $validate)->withInput();
        }else{
            if( $request->hasFile('images') ) {
                $images_name = [];
                $hash = [];
                foreach ( $request->file('images') as $value) {
                    $images = $value;
                    $images_name[] = $images->getClientOriginalName();
                    $images_hash = uniqid().'.'.$images->getClientOriginalExtension();
                    $images_path = $images->getPath();
                    $path = $value->store('images','public');
                    $hash[] = $path;
                }
                $hashname = json_encode($hash);
                $imagesname = json_encode($images_name);
            }
            $post = new Posts;
            $post->user_id = Auth::user()->id;
            $post->text = $input['text'];
            if( $post->save()){
                if( $request->hasFile('images') ) {
                    $images = new Images;
                    $images->user_id = Auth::user()->id;
                    $images->post_id = $post->id;
                    $images->image = $hashname;
                    $images->save();
                }
                return redirect()->route('dashboard');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
