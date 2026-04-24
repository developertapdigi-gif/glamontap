<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AbnExists implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $apiKey;

    public function __construct()
    {        
        $this->apiKey = env('ABR_API_KEY') ?? '72b70995-6b75-42fb-bdd7-e3720b97c3b1';
    }
    public function passes($attribute, $value)
    {   
        
        $value = str_replace(' ', '', $value);
        try {   
            $pincode = request()->pincode;
            $response = Http::get("https://abr.business.gov.au/json/AbnDetails.aspx", [
                'abn' => $value,
                'guid' => $this->apiKey,
            ]); 
            Log::info('ABN/ACN API response:', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);        
            if ($response->failed()) {
                return false;
            }
            $body = $response->body();
            if(str_contains($body,'Active') && str_contains($body,$value) && str_contains($body,$pincode) ){
                return true;
            }

        } catch (\Exception $e) {           
            Log::error("Error during ABN validation: " . $e->getMessage());
            return false;
        }
    }
    public function message()
    {
        return 'The provided ABN is invalid or does not exist or postal code does not match';
    }
}
