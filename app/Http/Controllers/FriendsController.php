<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friends;
use Auth;

class FriendsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $friends = Friends::where('my_id', Auth::user()->id)->with('userDetail')->get();
        return view('site.friends.index',[
            'friends' => $friends,
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
        if( $request->ajax()){
            $my_id = Auth::user()->id;
            $input =  $request->all();
            $isset = Friends::where(['my_id' => $my_id, 'user_id' => $input['user_id'] ])->get();
            if( count($isset) == 0 ){
                $frinds = new Friends;
                $frinds->my_id = $my_id;
                $frinds->user_id = $input['user_id'];

                if( $frinds->save()){
                    return response()->json([ 'message'=>'Пользователь добавлен в друзья', 200]);
                }    
            }else{
                return response()->json([ 'message'=>'Пользователь уже существует в друзьях', 200]);
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

        $my_id = Auth::user()->id;
        if( Friends::where(['my_id' => $my_id, 'user_id' => $id])->delete()){
            return response()->json([ 'message'=>'Пользователь удален', 200]);
        }
    }
}
