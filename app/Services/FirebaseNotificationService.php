<?php
namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
class FirebaseNotificationService
{
    /**
     * Generate access token for Firebase Cloud Messaging.
     *
     * @return string|null
     */
    private function generateAccessToken()
    {
        // Check if the token exists in cache
        if (Cache::has('firebase_access_token')) {
            return Cache::get('firebase_access_token');
        }
        try {
            // Path to the service_account.json file
            $credentialsFilePath = storage_path('app/private/tradehook-d3670-e0b18c24f57a.json');
            // Create credentials object
            $credentials = new ServiceAccountCredentials(
                ['https://www.googleapis.com/auth/firebase.messaging'],
                $credentialsFilePath
            );
            // Fetch the token
            $token = $credentials->fetchAuthToken();
            $accessToken = $token['access_token'];
            // Cache the token for 55 minutes
            Cache::put('firebase_access_token', $accessToken, now()->addMinutes(55));
            return $accessToken;
        } catch (\Exception $e) {
            Log::error('Error generating access token: ' . $e->getMessage());
            return null;
        }
    }
    /**
     * Send push notifications via Firebase Cloud Messaging.
     *
     * @param $to
     * @param string $title
     * @param string $body
     */
    public function sendPushNotificationSync($message)
    {
        // Generate access token for Firebase
        $access_token = $this->generateAccessToken();
        // Retrieve the user's device details
        // Define the FCM endpoint
        $fcmEndpoint = 'https://fcm.googleapis.com/v1/projects/tradehook-d3670/messages:send'; 
        try {
            // Prepare the message payload (title and body only)
            /*$message = [
                'message' => [
                    'token' => $device_token,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body
                    ],
                    'data'=>[
                        'type'=>'agency_job_accept',
                        'id'=>'181'
                    ]
                ]
            ];*/
            // Send the notification via HTTP POST request
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
            ])->post($fcmEndpoint, $message); 
            // Log the result of the notification
            if ($response->status() == 200) {                
                Log::info('Notification sent successfully: ' . $response->body());                
            } else {
                Log::error('Error sending FCM notification: ' . $response->body());
            }
            return $response->body();
        } catch (\Exception $e) {
            Log::error('Error sending FCM notification: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
}