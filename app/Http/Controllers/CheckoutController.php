<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlans as Plan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\{AgencySubscription,SubscriptionTransaction,PlansAddon,SubscriptionPlans};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Stripe\Stripe;
use Laravel\Cashier\{Subscription,Cashier};
class CheckoutController extends Controller
{
    /**
     * @return View|Factory|Application
     */
    public function index(Request $request)
    {
        $addon_id =0;
        if($request->addon == 1){
            $addon_id = $request->id;
            $amount = $request->type; 
            $amount = 0;
            $plan = Plan::find(6);
            foreach(explode(",",$addon_id) as $id){
                $addon_plan = PlansAddon::find($id);
                $amount += $addon_plan->price;
            }
        
            $prices = Cashier::stripe()->prices->all([
                'product' => $plan->stripe_product_id,
                'active' => true, 
                'limit' => 100, 
            ]);
            $priceID = '';
            foreach ($prices->data as $price) {           
                $unit_amount = $price->unit_amount / 100;
                if ($unit_amount==$amount) {
                    $priceID = $price->id;
                }
            }
            if(!$request->id){
                return redirect('subscription')->with('error', 'Please choose a plan');
            }
            return $request->user()->checkout([$priceID],[
                'success_url' => route('stripe.success').'?addon='.str_replace(',','-',$addon_id),
                'cancel_url' => route('stripe.failure'),
            ]);
           
        }else{ 
            if(!$request->id){
                return redirect('subscription')->with('error', 'Please choose a plan');
            }
            $plan = Plan::find($request->id);
            if(!$plan){
                return redirect('subscription')->with('error', 'Please choose a valid plan');
            } 
            $priceID    = $request->type ==1 ?  $plan->stripe_monthly_price_id : $plan->stripe_yearly_price_id;
            return $request->user()->newSubscription($plan->stripe_product_id,$priceID)
                ->checkout([
                'success_url' => route('stripe.success'),
                'cancel_url' => route('stripe.failure'),
            ]); 
        } 
    }
    public function failure(Request $request){
        return view('checkout.failed');
    }
    public function success(Request $request){
        return view('checkout.success');
    }
    /**
     * @return RedirectResponse
     * @throws ApiErrorException
     */
    public function charge(Request $request)
    {     
        $request->user()->newSubscription(
        'prod_Ri4ycXaKPR6RPe', 'price_1QoeoyHSfMJ3kIX5gUztrkH0'
        )->create($request->paymentMethodId);   

    }

    public function unSubscribe(){
        // Get all active subscriptions...
        $subscriptions = Subscription::query()->active()->get();
        if(count($subscriptions)){
            foreach($subscriptions as $_subscription){
                if($_subscription->user_id == Auth::user()->id){
                    $_subscription->cancel();
                }
            }
            return redirect('subscription')->with('success', 'Unsubscribed successfully!');
        }else{
            return redirect('subscription')->with('success', 'Unsubscribed not done!');
        }
        
    }
}
/*
https://stackoverflow.com/questions/59282024/export-transactions-require-a-customer-name-and-address-stripe-error
Stripe\Charge Object
(
    [id] => ch_1QDUMvHSfMJ3kIX544T8RwLf
    [object] => charge
    [amount] => 100
    [amount_captured] => 100
    [amount_refunded] => 0
    [application] => 
    [application_fee] => 
    [application_fee_amount] => 
    [balance_transaction] => txn_1QDUMwHSfMJ3kIX5HZPxK1rq
    [billing_details] => Stripe\StripeObject Object
        (
            [address] => Stripe\StripeObject Object
                (
                    [city] => 
                    [country] => 
                    [line1] => 
                    [line2] => 
                    [postal_code] => 12365
                    [state] => 
                )

            [email] => 
            [name] => 
            [phone] => 
        )

    [calculated_statement_descriptor] => Stripe
    [captured] => 1
    [created] => 1729789121
    [currency] => inr
    [customer] => cus_R5fisbGFGpQeas
    [description] => TrueCAD 2021 Premium
    [destination] => 
    [dispute] => 
    [disputed] => 
    [failure_balance_transaction] => 
    [failure_code] => 
    [failure_message] => 
    [fraud_details] => Array
        (
        )

    [invoice] => 
    [livemode] => 
    [metadata] => Stripe\StripeObject Object
        (
        )

    [on_behalf_of] => 
    [order] => 
    [outcome] => Stripe\StripeObject Object
        (
            [network_status] => approved_by_network
            [reason] => 
            [risk_level] => normal
            [risk_score] => 47
            [seller_message] => Payment complete.
            [type] => authorized
        )

    [paid] => 1
    [payment_intent] => 
    [payment_method] => card_1QDUMsHSfMJ3kIX5RSCwjtRX
    [payment_method_details] => Stripe\StripeObject Object
        (
            [card] => Stripe\StripeObject Object
                (
                    [amount_authorized] => 100
                    [authorization_code] => 
                    [brand] => visa
                    [checks] => Stripe\StripeObject Object
                        (
                            [address_line1_check] => 
                            [address_postal_code_check] => pass
                            [cvc_check] => pass
                        )

                    [country] => US
                    [exp_month] => 11
                    [exp_year] => 2030
                    [extended_authorization] => Stripe\StripeObject Object
                        (
                            [status] => disabled
                        )

                    [fingerprint] => XEaJ10ET9JEjoWVs
                    [funding] => credit
                    [incremental_authorization] => Stripe\StripeObject Object
                        (
                            [status] => unavailable
                        )

                    [installments] => 
                    [last4] => 1111
                    [mandate] => 
                    [multicapture] => Stripe\StripeObject Object
                        (
                            [status] => unavailable
                        )

                    [network] => visa
                    [network_token] => 
                    [overcapture] => Stripe\StripeObject Object
                        (
                            [maximum_amount_capturable] => 100
                            [status] => unavailable
                        )

                    [three_d_secure] => 
                    [wallet] => 
                )

            [type] => card
        )

    [receipt_email] => 
    [receipt_number] => 
    [receipt_url] => https://pay.stripe.com/receipts/payment/CAcaFwoVYWNjdF8xRzNpVEZIU2ZNSjNrSVg1KML56bgGMgarlS_QplQ6LBaodPgCOT3aynxbpc1KwutpRD_Gm2QXyNtpzHYXJeG7N9rz6Wq35aMRk0Gx
    [refunded] => 
    [review] => 
    [shipping] => 
    [source] => Stripe\Card Object
        (
            [id] => card_1QDUMsHSfMJ3kIX5RSCwjtRX
            [object] => card
            [address_city] => 
            [address_country] => 
            [address_line1] => 
            [address_line1_check] => 
            [address_line2] => 
            [address_state] => 
            [address_zip] => 12365
            [address_zip_check] => pass
            [brand] => Visa
            [country] => US
            [customer] => cus_R5fisbGFGpQeas
            [cvc_check] => pass
            [dynamic_last4] => 
            [exp_month] => 11
            [exp_year] => 2030
            [fingerprint] => XEaJ10ET9JEjoWVs
            [funding] => credit
            [last4] => 1111
            [metadata] => Stripe\StripeObject Object
                (
                )

            [name] => 
            [tokenization_method] => 
            [wallet] => 
        )

    [source_transfer] => 
    [statement_descriptor] => 
    [statement_descriptor_suffix] => 
    [status] => succeeded
    [transfer_data] => 
    [transfer_group] => 
)

*/