<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserFeedbackSurvey;

class FeedbackSurveyController extends BaseController
{
    public function feedbackSurveySave(Request $request){
        $user = request()->user();
        $validator = Validator::make($request->all(), [
            'rating' =>['required'],
            'comment'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 400);
        } else{
            $model = UserFeedbackSurvey::where('user_id',$user->id)->first();
            if($model){
                $model->rating = $request->rating;
                $model->comment = $request->comment;
                $model->save();
            }else{
                $model = UserFeedbackSurvey::create([
                'user_id'=>$user->id,
                'rating'=>$request->rating,
                'comment'=>$request->comment
            ]);
            }
            return $this->responseApi([], true,"Thanks for sharing your experience with us!", 200);
            
        }
    }
}
