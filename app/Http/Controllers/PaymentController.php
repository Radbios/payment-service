<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            "order_id" => ["required"]
        ]);

        $order_id = $validated["order_id"];

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $request->bearerToken()
        ])->get(env("APP_GATEWAY") . '/order/order/' . $order_id);

        $order = $response->json();

        if(!$order) {
            return response()->json([
                "status" => "error",
                "message" => "Número de ordem não existe"
            ]);
        }

        return response()->json([
            "payment" => [
                "link" => route("pay"),
                "method" => "post",
            ],
            "order" => $order
        ]);
    }

    public function pay(Request $request)
    {
        $validated = $request->validate([
            "order_id" => ["required"]
        ]);

        $order_id = $validated["order_id"];

        

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $request->bearerToken()
        ])->get(env("APP_GATEWAY") . '/order/order/' . $order_id);

        $order = $response->json();

        if(!$order) {
            return response()->json([
                "status" => "error",
                "message" => "Número de ordem não existe"
            ]);
        }

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $request->bearerToken()
        ])->put(env("APP_GATEWAY") . '/order/order/' . $order_id);

        $order = $response->json();

        return response()->json([
            "message" => "Pagamento efetuado com sucesso!",
            "order" => $order
        ]);
    }
}
