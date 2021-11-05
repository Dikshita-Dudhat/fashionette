<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\ { Arr,Collection };
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Cache;
define ('CACHE_DAYS',7);

class ShowController extends Controller
{
    
    /**
     * API for getting show details
     */
    public function show(Request $request)
    {
        $all=$request->all();
        
        if(! Arr::exists($all, 'q')){
        
            return response('Request not proper!',400);
          
        }else{
            $search = strtolower($all['q']);
        }
        
       $response=$this->callAndStoreShow($search);
    
        if(!count($response)){
            return response()->json([
            'msg' => 'No Data found.',
            'state' => '200',
             ]);
        }
        return response()->json([
            'data'=>$response,
            'msg' => 'Data successfully retrive.',
            'state' => '200',
        ]);
    }


    /**
     * TVMaze API Call and store in cache file for 7 days
     */
    public function callAndStoreShow($search){
        $response= null;
        if(Cache::has($search)){
            $response = Cache::get($search);
        
        }else{
          
            $client = new \GuzzleHttp\Client();
            $request = $client->get('https://api.tvmaze.com/search/shows?q='.$search);
            $response = $request->getBody()->getContents();
            $response = json_decode($response, true);
            $response = collect($response)->filterName($search);
            $response=$response->toArray();
            $cacheExpireTime=Carbon::now()->addDays(CACHE_DAYS);
            Cache::put($search,$response,$cacheExpireTime);
         
        }
        return $response;
    }
}

/**
 * Create macro for filter data 
 */
Collection::macro('filterName', function ($search) {
    return $this->map(function ($value) use ($search) {
    $pattern= "/".$search."/i";
        if(preg_match($pattern, strtolower($value['show']['name']))){
        return $value;
    }
    })->filter();
});