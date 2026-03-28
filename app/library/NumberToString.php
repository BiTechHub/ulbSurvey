<?php
namespace App\library;

class NumberToString
{
    public function displaywords($number)
    {
        $decimal       = round($number - ($no = floor($number)), 2) * 100;
        $hundred       = null;
        $digits_length = strlen($no);
        $i             = 0;
        $str           = array();
        $words         = array(0 => '', 1          => 'one', 2        => 'two',
            3                        => 'three', 4     => 'four', 5       => 'five', 6 => 'six',
            7                        => 'seven', 8     => 'eight', 9      => 'nine',
            10                       => 'ten', 11      => 'eleven', 12    => 'twelve',
            13                       => 'thirteen', 14 => 'fourteen', 15  => 'fifteen',
            16                       => 'sixteen', 17  => 'seventeen', 18 => 'eighteen',
            19                       => 'nineteen', 20 => 'twenty', 30    => 'thirty',
            40                       => 'forty', 50    => 'fifty', 60     => 'sixty',
            70                       => 'seventy', 80  => 'eighty', 90    => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number  = floor($no % $divider);
            $no      = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural  = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[]   = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else {
                $str[] = null;
            }

        }
        $Rupees = implode('', array_reverse($str));
        $paise  = ($decimal > 0) ? ". " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees' : '') . $paise;
    }

    public function paymentStatus($number)
    {
        $ret="";
        $ret1="";
        switch($number){
            case "421":
            {
                $ret="Unauthorised Access";
                $ret1="Public IP and Domain Name need to be whitelisted";
                break;
            }
            case "422":
            {
                $ret="Corp match not found";
                $ret1="Public IP and Domain Name need to be whitelisted";
                break;
            }
            case "423a":
            {
                $ret="Required parameters are missing";
                $ret1="The requested ‘i’ parameter is missing";
                break;
            }
            case "423b":
            {
                $ret="Required parameters are missing";
                $ret1="Please check the request parameters and encryption done";
                break;
            }
            case "424":
            {
                $ret="Duplicate Request or Customer Ref Number already exist";
                $ret1="Duplicate values are passed in CRN Parameter which will be allowing unique values by default.";
                break;
            }
            case "424a":
            {
                $ret="Duplicate Request ID Or RID";
                $ret1="RID should be always unique.";
                break;
            }
            case "425":
            {
                $ret="Checksum error";
                $ret1="Unable to decode Checksum requested. Checksum is incorrect.";
                break;
            }
            case "426":
            {
                $ret="Unable to process/decode request.";
                $ret1="Unable to decode Checksum requested. Checksum is incorrect.";
                break;
            }
            case "427":
            {
                $ret="Amount Mismatch / Invalid Amount.";
                $ret1="Amount value in PPI parameter and value in AMT parameter is not same.";
                break;
            }
            case "500":
            {
                $ret="Invalid Request.";
                $ret1="Kindly connect with CMS EasyPay Team.";
                break;
            }
            case "000":
            {
                $ret="Success.";
                $ret1="Payment received successfully.";
                break;
            }
            case "101":
            {
                $ret="In process/Pending.";
                $ret1="In process/Pending.";
                break;
            }
            case "111":
            {
                $ret="Failed.";
                $ret1="Failed.";
                break;
            }
            default:
            {
                $ret=$number;
                $ret1=$number;
                break;
            }
        }
        return $ret;
    }

    public function failedReason($number)
    {
        $ret="";
        $ret1="";
        switch($number){
            case "421":
            {
                $ret="Unauthorised Access";
                $ret1="Public IP and Domain Name need to be whitelisted";
                break;
            }
            case "422":
            {
                $ret="Corp match not found";
                $ret1="Public IP and Domain Name need to be whitelisted";
                break;
            }
            case "423a":
            {
                $ret="Required parameters are missing";
                $ret1="The requested ‘i’ parameter is missing";
                break;
            }
            case "423b":
            {
                $ret="Required parameters are missing";
                $ret1="Please check the request parameters and encryption done";
                break;
            }
            case "424":
            {
                $ret="Duplicate Request or Customer Ref Number already exist";
                $ret1="Duplicate values are passed in CRN Parameter which will be allowing unique values by default.";
                break;
            }
            case "424a":
            {
                $ret="Duplicate Request ID Or RID";
                $ret1="RID should be always unique.";
                break;
            }
            case "425":
            {
                $ret="Checksum error";
                $ret1="Unable to decode Checksum requested. Checksum is incorrect.";
                break;
            }
            case "426":
            {
                $ret="Unable to process/decode request.";
                $ret1="Unable to decode Checksum requested. Checksum is incorrect.";
                break;
            }
            case "427":
            {
                $ret="Amount Mismatch / Invalid Amount.";
                $ret1="Amount value in PPI parameter and value in AMT parameter is not same.";
                break;
            }
            case "500":
            {
                $ret="Invalid Request.";
                $ret1="Kindly connect with CMS EasyPay Team.";
                break;
            }
            case "000":
            {
                $ret="Success.";
                $ret1="Payment received successfully.";
                break;
            }
            case "101":
            {
                $ret="In process/Pending.";
                $ret1="In process/Pending.";
                break;
            }
            case "111":
            {
                $ret="Failed.";
                $ret1="Failed.";
                break;
            }
            default:
            {
                $ret=$number;
                $ret1=$number;
                break;
            }
        }
        return $ret1;
    }

    public function payMode($number)
    {
        $ret1="";
        switch($number){
            case "AIB":
            {
                $ret1="Axis Internet Banking";
                break;
            }
            case "CD":
            {
                $ret1="Credit Card/Debit Card.";
                break;
            }
            case "NR":
            {
                $ret1="NEFT/RTGS.";
                break;
            }
            case "OIB":
            {
                $ret1="Other Internet Banking";
                break;
            }
            default:
            {
                $ret1=$number;
                break;
            }
        }
        return $ret1;
    }

}
