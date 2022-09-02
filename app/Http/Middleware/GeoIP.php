<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeoIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){
      if(!\Cookie::has('locale')){
        $ip = '185.230.124.74';
        $response = Http::get('http://api.ipstack.com/'.$ip.'?access_key='.config('app.geoIp.key'));
        if($response->successful()){
          $data = json_decode($response->body());
          if($data->location->languages){
            $languages = array_column($data->location->languages, 'code');
            foreach($languages as $locale){
              if(in_array($locale, ['en', 'da'])){
                \Cookie::queue(\Cookie::make('locale', $locale));
                break;
              }
            }
          }
        }
      }
      return $next($request);
    }
}
