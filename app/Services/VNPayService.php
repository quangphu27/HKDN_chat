<?php

namespace App\Services;

class VNPayService
{
    protected $vnp_TmnCode;
    protected $vnp_HashSecret;
    protected $vnp_Url;
    protected $vnp_Version;
    protected $vnp_Command;
    protected $vnp_CurrCode;
    protected $vnp_Locale;
    protected function generateTransactionReference()
    {
        return (int)(microtime(true) * 10000000);
    }
    public function __construct()
    {
        $this->vnp_TmnCode = config('services.vnpay.TmnCode') ?? throw new \Exception("VNPAY TmnCode is not configured.");
        $this->vnp_HashSecret = config('services.vnpay.HashSecret') ?? throw new \Exception("VNPAY HashSecret is not configured.");
        $this->vnp_Url = config('services.vnpay.BaseUrl') ?? throw new \Exception("VNPAY BaseUrl is not configured.");
        $this->vnp_Version = config('services.vnpay.Version') ?? '2.1.0';
        $this->vnp_Command = config('services.vnpay.Command') ?? 'pay';
        $this->vnp_CurrCode = config('services.vnpay.CurrCode') ?? 'VND';
        $this->vnp_Locale = config('services.vnpay.Locale') ?? 'vn';
    }
    public function createPaymentUrl($userId, $amount, $returnUrl)
    {
        if (!is_numeric($amount) || $amount <= 0) {
            throw new \InvalidArgumentException("Invalid amount: $amount");
        }

        $vnp_Url = $this->vnp_Url;
        $vnp_HashSecret = $this->vnp_HashSecret;
        $vnp_TxnRef = $this->generateTransactionReference();
        $vnp_Amount = $amount * 100; // Quy đổi sang đơn vị VNĐ x100
        $vnp_IpAddr = request()->ip();

        $inputData = [
            "vnp_Version" => $this->vnp_Version,
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => $this->vnp_Command,
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $this->vnp_Locale,
            "vnp_OrderInfo" => "Nang cap Premium cho user ID: $userId",
            "vnp_OrderType" => "250006",
            "vnp_BankCode" => "VNBANK",
            "vnp_ReturnUrl" => $returnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => now()->addMinutes(15)->format('YmdHis')
        ];
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }
}
