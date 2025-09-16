<?php

namespace App\Http\Controllers\Admin;

// use App\Models\Team;
use App\Models\DeliveryTime;
use App\Http\Controllers\Controller;
use App\Traits\PhotoTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DeliveryTimeController extends Controller
{
    use PhotoTrait;
    public function index(request $request)
    {
        // dd(DeliveryTime::latest()->get());
        if($request->ajax()) {
            $deliveryTimes = DeliveryTime::latest()->get();
            return Datatables::of( $deliveryTimes)
                ->addColumn('action', function ($deliveryTimes) {
                    return '
                            <button type="button" data-id="' . $deliveryTimes->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $deliveryTimes->id . '" data-title="' . $deliveryTimes->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
//                 ->editColumn('facebook', function ($deliveryTimes) {
// //                    if ($teams->facebook != null){
//                         return '
//                     <div class="wideget-user-icons mb-4">
// 						<a href="'.$deliveryTimes->facebook.'" class="bg-facebook text-white btn btn-circle"><i class="fab fa-facebook"></i></a>
// 						<a href="'.$deliveryTimes->twitter.'" class="bg-info text-white btn btn-circle"><i class="fab fa-twitter"></i></a>
// 						<a href="'.$deliveryTimes->gmail.'" class="bg-google text-white btn btn-circle"><i class="fab fa-google"></i></a>
// 					</div>
//                     ';
// //                    }
//                 })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/delivery_time/index');
        }
    }



    public function create(){
        return view('Admin/delivery_time.parts.create');
    }

    public function store(request $request): \Illuminate\Http\JsonResponse
    {
          $inputs = $request->validate([
            'from'   => 'required',
            'to'   => 'required',
        ],[

        ]);
       $from = Carbon::parse($request->from)->getTimestamp() * 1000;
       $to = Carbon::parse($request->to)->getTimestamp() * 1000;
        // dd($from);


        if(DeliveryTime::create([
            'from'=>$from,
            'to'=>$to,
        ]))
            return response()->json(['status'=>200]);
        else
            return response()->json(['status'=>405]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryTime  $deliveryTime
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryTime $deliveryTime)
    {
        //
    }


    public function edit(DeliveryTime $deliveryTime){
        return view('Admin/delivery_time.parts.edit',compact('deliveryTime'));
    }



    public function update(Request $request)
    {
        $inputs = $request->validate([
            'id'         => 'required',
            'photo'      => 'nullable|mimes:jpeg,jpg,png,gif',
            'name'       => 'required|max:255',
            'job'        => 'required|max:255',
            'facebook'   => 'nullable|max:255',
            'twitter'    => 'nullable|max:255',
            'gmail'      => 'nullable|max:255',
        ]);
        $deliveryTime = DeliveryTime::findOrFail($request->id);
        if($request->has('photo')){
            if (file_exists($deliveryTime->photo)) {
                unlink($deliveryTime->photo);
            }
            $file_name = $this->saveImage($request->photo,'assets/uploads/teams');
            $inputs['photo'] = 'assets/uploads/teams/'.$file_name;
        }
        if ($deliveryTime->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    }



    public function delete(Request $request)
    {
        $deliveryTime = DeliveryTime::findOrFail($request->id);
        if (file_exists($deliveryTime->photo)) {
            unlink($deliveryTime->photo);
        }
        $deliveryTime->delete();
        return response(['message'=>'تم الحذف بنجاح','status'=>200],200);
    }
}
