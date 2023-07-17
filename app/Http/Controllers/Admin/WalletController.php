<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\BalanceWithdrawal;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    use ImagesTrait;
    private $userModel, $transactionModel, $carbonModel, $walletModel, $balanceModel;
    public function __construct(User $user, Transaction $transaction, Carbon $carbon, Wallet $wallet, BalanceWithdrawal $balance)
    {
        $this->userModel = $user;
        $this->transactionModel = $transaction;
        $this->carbonModel = $carbon;
        $this->walletModel = $wallet;
        $this->balanceModel = $balance;
    }

    public function wallet($id)
    {
        $exports = [];
        $additions = [];
        $delivery = $this->userModel::find($id);
        $transactions = $this->transactionModel::where('user_id', $id)->get();
        foreach ($transactions as $transaction) {
            $transaction->date = $this->carbonModel::parse($transaction->updated_at)->format('Y-m-d');
            if ($transaction->order_id) {
                array_push($exports, $transaction);
            } else {
                array_push($additions, $transaction);
            }
        }
        $wallets = $this->walletModel::where('user_id', $id)->get();
        foreach ($wallets as $wallet) {
            $wallet->date = $this->carbonModel::parse($wallet->updated_at)->format('Y-m-d');
        }
        return view('Admin.users.wallet', compact('id', 'delivery', 'transactions', 'wallets', 'exports', 'additions'));
    }

    public function addtransactions(Request $request)
    {
        $request->validate([
            'deliaryId' => 'required|exists:users,id',
            'walletvalue' => 'required|numeric',
        ]);

        $delivery = $this->userModel::find($request->deliaryId);
        $newValue = $request->walletvalue + $delivery->wallet;
        $delivery->update(['wallet' => $newValue]);

        $this->transactionModel::create([
            'user_id' => $request->deliaryId,
            'total' => $request->walletvalue,
            'type' => 'additions',
        ]);

        return back()->with('done', __('dashboard.updateWalletSuccess'));
    }
    public function addWallet(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
            'walletvalue' => 'required|numeric',
        ]);

        $user = $this->userModel::find($request->userId);
        $newValue = $request->walletvalue + $user->wallet;
        $user->update(['wallet' => $newValue]);
        $year = $this->carbonModel::now()->format('Y');
        $month = $this->carbonModel::now()->format('m');
        $day = $this->carbonModel::now()->format('d');
        $walletCount = $this->walletModel::whereDate('created_at', '=', $this->carbonModel::today())->count();
        $date = $year[2] . $year[3] . $month . $day . (sprintf('%04u', $walletCount + 1));
        $date = (int) $date;
        $this->walletModel::create([
            'user_id' => $request->userId,
            'Financial_additions' => $newValue,
            'walletId' => $date,
            'type' => 'throwback',
        ]);

        return back()->with('done', __('dashboard.updateWalletSuccess'));
    }

    public function balancesRequest()
    {
        $newBalances = $this->balanceModel::where('status', 0)->get();
        foreach ($newBalances as $balance) {
            $balance->date = $this->carbonModel::parse($balance->updated_at)->format('Y-m-d');
        }
        return view('Admin.balances', compact('newBalances'));
    }
    public function balance($id)
    {
        $user = $this->userModel::find($id);
        $accaptedBalances = $this->balanceModel::where(['user_id' => $id, 'status' => 1])->get();
        $rejecetedBalances = $this->balanceModel::where(['user_id' => $id, 'status' => 2])->get();
        $newBalances = $this->balanceModel::where(['user_id' => $id, 'status' => 0])->get();
        foreach ($newBalances as $balance) {
            $balance->date = $this->carbonModel::parse($balance->updated_at)->format('Y-m-d');
        }
        foreach ($rejecetedBalances as $balance) {
            $balance->date = $this->carbonModel::parse($balance->updated_at)->format('Y-m-d');
        }
        foreach ($accaptedBalances as $balance) {
            $balance->date = $this->carbonModel::parse($balance->updated_at)->format('Y-m-d');
        }
        return view('Admin.users.balances', compact('accaptedBalances', 'rejecetedBalances', 'newBalances', 'user'));
    }

    public function accapetBalance(Request $request)
    {
        $request->validate([
            'balanceId' => 'required|exists:balance_withdrawals,id',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $imageName = time()  . '_wallet.' . $request->image->extension();
        $this->uploadImage($request->image, $imageName, 'wallet');

        $balance = $this->balanceModel::find($request->balanceId);
        $this->userModel::where('id', $balance->user_id)->update([
            'balance' => $balance->user->balance - $balance->total
        ]);
        $balance->update([
            'status' => 1,
            'image' => $imageName
        ]);

        return back()->with('done', __('dashboard.accepetBalanceMessage'));
    }
    public function rejecetBalance($id)
    {
        $this->balanceModel::where('id', $id)->update(['status' => 2]);
        return back()->with('done', __('dashboard.rejecetBalanceMessage'));
    }
}
