<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'customers';
        if($request->ajax()){
            $suppliers = User::where('type','=','customer')->get();
            return DataTables::of($suppliers)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("customers.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('customers.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    if (!auth()->user()->hasPermissionTo('edit-customer')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-customer')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.customers.index',compact(
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'create Customer';
        return view('admin.customers.create',compact(
            'title'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|min:8|max:255',
//            'product'=>'required',
            'email'=>'nullable|email|string',
            'phone'=>'nullable|min:10|max:20',
//            'company'=>'nullable|max:200|required',
            'address'=>'nullable|required|max:200',
            'comment' =>'nullable|max:255',
        ]);
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
//            'company'=>$request->company,
            'address'=>$request->address,
            'type'=>"customer",
            'password'=>Hash::make('12345678'),
//            'comment'=>$request->comment,
        ]);
        $notification = notify("تم اضافة العميل بنجاح");
        return redirect()->route('customers.index')->with($notification);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $title = 'edit supplier';
        return view('admin.customers.edit',compact(
            'title','supplier'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $this->validate($request,[
            'name'=>'required|min:10|max:255',
//            'product'=>'required',
            'email'=>'nullable|email|string',
            'phone'=>'nullable|min:10|max:20',
            'company'=>'nullable|max:200|required',
            'address'=>'nullable|required|max:200',
            'comment' =>'nullable|max:255',
        ]);
        $supplier->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'company'=>$request->company,
            'address'=>$request->address,
            'product'=>$request->product,
            'comment'=>$request->comment,
        ]);
        $notification = notify("تم تعديل بيانات المورد بنجاح");
        return redirect()->route('suppliers.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Supplier::findOrFail($request->id)->delete();
    }
}
