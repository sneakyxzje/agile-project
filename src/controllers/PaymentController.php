<?php 

namespace App\controllers;
use App\models\User;

class PaymentController {
    public function createPayment()
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMO';
        $accessKey = 'F8BBA842ECF85';
        $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';
        $orderInfo = "Nạp kim cương vào tài khoản";
        $amount = $_POST['amount'];
        $orderId = time() . "";
        $redirectUrl = "http://localhost/project/momo/return";
        $ipnUrl = "https://interacademic-georgeann-unrelenting.ngrok-free.dev/project/momo/ipn";
        
        $extraData = base64_encode(json_encode([
            'id' => $_POST['id']
        ]));

        $requestId = time() . "";
        $requestType = "payWithATM";

        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl"
            . "&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode"
            . "&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        file_put_contents('momo_request.json', json_encode($data, JSON_PRETTY_PRINT));
        $result = curl_exec($ch);
        curl_close($ch);
        file_put_contents('momo_response.json', $result);

        $jsonResult = json_decode($result, true);

        if (isset($jsonResult['payUrl'])) {
            header('Location: ' . $jsonResult['payUrl']);
            exit;
        } else {
            echo "<h3>Lỗi tạo thanh toán MoMo!</h3>";
            echo "<pre>";
            var_dump($jsonResult);
            echo "</pre>";
        }
    }

public function handleIPN()
{
    $rawInput = file_get_contents('php://input');
    file_put_contents('ipn_raw.txt', date('Y-m-d H:i:s') . "\n" . $rawInput . "\n\n", FILE_APPEND);
    
    $data = json_decode($rawInput, true);
    
    file_put_contents('ipn_log.json', json_encode($data, JSON_PRETTY_PRINT));
    
    if (!$data) {
        file_put_contents('ipn_error.txt', date('Y-m-d H:i:s') . " - No data received\n", FILE_APPEND);
        http_response_code(200);
        echo json_encode(['message' => 'No data']);
        return;
    }
    
    $accessKey = 'F8BBA842ECF85';
    $secretKey = "K951B6PE1waDMi640xX08PD3vg6EkVlz";
    
    $rawHash = "accessKey=" . $accessKey
        . "&amount=" . $data['amount']
        . "&extraData=" . $data['extraData']
        . "&message=" . $data['message']
        . "&orderId=" . $data['orderId']
        . "&orderInfo=" . $data['orderInfo']
        . "&orderType=" . $data['orderType']
        . "&partnerCode=" . $data['partnerCode']
        . "&payType=" . $data['payType']
        . "&requestId=" . $data['requestId']
        . "&responseTime=" . $data['responseTime']
        . "&resultCode=" . $data['resultCode']
        . "&transId=" . $data['transId'];
    
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    
    file_put_contents('signature_check.txt', 
        "RawHash: $rawHash\n" .
        "Generated: $signature\n" . 
        "Received: " . $data['signature'] . "\n" .
        "Match: " . ($signature === $data['signature'] ? 'YES' : 'NO') . "\n\n", 
        FILE_APPEND
    );
    
    if ($signature !== $data['signature']) {
        file_put_contents('ipn_error.txt', 
            date('Y-m-d H:i:s') . " - Invalid signature\nRawHash: $rawHash\nGenerated: $signature\nReceived: {$data['signature']}\n", 
            FILE_APPEND
        );
        http_response_code(200);
        echo json_encode(['message' => 'Invalid signature']);
        return;
    }
    
    if ($data['resultCode'] == 0) {
        $extraData = json_decode(base64_decode($data['extraData']), true);
        
        file_put_contents('extraData_log.txt', 
            date('Y-m-d H:i:s') . " - " . print_r($extraData, true) . "\n", 
            FILE_APPEND
        );
        
        $userId = $extraData['id'] ?? null;
        $amount = (int) $data['amount'];
        $diamonds = $amount / 1000;
        
        if (!$userId) {
            file_put_contents('ipn_error.txt', 
                date('Y-m-d H:i:s') . " - User ID not found in extraData\n", 
                FILE_APPEND
            );
            http_response_code(200);
            echo json_encode(['message' => 'User ID missing']);
            return;
        }

        $user = User::find($userId);
        
        if ($user) {
            $oldDiamonds = $user->diamond;
            $newDiamonds = $oldDiamonds + $diamonds;
            
            User::update($userId, ['diamond' => $newDiamonds]);
            
            file_put_contents('diamond_success.txt', 
                date('Y-m-d H:i:s') . " - User $userId: $oldDiamonds -> $newDiamonds (+$diamonds)\n", 
                FILE_APPEND
            );
        } else {
            file_put_contents('ipn_error.txt', 
                date('Y-m-d H:i:s') . " - User not found: $userId\n", 
                FILE_APPEND
            );
        }
    } else {
        file_put_contents('ipn_error.txt', 
            date('Y-m-d H:i:s') . " - Payment failed. ResultCode: " . $data['resultCode'] . "\n", 
            FILE_APPEND
        );
    }

    http_response_code(200);
    echo json_encode(['message' => 'OK']);
}

    public function handleReturn()
    {
        view('clients.momo.success', []);
    }

    public function showForm()
    {
        view('clients.momo.payment_form', [
        'userId' => $_SESSION['user']['id']
    ]);
    }
}