<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dislike;
use App\Models\Like;
use Auth;

class LikeController extends Controller
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
        if( $request->ajax()){
            $input = $request->all();
            $dislike = Dislike::where(['user_id' => Auth::user()->id, 'post_id' => $input['post_id'] ])->first();
            if( $dislike ){
                $dislike->delete();
            }
            $isset = Like::where(['user_id' => Auth::user()->id, 'post_id' => $input['post_id'] ])->first();
            if( isset( $isset) ){
                if( $isset->delete()){
                    return response()->json(); 
                }
            }else{
                $model = new Like;
                $model->post_id = $input['post_id'];
                $model->user_id = Auth::user()->id;
                if( $model->save()){
                    return response()->json(200);
                }
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
