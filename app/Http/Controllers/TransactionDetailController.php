<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Shipment;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionDetailController extends Controller
{

    function index(): Factory|View|Application
    {
        return view('pages.profile.profile-page-transaction');
    }

    function addTransaction(Request $request): JsonResponse|RedirectResponse
    {
        $userId = auth()->user()->id;
        $details = json_decode($request->input('shipment_ids'), true);;

        $message = [
            'location_id.required' => 'Location is required',
            'shipment_ids.required' => 'Shipment is required',
        ];

        $validate = Validator::make($request->all(), [
            'location_id' => 'required',
            'shipment_ids' => 'required',
        ], $message);

        if ($validate->fails()) {
            toastr()->error($validate->errors()->first(), '', ['positionClass' => 'toast-bottom-right', 'timeOut' => 3000,]);
            return redirect()->back()->withErrors($validate->errors())->withInput();
        }

        foreach ($details as $detail) {
            if (!Shipment::find($detail['shipmentId'])) {
                toastr()->error('Shipment not found');
                return response()->json([
                    'error' => 'Shipment not found',
                ], 500);
            }
        }

        $transactionId = Str::uuid();

        $transactionHeader = new TransactionHeader();
        $transactionHeader->id = $transactionId;
        $transactionHeader->user_id = $userId;
        $transactionHeader->location_id = $request->input('location_id');
        $transactionHeader->date = now();
        $transactionHeader->save();

        foreach ($details as $detail) {
            $shipmentId = $detail['shipmentId'];

            $cart = Cart::where('user_id', $userId)->where('product_id', $detail["productId"])->where('variant_id', $detail["variantId"])->first();

            $variant = ProductVariant::where('id', $detail["variantId"])->first();

            $promoInformation = getProductAfterPromo($detail["variantId"]);

            $transactionDetail = new TransactionDetail();
            $transactionDetail->transaction_id = $transactionId;
            $transactionDetail->product_id = $detail["productId"];
            $transactionDetail->variant_id = $detail["variantId"];
            $transactionDetail->shipment_id = $shipmentId;
            $transactionDetail->status = 'Pending';
            $transactionDetail->price = $promoInformation->discountedPrice;
            $transactionDetail->total_paid = calculateTotalPrice(
                                                $promoInformation->discountedPrice,
                                                $cart->quantity, $detail["merchantId"],
                                                $request->location_id, $shipmentId,
                                                getMaximumDiscount($detail["productId"])
                                            );
            $transactionDetail->discount = getMaximumDiscount($detail["productId"]);
            $transactionDetail->quantity = $cart->quantity;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image->move(public_path('storage/transaction/receipt'), $imageName);
                $transactionDetail->image = $imageName;
            }

            $transactionDetail->save();

            $variant = ProductVariant::where('id', $detail["variantId"])->first();
            $variant->stock = $variant->stock - $cart->quantity;
            $variant->save();

            $cart->delete();
        }

        return response()->json([
            'message' => 'Transaction success',
            'data' => null
        ], 200);
    }

    public function completeOrder(): JsonResponse
    {
        $transactionId = request()->transaction_id;
        $variantId = request()->variant_id;
        $productId = request()->product_id;
        $transactionDetail = TransactionDetail::where('transaction_id', $transactionId)->where('variant_id', $variantId)->where('product_id', $productId)->first();
        $transactionDetail->status = 'Shipping';
        $transactionDetail->save();

        return response()->json([
            'message' => 'Transaction success',
            'data' => null
        ], 200);
    }

    public function rejectOrder(): JsonResponse
    {
        $transactionId = request()->transaction_id;
        $variantId = request()->variant_id;
        $productId = request()->product_id;
        $transactionDetail = TransactionDetail::where('transaction_id', $transactionId)->where('variant_id', $variantId)->where('product_id', $productId)->first();
        $transactionDetail->status = 'Rejected';
        $transactionDetail->save();

        return response()->json([
            'message' => 'Rejection success',
            'data' => null
        ], 200);
    }

    public function shipmentDone(): JsonResponse
    {
        $transactionId = request()->transaction_id;
        $variantId = request()->variant_id;
        $productId = request()->product_id;
        $transactionDetail = TransactionDetail::where('transaction_id', $transactionId)->where('variant_id', $variantId)->where('product_id', $productId)->first();
        $transactionDetail->status = 'Completed';
        $transactionDetail->save();

        return response()->json([
            'message' => 'Shipment done',
            'data' => null
        ], 200);
    }


}
