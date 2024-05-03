<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::withCount('logs')->get();

        return view('vouchers.index', compact('vouchers'));
    }

    public function redeem($id)
    {
        DB::beginTransaction();
        try {
            $voucher = Voucher::find($id);
            if ($voucher->used >= $voucher->quota) {
                throw new \Exception('Voucher has been used up');
            }
            $voucher->used++;
            $voucher->save();

            $voucher->logs()->create([
                'voucher_id' => $voucher->id,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        
        return redirect()->route('vouchers.index');
    }
}
