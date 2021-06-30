<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LottoController extends Controller
{
    public function index($year, $month, $date = null)
    {
        if($date){
            $handle = curl_init();
            $result = $this->getStaticOfDate($date, $month, $year, $handle);
            curl_close($handle);
            return $result;
        }
        
        return $this->getStaticOfMonth($month, $year);
    }

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    function getStaticOfDate($day, $month, $year, $handle){
        $static = [
            'de' => null,
            'lo' => [],
        ];

        try{
            $url = "https://xosodaiphat.com/xsmb-$day-$month-$year.html";
            
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            
            $html = curl_exec($handle);
        } catch(Exception $e){
            return $static;
        }
        $table = $this->get_string_between($html, 'table', '/table');
        $array = explode('span', $table);
        
        foreach($array as $index => $a){
            $number = $this->get_string_between($a, '>', '<');
            if(is_numeric($number)){
                $length = strlen($number);
                $lastTwoDigit = substr($number, $length - 2, $length);

                if(!$static['de']){
                    $static['de'] = $lastTwoDigit;
                    continue;
                }
                if(!isset($static['lo'][$lastTwoDigit])) $static['lo'][$lastTwoDigit] = 0;
                $static['lo'][$lastTwoDigit]++;
            }
        }
        return $static;
    }

    function getStaticOfMonth($month, $year){
        $maxDateOfMonth = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $static = [
            'de' => [],
            'lo' => [],
        ];
        $now = now();
        if($month > $now->month || $year > $now->year) return $static;

        $isCurrentMonth = $year == $now->year && $month == $now->month;
        $handle = curl_init();
        for($date = 1; $date <= $maxDateOfMonth[(int) $month]; $date++){
            if($isCurrentMonth && $date >= $now->day) break;

            $dateStatic = $this->getStaticOfDate($date, $month, $year, $handle);

            if($dateStatic['de']){
                if(!isset($static['de'][$dateStatic['de']])) $static['de'][$dateStatic['de']] = 0;
                $static['de'][$dateStatic['de']]++;
            }
            foreach($dateStatic['lo'] as $lo => $count){
                if(!isset($static['lo'][$lo])) $static['lo'][$lo] = 0;
                $static['lo'][$lo] += $count;
            }
        }
        curl_close($handle);
        return $static;
    }
}