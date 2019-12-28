<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Posts;
use App\Models\Comments;
use App\Models\Friends;
use App\User;
use Auth;
use DB;


class IndexController extends Controller
{
    public function dashboard()
    {

    	$friends = Friends::where('my_id', Auth::user()->id)->get();
    	
    	$friends_id = [];
    	$friends_id[]= Auth::user()->id;
    	foreach ($friends as  $value) {
    		$friends_id[] = $value->user_id; 
    	}
    	$posts = Posts::whereIn('user_id', $friends_id)->orderBy('id','desc')->get();
    	return view('site.dashboard',[
    		'posts' =>  $posts,
    	]);
    }

    public function profile()
    {
    	$profile = Auth::user();
    	return view('site.profile.index',[
    		'profile' => $profile,
    	]);
    }


    public function changeProfile( Request $request )
    {
    	$validate = Validator::make($request->all(),[
      		'name' => 'required',
        	'email' => 'required|email:rfc',
        ]);

	 	if( $validate->fails()){
            return back()->withErrors( $validate)->withInput();
        }
		$user = Auth::user();
		
		$issetEmail = User::where('email', $request->email )
							->where('id','!=', Auth::user()->id)
							->first();
		if( isset($issetEmail )){
			return back()->withErrors(['issetEmail' => 'Такое email существует.'])->withInput();	
		}
       	$user->name = $request->name;
       	$user->email = $request->email;
       	$user->birthdate = $request->birthdate;
       	if($user->save()){
			return redirect()->route('profile')->with('message','Данные успешно изменены.');
       	}
    }


    public function changePassword( Request $request)
	{

     	$validate = Validator::make($request->all(),[
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ],[
            'password.required' => 'Введите пароль ',
            'password.confirmed' => 'Пароли не совпадают',
            'password_confirmation.confirmed' => 'Пароли не совпадают',
            'password.min' => 'Пароль должен состоять не менее 8-ми символов',
            'password_confirmation.required' => 'Введите подтверждение Пароля'
            
        ]);
	 	if( $validate->fails()){
            return back()->withErrors( $validate)->withInput();
        }
		$user = Auth::user();
       	$user->password = bcrypt($request->password);
       	if($user->save()){
			return redirect()->route('profile')->with('message','Пароль успешно изменен');
       	}
	}


}
