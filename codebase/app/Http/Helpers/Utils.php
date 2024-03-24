<?php

namespace App\Http\Services;

class Utils{
    static public function preparePhoneNumber($phoneNumber){
        $phoneNumber = str_replace(" ", "", $phoneNumber);
        $phoneNumber = str_replace("(", "", $phoneNumber);
        $phoneNumber = str_replace(")", "", $phoneNumber);
        $phoneNumber = str_replace("-", "", $phoneNumber);

        if(!str_starts_with($phoneNumber, "+55")){
            $phoneNumber = "+55" . $phoneNumber;
        }

        return $phoneNumber;
    }

    static public function prepareDocumentNumber($documentNumber){
        $documentNumber = str_replace(".", "", $documentNumber);
        $documentNumber = str_replace("/", "", $documentNumber);
        $documentNumber = str_replace("-", "", $documentNumber);

        return $documentNumber;
    }

    static public function preparePostalCode($postalCode){
        $postalCode = str_replace(".", "", $postalCode);
        $postalCode = str_replace("/", "", $postalCode);
        $postalCode = str_replace("-", "", $postalCode);

        return $postalCode;
    }

    static public function prepareNumberValue($value){
        $value = str_replace(".", "", $value);
        return str_replace(",", ".", $value);
    }
}