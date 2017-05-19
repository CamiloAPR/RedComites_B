<?php

namespace App\Http\Controllers;
use App\Member;
use App\CommitteeMember;
use App\Committee;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $query = Committee::select(['committee.id' , 'user.name' , 'general_info' , 'function' , 'banner' , 'icon' , 'color' , 'status'])->join('user', 'committee.id' , '=', 'user.committee')->orderBy('name' ,  'asc')->get();

        foreach ($query as $members){
            $members->members = CommitteeMember::select(['member.name' , 'member.email' , 'function'])->join('member', 'member.id', '=' , 'committee_member.member')->where('committee_member.committee' , '=' , $members->id)->get();
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
        


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $member = Member::find($id);

        if(!empty($member)){
            $member->destroy($id);
            return ['borrado : ' => true];
        }else{
            return ['borrado : ' => false];
        }

    }
}
