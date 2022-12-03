<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetails;
use App\Models\Transactions;
use App\Models\TravelPackages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request, $id)
    {
        $item = Transactions::with(['details', 'travel_packages', 'user'])->findOrFail($id);

        return view('pages.checkout', [
            'item' => $item
        ]);
    }

    public function process(Request $request, $id)
    {
        $travel_package = TravelPackages::findOrFail($id);

        $transaction = Transactions::create([
            'travel_packages_id' => $id,
            'user_id' => Auth::user()->id,
            'additional_visa' => 0,
            'transactions_total' => $travel_package->price,
            'transactions_status' => 'IN_CART'
        ]);

        TransactionDetails::create([
            'transactions_id' => $transaction->id,
            'username' => Auth::user()->username,
            'nationality' => 'ID',
            'is_visa' => false,
            'doe_passport' => Carbon::now()->addYears(5)
        ]);

        return redirect()->route('checkout', $transaction->id);
    }

    public function remove(Request $request, $detail_id)
    {
        $item = TransactionDetails::findorFail($detail_id);

        $transaction = Transactions::with(['details', 'travel_packages'])
            ->findOrFail($item->transactions_id);

        if ($item->is_visa) {
            $transaction->transactions_total -= 190;
            $transaction->additional_visa -= 190;
        }

        $transaction->transactions_total -= $transaction->travel_packages->price;

        $transaction->save();
        $item->delete();

        return redirect()->route('checkout', $item->transactions_id);
    }

    public function create(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|exists:users,username',
            'is_visa' => 'required|boolean',
            'doe_passport' => 'required',
        ]);

        $data = $request->all();
        $data['transactions_id'] = $id;

        TransactionDetails::create($data);

        $transaction = Transactions::with(['travel_packages'])->find($id);

        if ($request->is_visa) {
            $transaction->transactions_total += 190;
            $transaction->additional_visa += 190;
        }

        $transaction->transactions_total += $transaction->travel_packages->price;

        $transaction->save();

        return redirect()->route('checkout', $id);
    }

    public function success(Request $request, $id)
    {
        $transaction = Transactions::findOrFail($id);
        $transaction->transactions_status = 'PENDING';

        $transaction->save();

        return view('pages.success');
    }
}
