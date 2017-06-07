<?php

namespace App\Http\Controllers;
use App\User;
use App\Committee;
use App\Member;
use App\Publication;
use App\CommitteeMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $query = Committee::select(['committee.id','user.name' , 'user.email' , 'user.password', 'general_info' , 'function' , 'banner' , 'icon' , 'color' , 'status'])->join('user', 'committee.id' , '=', 'user.committee')->orderBy('name' ,  'asc')->get();


        return $query;

    }

    public function indexCommittee($committee_id)
    {
        $query = Committee::select(['committee.id' , 'user.name' , 'user.email' , 'user.password', 'general_info' , 'function' , 'banner' , 'icon' , 'color' , 'status'])->join('user', 'committee.id' , '=', 'user.committee')->where('committee.id' , '=' , $committee_id)->orderBy('name' ,  'asc')->get();

        foreach ($query as $members){
            $members->members = CommitteeMember::select(['member.name' , 'member.email' , 'function'])->join('member', 'member.id', '=' , 'committee_member.member')->where('committee_member.committee' , '=' , $members->id)->get();
        }

        foreach ($query as $publications){
            $publications->publications = Publication::select(['title' , 'content' , 'publication.publication_date', 'publication.status'])->join('committee', 'committee.id' , '=', 'publication.committee')->where('committee.id' , '=' , $publications->id)->orderBy('publication.publication_date' , 'desc')->get();
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
        $name = $request->input('name');
        $password = $request->input('password');
        $password_confirm = $request->input('password_confirm');

        $member_name = $request->input('member_name');
        $member_email = $request->input('member_email');
        $member_function = $request->input('member_function');

        $general_info = $request->input('general_info');
        $function = $request->input('function');
        $banner = $request->input('banner');
        $icon = $request->input('icon');
        $color = $request->input('color');

        $user = User::where([
            ['email','ilike', $email]
            ])->orwhere('name','ilike',$name)->get();

        $member = Member::where([
            ['email','ilike', $member_email]
            ])->orwhere('name', 'ilike', $member_name)->get();
        $count_member = sizeof($member);

        if(sizeof($user) > 0){
           return \Response::json(['error'=>'El correo y/o nombre ingresado del usuario ya se encuentra registrado'],500);
        }else{

         $rules = [

            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirm' => 'required',
            'member_name' => 'required',
            'member_email' => 'required',
            'member_function' => 'required',
            'icon' => 'required',
            'general_info' => 'required',
            'function' => 'required',
            'banner' => 'required',
            'color' => 'required'
            ];
 

         try{

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return [
                'creado ? ' => false,
                'errores '  => $validator->errors()->all()
            ];
        }

        if($password == $password_confirm){

        Committee::insert(
            array('general_info' => $general_info,
                'function' => $function,
                'banner' => $banner,
                'icon' => $icon,
                'color' => $color,
                'status' => '1')
            ); 
        $queryComm = Committee::select(['id'])->where([
            ['general_info' , 'ilike' , $general_info],
            ['function' , 'ilike' , $function],
            ['banner' , 'ilike' , $banner],
            ['icon' , 'ilike' , $icon],
            ['color' , 'ilike' , $color]
            ])->get();
        
        foreach($queryComm as $comm){
        User::insert(
            array('name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => '2',
                'committee' => $comm->id)
            );
        }

        if ($count_member < 1){
        Member::insert(
            array('name' => $member_name,
            'email' => $member_email,
            'function' => $member_function )
            );
        }

        $queryMem = Member::select(['id'])->where([
            ['name' , 'ilike' , $member_name],
            ['email', 'ilike' , $member_email]
            ])->get();

        foreach($queryComm as $com2){
            foreach ($queryMem as $mem) {
                CommitteeMember::insert(
                    array('committee' => $com2->id,
                        'member' => $mem->id)
                    );
            }
        }

        return ['creado ? ' => true];

        }else{
            return \Response::json(['error'=>'Las contraseñas no coinciden'],500);
        }

        } catch (Exception $e) {
            \Log::info('Error creando comite : '.$e);
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
        
        $email = $request->input('email');
        $name = $request->input('name');
        $password = $request->input('password');
        $password_confirm = $request->input('password_confirm');

        $member_name = $request->input('member_name');
        $member_email = $request->input('member_email');
        $member_function = $request->input('member_function');

        $general_info = $request->input('general_info');
        $function = $request->input('function');
        $banner = $request->input('banner');
        $icon = $request->input('icon');
        $color = $request->input('color');
        $status = $request->input('status');




         $rules = [

            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'member_name' => 'required',
            'member_email' => 'required',
            'member_function' => 'required',
            'icon' => 'required',
            'general_info' => 'required',
            'function' => 'required',
            'banner' => 'required',
            'color' => 'required',
            'status' => 'required'
            ];
 

         try{

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return [
                'actualizado ? ' => false,
                'errores '  => $validator->errors()->all()
            ];
        }

        if($password == $password_confirm){

        Committee::where('id', $id)->update([
                'general_info' => $general_info,
                'function' => $function,
                'banner' => $banner,
                'icon' => $icon,
                'color' => $color,
                'status' => $status
            ]);

        $queryComm = Committee::select(['id'])->where([
            ['general_info' , '=' , $general_info],
            ['function' , '=' , $function],
            ['banner' , '=' , $banner],
            ['icon' , '=' , $icon],
            ['color' , '=' , $color]
            ])->get();

        foreach($queryComm as $comm){
        User::where('id' , $comm->id)->update ([
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]);
        }

        $queryMemTotal = Member::get();
        foreach($queryMemTotal as $qmt){
            
        }

        $queryMem = Member::select(['id'])->where([
            ['email','ilike', $member_email],
            ['name' , 'ilike', $member_name]
            ])->get();
        foreach($queryMem as $mem){
        CommitteeMember::where([
            ['committee_member.committee', $id],
            ['committee_member.member', $mem->id]
            ])->join('committee' , 'committee.id' , '=', 'committee_member.committee')->join('member' , 'member.id' , '=' , 'committee_member.member')->delete();
        }

        foreach($queryComm as $com2){
            foreach ($queryMem as $mem) {
                CommitteeMember::insert(
                    array('committee' => $com2->id,
                        'member' => $mem->id)
                    );
            }
        }



        return ['actualizado ? ' => true];

        }else{
            return \Response::json(['error'=>'Las contraseñas no coinciden'],500);
        }

        } catch (Exception $e) {
            \Log::info('Error creando comite : '.$e);
            return \Response::json(['creado = ?' => false], 500);
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
        
        $committee = Committee::find($id);

        if(!empty($committee)){
            $committee->destroy($id);
            return ['borrado : ' => true];
        }else{
            return ['borrado : ' => false];
        }

    }
}
