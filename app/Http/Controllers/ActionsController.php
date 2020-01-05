<?php

namespace App\Http\Controllers;

use App\Helpers\DataCacheHelper;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\LikeRequest;
use App\Http\Requests\ReportRequest;
use App\Models\Report;
use Illuminate\Http\Request;

class ActionsController extends Controller
{
    public function like(LikeRequest $request)
    {
        $like = DataCacheHelper::getLikes($request->phone->id, $request);

        return response()->json(['response' => ['like' => $like]]);
    }

    public function comment(CommentRequest $request)
    {
        preg_match('(http|https|www)', $request->message, $message);
        if (count($message) > 0) {
            return redirect('/phone/' . $request->phone->short_number)->with([
                'msg'  => 'Message field should not contain url',
                'type' => 'alert-danger'
            ]);
        }
        DataCacheHelper::getRating($request->phone->id, $request);

        return redirect('/phone/' . $request->phone->short_number)->with([
            'msg'  => 'Comment in review!',
            'type' => 'alert-success'
        ]);
    }

    public function report(ReportRequest $request)
    {
        $country_code = '' . env('COUNTRY_CODE');
        $number       = self::getNumber($country_code, $request);
        $report       = Report::create(array_merge([
            'phoneId' => $number,
            'ip'      => $request->ip(),
            'agent'   => $request->header('User-Agent'),
            'rating'  => $request->input('rating', 0)
        ], $request->only(['name', 'email', 'owner', 'type', 'message'])));

        return response()->json(['response' => $report, 'msg' => 'Report in review!']);
    }

    /**
     * @param $country_code
     * @param Request $request
     *
     * @return string
     */
    public static function getNumber($country_code, $request)
    {
        preg_match('/^\d/', $request->input('number'), $first);
        preg_match('/^\d{' . strlen($country_code) . '}/', $request->input('number'), $two);
        $number = $country_code . '' . $request->input('number');
        if ($first[0] === env('LOCAL_CODE')) {
            $number = ($country_code . $num = substr($request->input('number'), 1));
        }
//        elseif($two[0] === $country_code){
//            $number = $request->input('number');
//        }
        return $number;
    }
}