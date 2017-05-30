<?php

namespace App\Http\Controllers;
use App\Publication;
use App\PublicationStatus;
use App\Committee;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $query = Committee::select(['user.name' , 'committee.id','committee.banner' , 'committee.icon' , 'committee.color' , 'committee.status'])->join('user', 'committee.id' , '=', 'user.committee')->orderBy('name' ,  'asc')->get();
        foreach($query as $publications){
            $publications->publications = Publication::select(['publication.id' , 'publication.title' , 'publication.content' , 'publication.status'
                ])->join('committee', 'committee.id' , '=' , 'publication.committee')->where('committee.id' , '=',$publications->id)->get();
        }
        //$query = PublicationStatus::orderBy();


        return $query;

    }

    public function indexPublication($publication_id)
    {
        $query = Committee::select(['user.name' , 'committee.id','committee.banner' , 'committee.icon' , 'committee.color' , 'committee.status'])->join('user', 'committee.id' , '=', 'user.committee')->join('publication' , 'publication.committee' , '=' , 'committee.id')->where('publication.id' , $publication_id)->orderBy('name' ,  'asc')->get();
        foreach($query as $publications){
            $publications->publications = Publication::select(['publication.id' , 'publication.title' , 'publication.content' , 'publication.status'
                ])->join('committee', 'committee.id' , '=' , 'publication.committee')->where([
                ['committee.id' , '=',$publications->id],
                ['publication.id',$publication_id]
                ])->get();
        }

        return $query;

    }

        public function indexCommittee($committee_id)
    {
        $query = Committee::select(['committee.id', 'user.name' , 'committee.id','committee.banner' , 'committee.icon' , 'committee.color' , 'committee.status'])->join('user', 'committee.id' , '=', 'user.committee')->where('committee.id' , $committee_id)->orderBy('name' ,  'asc')->get();
        foreach($query as $publications){
            $publications->publications = Publication::select(['publication.id' , 'publication.title' , 'publication.content' , 'publication.status'
                ])->join('committee', 'committee.id' , '=' , 'publication.committee')->where([
                ['committee.id' , '=',$publications->id]
                ])->get();
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
        


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $rules = [

            'committee' => 'required',
            'title' => 'required',
            'content' => 'required'
            
        ];

        $committee = $request->input('committee');
        $title = $request->input('title');
        $content = $request->input('content');

        try {
            
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return [
                    'creado ?' => false,
                    'errores ' => $validator->errors()->all()
                ];
            }

            Publication::insert(
                array('committee' => $committee,
                    'title' => $title,
                    'content' => $content,
                    'status' => '1')
                );
            return ['creado ?' => true];

        } catch (Exception $e) {
            \Log::info('Error creando publicación :'.$e);
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
        
        $rules = [

            'committee' => 'required',
            'title' => 'required',
            'content' => 'required',
            'status' => 'required'
            
        ];

        $committee = $request->input('committee');
        $title = $request->input('title');
        $content = $request->input('content');
        $status = $request->input('status');

        try {
            
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return [
                    'actualizado ?' => false,
                    'errores ' => $validator->errors()->all()
                ];
            }

            Publication::where('id', $id)->update([
                'committee' => $committee,
                    'title' => $title,
                    'content' => $content,
                    'status' => $status
                ]);
            return ['actualizado ?' => true];

        } catch (Exception $e) {
            \Log::info('Error creando publicación :'.$e);
            return \Response::json(['actualizado = ?' => false], 500);
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
        
        $publication = Publication::find($id);

        if(!empty($publication)){
            $publication->destroy($id);
            return ['borrado : ' => true];
        }else{
            return ['borrado : ' => false];
        }

    }
}
