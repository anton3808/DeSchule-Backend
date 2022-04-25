<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Payment;
use Mockery\Exception;

class PaymentController extends Controller
{
    protected $payment;

    public function __construct(Payment $payment){
        $this->payment = $payment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth('api')->user();

        $payment = $this->payment;
        $payment = $payment->where('user_id', $user->id);

        $payment = $payment->paginate($request->get('limit', 15));

        return $payment;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data = $request->all();
            $user = auth('api')->user();
            $data['user_id'] = $user->id;
            $payment = $this->payment->create($data);

            return response()->json([
                "status" => "success",
                "message" => "успішно створено",
                "data" => $payment
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                "error" => "could_not_create",
                "message" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth('api')->user();

        return $this->payment->where('user_id', $user->id)->first($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
