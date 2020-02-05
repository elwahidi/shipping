<?php

namespace App\Http\Controllers;

use App\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of offers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::with(['activity','createdBy','publishedBy'])->orderBy('id','desc')->get();
        return response()->json($offers);
    }

    /**
     * Store a new offer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['created_by'] = auth()->user()->id;
        $data = $this->validate($request,[
            'title'=>'required|max:255',
            'text'=>'required|max:50000',
            'created_by'=>'required|exists:users,id',
        ]);
        $data['created_by'] =  $request['created_by'];
        $data['is_published'] = 0;
        $data['published_by'] = null;
        $data['activity_id'] = $request->activity;
        $offer = Offer::create($data);

        return response()->json(['offer'=>$offer]);
    }

    /**
     * Remove the specified offer.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        $e = $offer->delete();
        return response()->json($e);
    }

    public function publish($id)
    {
        $offer = Offer::find($id);
        $offer->is_published = true;
        $offer->published_by = auth()->user()->id;
        if($offer->update()){
            return response()->json(true);
        }
    }

    public function edit($id)
    {
        $post = Offer::with('activity')->where('id',$id)->first();
        return response()->json($post);
    }

    public function update(Request $request)
    {

        $this->validate($request,[
            'title'=>'required|max:255',
            'text'=>'required|max:50000',
            'activity_id'=>'required|exists:activities,id',
        ]);

        $offer = Offer::find($request->id);
        $offer->title = $request->title;
        $offer->text = $request->text;
        $offer->activity_id = $request->activity_id;

        if($offer->update()){

            return response()->json('update-success');
        }
    }
}
