<?php

namespace App\Http\Middleware;

use Closure;

class CheckForActivation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $tmp = explode('.', $request->url());
        $parts = explode('//', $tmp[0]);
        $subdomain = $parts[1];

        $website = \DB::connection('master')->table('sum_websites')
            ->where('sitedoname',$subdomain)->first();

        if(!$website)
        {
            return redirect('http://djaring.id/website-not-found?website='.$subdomain);
        }

        // check website activated or not
        if((int)$website->activated !== 1)
        {
            // get the package info
            $package = \DB::connection('master')->table('ms_packages')
            ->where('id',$website->package_id)->first();
            
            if(!$package)
            {
                // package not found
                return redirect('http://djaring.id/website-not-found?website='.$subdomain);
            }

            if((int)$package->price !== 0)
            {
                // package not free
                return redirect('http://djaring.id/website-not-found?website='.$subdomain);
            }
        }

        return $next($request);
    }
}
