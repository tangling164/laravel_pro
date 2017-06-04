<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['only'=>['edit','update','destroy']]);
        $this->middleware('guest',['only'=>['create']]);
    }
    public function create()
    {
        return view('users.create');
    }
    public function index()
    {
        $users = User::paginate(30);
        return view('users.index',compact('users'));

    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        $statuses = $user->statuses()
                         ->orderBy('created_at','desc')
                         ->paginate(30);
        return view('users.show',compact('user','statuses'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed'
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
            $this->sendEmailConfirmationTo($user);
            session()->flash('success','Verify email has been sent to your registered email ,please check');
            return redirect('/');
    }
    //�ʼ�����
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = '314841639@qq.com';
        $name = 'tangling164';
        $to = $user->email;
        $subject = 'Thank you for registering !Please confirm your email addresds';
        Mail::send($view,$data,function($message) use($from,$name,$to,$subject){
           $message->from($from,$name)->to($to)->subject($subject);
        });
    }
//�û�����
    public function confirmEmail($token)
    {
        $user = User::where('activation_token',$token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();
        Auth::login($user);
        session()->flash('sucess','Activation success!');
        return redirect()->route('users.show',[$user]);

    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));

    }

    public function update($id,Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:50',
            'password'=>'required|confirmed|min:6'
        ]);
        $user= User::findOrFail($id);
        $this->authorize('update',$user);
        $data = [];
        $data['name'] = $request->name;
        if($request->password)
        {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success','Update successfully');
        return redirect()->route('users.show',$id);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','Delete successfully');
        return back();
    }

}
