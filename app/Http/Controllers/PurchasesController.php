<?php

namespace App\Http\Controllers;

use App\FiscalYear;
use App\Item;
use App\ItemsManagement;
use App\PurchaseDetail;
use App\PurchaseMaster;
use App\Supplier;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $purchases = PurchaseMaster::where('company_infos_id',auth()->user()->company_infos_id)->get();
        return view('purchases.index',compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::where('users_id',auth()->user()->id)->get();
        $fiscal_year = FiscalYear::where('status',1)->first();
        $purchase_no = $this->get_new_purchase_no();
        $items = Item::where('users_id',auth()->user()->id)->get();
        return view('purchases.create',compact('suppliers','items','fiscal_year','purchase_no'));
    }

    public function get_new_purchase_no(){
        $fiscal_year = FiscalYear::where('status',1)->first()->fiscal_year;
        $purchase_master = PurchaseMaster::where([
        ['users_id', '=', auth()->user()->id],
        ['fiscal_year', '=', $fiscal_year]
        ])->orderby('id','desc')->first()->purchase_no ?? 0;
        $purchase_no = substr($purchase_master,7,13) + 1;
        $purchase_max_no   = sprintf("%06d", $purchase_no);
        $purchase_no_max = 'P'.$fiscal_year.'-'.$purchase_max_no;
        return $purchase_no_max;
    }


    public function store(Request $request)
    {



//        $data = request()->validate([
//            'supplier_bill_no' => ['required'],
//            'supplier_bill_date' => ['required'],
//            'purchase_no' => ['required'],
//            'received_date' => ['required'],
//            'received_by' => ['required'],
//            'sub_total' => ['required'],
//            'discount' => ['required'],
//            'total_vat' => ['required'],
//            'total_amount' => ['required'],
//            'grand_total' => ['required'],
//            'item' => ['required'],
//            'amount' => ['required'],
//            'qty' => ['required'],
//            'discount' => ['required'],
//            'vat' => ['required'],
//            'grand_total' => ['required']
//            //'image' => 'required|image'
//        ]);



        if ( ! isset($request['is_payment_done']) )
            $request['is_payment_done'] = 'N';
        else
            $request['is_payment_done'] = 'Y';

        $fiscal_year = FiscalYear::where('status',1)->first()->fiscal_year;


        $purchase_master = new PurchaseMaster();
        $purchase_master->suppliers_id = $request->suppliers_id;
        $purchase_master->supplier_bill_no = $request->supplier_bill_no;
        $purchase_master->supplier_bill_date = $request->supplier_bill_date;
        $purchase_master->fiscal_year = $fiscal_year;
        $purchase_master->purchase_no = $request->purchase_no;
        $purchase_master->received_date = $request->received_date;
        $purchase_master->received_by = $request->received_by;
        $purchase_master->is_payment_done = $request->is_payment_done;
        $purchase_master->amount = $request->sub_total;
        $purchase_master->discount = $request->total_discount;
        $purchase_master->dis_per = $request->total_dis_per;
        $purchase_master->vat = $request->total_vat;
        $purchase_master->total_amount = $request->grand_total;
        $purchase_master->users_id = auth()->user()->id;
        $purchase_master->company_infos_id = auth()->user()->company_infos_id;
        $purchase_master->save();

        $purchase_master_id = PurchaseMaster::latest()->first()->id;
        $purchase_no = PurchaseMaster::latest()->first()->purchase_no;
        //return redirect(route('publisher.index'));
        // save master and get id then

        $items = $request->get('item');
        $editions = $request->get('edition');
        $amounts = $request->get('amount');
        $qtys = $request->get('qty');
        $discounts = $request->get('discount');
        $vats = $request->get('vat');
        $totals = $request->get('total');

        foreach ($items as $index => $item) {
            $detail = [];
            $detail['purchase_master_id'] = $purchase_master_id;
            $detail['purchase_no'] = $purchase_no;
            $detail['items_id'] = $item;
            $detail['edition'] = $editions[$index];
            $detail['amount'] = $amounts[$index];
            $detail['qty'] = $qtys[$index];
            $detail['discount'] = $discounts[$index];
            if ($discounts[$index]>0) {
                $detail['dis_per'] = ($discounts[$index]/$amounts[$index])*100;
            }
            $detail['vat'] = $vats[$index];
            $detail['total'] = $totals[$index];
            // create detail

            $purchase_detail = new PurchaseDetail();
            $purchase_detail->purchase_masters_id = $detail['purchase_master_id'];
            $purchase_detail->purchase_no = $detail['purchase_no'];
            $purchase_detail->items_id = $detail['items_id'];
            $purchase_detail->edition = $detail['edition'];
            $purchase_detail->amount = $detail['amount'];
            $purchase_detail->qty = $detail['qty'];
            $purchase_detail->discount = $detail['discount'];
            $purchase_detail->dis_per = $request->sub_total;
            $purchase_detail->vat = $detail['vat'];
            $purchase_detail->total_amount = $detail['total'];
            $purchase_detail->users_id = auth()->user()->id;
            $purchase_detail->company_infos_id = auth()->user()->company_infos_id;
            $purchase_detail->save();

            $purchase_details_id = PurchaseDetail::latest()->first()->id;

            $items_management = new ItemsManagement();
            $items_management->items_id = $detail['items_id'];
            $items_management->edition = $detail['edition'];
            $items_management->qty = $detail['qty'];
            $items_management->cur_qty = $detail['qty'];
            $items_management->purchase_details_id = $purchase_details_id;
            $items_management->users_id = auth()->user()->id;
            $items_management->company_infos_id = auth()->user()->company_infos_id;
            $items_management->save();
        }

        return redirect(route('purchase.index'));
    }

    public function print_purchase($id)
    {
        $purchase_master = PurchaseMaster::findorfail($id);
        $purchase_details = PurchaseDetail::where('purchase_masters_id',$id)->get();
        $company_info = auth()->user()->company_info;
        //dd($purchase_master);
        return view('purchases.print1',compact('purchase_master','purchase_details','company_info'));

    }

}
