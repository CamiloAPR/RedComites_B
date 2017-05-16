<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Role::orderBy('role' , 'asc') -> get();
        foreach($query as $roles){
            $roles->users=User::select(['user.id','user.name','user.email','role.role','committee.name as committee'])->join('role', 'user.role' , '=' , 'role.id')->join('committee', 'user.committee' , '=', 'committee.id')->where("user.role" , $roles->id)->get();
        }

        return $query;
    }


        public function indexUser($id_user)
    {
        $query = Role::select(['role.id' , 'role.role'])->join('user','role.id','=','user.role')->where ([
            ['user.id' , '=' , $id_user]
            ])->orderBy('role' , 'asc') -> get();
        foreach($query as $roles){
            $roles->user=User::select(['user.id','user.name','user.email','role.role','committee.name as committee'])->join('role', 'user.role' , '=' , 'role.id')->join('committee', 'user.committee' , '=', 'committee.id')->where("user.role" , $roles->id)->get();
        }

        return $query;
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

        $email = $request->input('email');

        $user = User::where([
            ['email','=', $email]
            ])->get();
       
        if(sizeof($user) > 0){
           return \Response::json(['error'=>'El correo ingresado ya se encuentra registrado'],500);
        }else{

         $rules = [

            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'committee' => 'required'
            ];
 

         try{

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return [
                'creado ? ' => false,
                'errores '  => $validator->errors()->all()
            ];
        }
 
        User::create($request->all());
        return ['creado ? ' => true];

        } catch (Exception $e) {
            \Log::info('Error creando usuario : '.$e);
            return \Response::json(['creado = ?' => false], 500);
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
