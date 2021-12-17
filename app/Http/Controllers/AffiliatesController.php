<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AffiliateRepository;

class AffiliatesController extends Controller
{
    public function __construct(AffiliateRepository $affiliateRepo)
    {
        $this->affiliateRepo = $affiliateRepo;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getAffliates(){
        
        $affilename ='affiliates.txt';
        $affiliates = $this->affiliateRepo->getAffiliates($affilename);

        return view('affiliates',compact('affiliates'));
    }
}
