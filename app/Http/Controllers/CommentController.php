<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Posts;
use App\Models\Comments;
use App\Models\Images;
use Image;
use Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'comments' => 'required',
            'post_id' => 'required',
            
        ]);

        if( $validate->fails()){
            return back()->withErrors( $validate)->withInput();
        }else{
            $comment = new Comments;
            $comment->comment = $input['comments'];
            $comment->post_id = $input['post_id'];
            $comment->user_id = Auth::user()->id;
            if( $comment->save()){
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
        if( $request->ajax()){
            $input = $request->all();
           
            $model = Comments::find( $id);

            $model->comment = $input['comment'];
            if( $model->save()){
                return response()->json(200);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Comments::find( $id );
        if( $data->delete()){
            return response()->json();
        }
      
        
    }
}
