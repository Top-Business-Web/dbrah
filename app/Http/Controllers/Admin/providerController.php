<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class providerController extends Controller
{
    use PhotoTrait;
    public function index(request $request)
    {

        if ($request->ajax()) {
            $providers = Provider::latest()->get();
            return Datatables::of($providers)
                ->addColumn('action', function ($providers) {
                    return '
                            <button type="button" data-id="' . $providers->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $providers->id . '" data-title="' . $providers->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('image', function ($providers) {
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar-md rounded-circle" src="' . $providers->image . '">
                    ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.providers.index');
        }
    }
}
