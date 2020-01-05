<meta name="keywords" content="{{$phone->aliases}}">
<meta name="description" content="{{trans('pages.meta.description', [
    'phone'=>$phone->short_number,
    'city' => isset($phone->city->location)? $phone->city->location: '-',
    'search' => $phone->views_count,
    'last_comment' => strlen(end($comments->toArray()['data'])['message']) >= 40?
     substr(end($comments->toArray()['data'])['message'], 0, 40) . '...':end($comments->toArray()['data'])['message'],
    'rate_count' => $like->positive + $like->negative,
    'site_name' => $site_name->value,
])}}">
@if ($like->positive + $like->negative !=0 && $phone->city)
    <title>{{trans('phone.title_phone_three', [
    'phone'=>$phone->short_number,
    'city' => isset($phone->city->location)? ' - ' . $phone->city->location: '',
    'middle_rating' => $middle_rating['middle'] == 0 ?'':' - ' . $middle_rating['middle'],
    'rating' => $like->positive + $like->negative,
    'country' => env('COUNTRY'),
])}}</title>
@elseif($phone->city)
    <title>{{trans('phone.title_phone_three', [
    'phone'=>$phone->short_number,
    'city' => isset($phone->city->location)? ' - ' . $phone->city->location: '',
    'country' => env('COUNTRY'),
])}}</title>
@elseif($like->positive + $like->negative !=0)
    <title>{{trans('phone.title_phone_four', [
    'phone'=>$phone->short_number,
    'rating' => $like->positive + $like->negative,
    'country' => env('COUNTRY'),
])}}</title>
@else
    <title>{{trans('phone.title_phone', [
    'phone'=>$phone->short_number,
    'middle_rating' => $middle_rating['middle'] == 0 ?'':' - ' . $middle_rating['middle'],
    'country' => env('COUNTRY'),
])}}</title>
@endif

