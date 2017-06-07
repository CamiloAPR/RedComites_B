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
            $publications->publications = Publication::select(['publication.id' ,'title' , 'content' , 'publication.publication_date', 'publication.status'])->join('committee', 'committee.id' , '=', 'publication.committee')->where('committee.id' , '=' , $publications->id)->orderBy('publication.publication_date' , 'desc')->get();
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

        $general_info = $request->input('general_info');
        $function = $request->input('function');
        $banner = $request->input('banner');
        $icon = $request->input('icon');
        $color = $request->input('color');

        

         $rules = [

            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirm' => 'required',
            'members' => 'required',
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

        
        $user = User::where([
            ['email','ilike', $email]
            ])->orwhere('name','ilike',$name)->get();

        if(sizeof($user) == 0){

            Committee::insert(
            array('general_info' => $general_info,
                'function' => $function,
                'banner' => $banner,
                'icon' => $icon,
                'color' => $color,
                'status' => '1')
            ); 
            $queryComm = Committee::select(['committee.id'])->where([
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
        
        //JSON object using
        foreach($request['members'] as $member){

        // //Search for every single member in order to insert those who haven't been inserted in the db
        $queryMemTotal = Member::where([
            ['email','ilike', $member['email']],
            ['name', 'ilike', $member['name']]
            ])->get();
        $size = sizeof($queryMemTotal);

        //if doesn't existe, inserts the member
        if ($size == 0){
            $this->insertIntoMember($member['name'], $member['email'], $member['function']);
        }

        //searches for the member whether it was inserted or not
        $queryMem = Member::select(['id'])->where([
            ['email','ilike', $member['email']],
            ['name' , 'ilike', $member['name']]
            ])->get();

        //creates the relation between the committee and every member entered
        foreach($queryComm as $com2){
            foreach ($queryMem as $mem) {
                CommitteeMember::insert(
                    array('committee' => $com2->id,
                        'member' => $mem->id)
                    );
            }
        }
    }
    }else{
            return \Response::json(['error'=>'El usuario ingresado ya existe'],500);
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
            'members' => 'required',
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

        if((isset($password_confirm) && $password == $password_confirm) || (!isset($password_confirm))){

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

        //Deletes all the relations between a given committee and member
        CommitteeMember::where([
            ['committee_member.committee', $id]
            ])->join('committee' , 'committee.id' , '=', 'committee_member.committee')->delete();

        //JSON object using
        foreach($request['members'] as $member){
        //Search for every single member in order to insert those who haven't been inserted in the db
            $queryMemTotal2 = Member::where([
            ['email','ilike', $member['email']],
            ['name', 'ilike', $member['name']]
            ])->get();
        
        //if doesn't exist, inserts the member
            $size = sizeof($queryMemTotal2);
            if($size == 0){
                $this->insertIntoMember($member['name'], $member['email'], $member['function']);
        }
        //Search for the member who has the email and name entered
        $queryMem = Member::select(['id'])->where([
            ['email','ilike', $member['email']],
            ['name' , 'ilike', $member['name']]
            ])->get();


        //Finally, inserts again the relations in the committee_member table
        foreach($queryComm as $com2){
            foreach ($queryMem as $mem) {
                CommitteeMember::insert(
                    array('committee' => $com2->id,
                        'member' => $mem->id)
                    );
            }
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

    public function insertIntoMember($member_name, $member_email, $member_function)
    {
      Member::insert(
                array('name' => $member_name,
                'email' => $member_email,
                'function' => $member_function )
                );  
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
