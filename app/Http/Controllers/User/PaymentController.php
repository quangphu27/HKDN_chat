<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Services\VNPayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $vnpayService;

    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function index()
    {
        return view('user.Payment.index');
    }

    public function createPayment(Request $params)
    {
        $userid = $params['userid'];
        $amount = $params['amount'];

        $returnUrl = route('user.payment.callback');

        $paymentUrl = $this->vnpayService->createPaymentUrl($userid, $amount, $returnUrl);

        return redirect($paymentUrl);
    }

    public function paymentCallback(Request $request)
    {
        $inputData = $request->all();
        $vnp_HashSecret = config('services.vnpay.HashSecret'); // Lấy secret key từ config
        $vnpSecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);

        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        
        $hashData = rtrim($hashData, '&');
        $calculatedHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($calculatedHash === $vnpSecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                $userId = $this->extractUserIdFromOrderInfo($inputData['vnp_OrderInfo']);
                $user = User::find($userId);

                if ($user) {
                    Transaction::create([
                        'user_id' => $user->id,
                        'amount' => $inputData['vnp_Amount'] / 100,
                        'transaction_reference' => $inputData['vnp_TxnRef'],
                        'response_code' => $inputData['vnp_ResponseCode'],
                        'transaction_date' => now(),
                        'status' => 'success'
                    ]);
                    $user->update(['isPremium' => true]);

                    return redirect()->route('user.payment.success')->with('success', 'Nâng cấp Premium thành công!');
                }
            }
        }

        return redirect()->route('user.payment.fail')->with('error', 'Giao dịch không thành công hoặc không hợp lệ!. Mã lỗi: ' + $inputData['vnp_ResponseCode']);
    }
    public function success()
    {
        return view('user.Payment.success');
    }
    public function fail()
    {
        return view('user.Payment.fail');
    }
    private function extractUserIdFromOrderInfo($orderInfo)
    {
        if (preg_match('/user ID: (\d+)/', $orderInfo, $matches)) {
            return (int)$matches[1];
        }
        return null;
    }
}
