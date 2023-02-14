<?php

namespace App\Http\Controllers\Callback;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogFile\LogController;
use App\Http\Controllers\Modules\Processing\ProcessingController;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function PaymentCallback(Request $request, $id)
    {
        $data = file_get_contents("php://input");

        //Here, you now have event and can process them how you like e.g Add to the database or generate a response
        $file = 'log.txt';
        $data = "\n\n$id\n". $request->getContent();

        file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

        return response([
            'status' => true,
            'response' => "File Created successfully"
        ]);

        /*if ($data->code == "PAYMENT_SUCCESS") {
            $api = new ProcessingController();
            $res = $api->init($id);
            $data = $res->getContent();

        } else {
            return response([
                'status' => false,
                'response' => "Payment Failed"
            ]);
        }*/
    }
}
