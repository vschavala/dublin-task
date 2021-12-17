<?php

namespace App\Repositories;

use Exception;
use Illuminate\Http\Request;


class AffiliateRepository{

    private $affiliatePath = '../storage/app/dublin/';
    private $dublinLocation= [53.3340285, -6.2535495];

    /**
     * get affiliates function to fetch affiliates
     *
     * @param [type] $affilename
     * @return void
     */
    public function getAffiliates($affilename){
        $affiliates=[];

        //open file
        try{
            $affile = fopen($this->affiliatePath.$affilename,'r');
        }catch(Exception $e){
            return "file not found";
        }
        //read file and convert json to array
        while(($afline=fgets($affile))!=false){
            $eachRow=(array)json_decode($afline);
            $affiliates[$eachRow['affiliate_id']] = $eachRow;
        }
        fclose($affile);

        //sort array by id
        ksort($affiliates);

        return $this->getNearByAffiliates($affiliates);
    }

    /**
     * get near by affiliates 
     *
     * @param [type] $affiliates
     * @param integer $distance
     * @return void
     */
    public function getNearByAffiliates($affiliates,$distance =100){

        $withInArea= [];
        foreach($affiliates as $affiliate){
            $gcDistance = $this->findGreateCircleDistance([$affiliate['latitude'],$affiliate['longitude']],$this->dublinLocation);
            if( $gcDistance < $distance){
                $res['affiliate_id'] = $affiliate['affiliate_id'];
                $res['name'] = $affiliate['name'];
                $res['distance'] = $gcDistance;
                $withInArea[] = $res;
               
            }
        }
         return $withInArea;
    }

    /**
     * calculate the greater circle
     *
     * @param [type] $affiliateLoc
     * @param [type] $dublinLocation
     * @return void
     */
    public function findGreateCircleDistance($affiliateLoc,$dublinLocation){
        if(!isset($affiliateLoc) || !isset($dublinLocation)){
            throw new Exception("Missing locations");
        }

        //Greater circlr formula
        $pointsDiff = $affiliateLoc[1] - $dublinLocation[1];
        $gcd = sin(deg2rad($affiliateLoc[0])) * sin(deg2rad($dublinLocation[0])) +  cos(deg2rad($affiliateLoc[0])) * cos(deg2rad($dublinLocation[0])) * cos(deg2rad($pointsDiff)); 
         
        //this is to avoid to cause NaN errors when rounding $gcd get bigger than 1 or less than -1 
         $gcd = acos(min(max($gcd,-1.0),1.0)); 
         $gcd = rad2deg($gcd);

         //distance in Km
        //number of minutes in a degree

        $distance = ($gcd * 60 * 1.1515)* 1.609344;
        return $distance;

    }
    
}