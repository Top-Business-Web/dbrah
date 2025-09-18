<?php

namespace App\Http\Controllers\Admin;

// use App\Models\Team;
use App\Models\DeliveryTime;
use App\Http\Controllers\Controller;
use App\Models\Nationality;
use App\Traits\PhotoTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NationalityController extends Controller
{
    use PhotoTrait;
    public function index(request $request)
    {
        // dd(DeliveryTime::latest()->get());
        if($request->ajax()) {
            $nationalities = Nationality::latest()->get();
            return Datatables::of( $nationalities)
                ->addColumn('action', function ($nationalities) {
                    return '
                            <button type="button" data-id="' . $nationalities->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $nationalities->id . '" data-title="' . $nationalities->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
//                 ->editColumn('facebook', function ($nationalities) {
// //                    if ($teams->facebook != null){
//                         return '
//                     <div class="wideget-user-icons mb-4">
// 						<a href="'.$nationalities->facebook.'" class="bg-facebook text-white btn btn-circle"><i class="fab fa-facebook"></i></a>
// 						<a href="'.$nationalities->twitter.'" class="bg-info text-white btn btn-circle"><i class="fab fa-twitter"></i></a>
// 						<a href="'.$nationalities->gmail.'" class="bg-google text-white btn btn-circle"><i class="fab fa-google"></i></a>
// 					</div>
//                     ';
// //                    }
//                 })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('admin.nationalities.index');
        }
    }



    public function create(){
        return view('admin.nationalities.parts.create');
    }

    public function store(request $request): \Illuminate\Http\JsonResponse
    {
        $inputs = $request->validate([
            'title_ar'   => 'required',
            'title_en'   => 'required',
            'image'   => 'required',
        ],[
            'title_ar.required' => 'الاسم بالعربيه مطلوب',
            'title_en.required' => 'الاسم بالانجليزيه مطلوب',
            'image.required' => 'الصوره مطلوبه',
        ]);
//        dd($inputs);;
        if($request->has('image')){
            $file_name = $this->saveImage($request->image,'assets/uploads/admins');
            $inputs['image'] = 'assets/uploads/admins/'.$file_name;
        }
//       $from = Carbon::parse($request->from)->getTimestamp() * 1000;
//       $to = Carbon::parse($request->to)->getTimestamp() * 1000;


        if(Nationality::create([
            'image'=>$inputs['image'],
            'title_ar'=>$inputs['image'],
            'title_en'=>$inputs['image'],
        ]))
            return response()->json(['status'=>200]);
        else
            return response()->json(['status'=>405]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nationality  $nationality
     * @return \Illuminate\Http\Response
     */
    public function show(Nationality $nationality)
    {
        //
    }


    public function edit(Nationality $nationality){
        return view('admin.nationalities.parts.edit',compact('nationality'));
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
        $nationality = Nationality::findOrFail($request->id);
        if($request->has('photo')){
            if (file_exists($nationality->photo)) {
                unlink($nationality->photo);
            }
            $file_name = $this->saveImage($request->photo,'assets/uploads/teams');
            $inputs['photo'] = 'assets/uploads/teams/'.$file_name;
        }
        if ($nationality->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    }



    public function delete(Request $request)
    {
        $nationality = Nationality::findOrFail($request->id);
        if (file_exists($nationality->photo)) {
            unlink($nationality->photo);
        }
        $nationality->delete();
        return response(['message'=>'تم الحذف بنجاح','status'=>200],200);
    }
}
