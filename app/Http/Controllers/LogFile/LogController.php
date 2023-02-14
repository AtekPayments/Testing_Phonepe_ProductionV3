<?php

namespace App\Http\Controllers\LogFile;

use App\Http\Controllers\Api\PhonePe\PhonePeStatusController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Modules\Processing\ProcessingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function makeLog($id)
    {
        $order = DB::table('sale_order')
            ->where('sale_or_no','=',$id)
            ->first();

        $paymentStatus = new PhonePeStatusController();
        $response = $paymentStatus->getPaymentStatus($order);


        if($response->success){
            $getTkt = new ProcessingController();
            $status = $getTkt->init($order->sale_or_no);

        }else{

            return response([
                'status' => false,
                'message' => "Unable to fetch response"
            ]);
        }
    }

}
