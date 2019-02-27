<?php


namespace Devonray\AzureTranslate;

use Ixudra\Curl\Facades\Curl;

class AzureTranslate 
{
    /**
     * List of languages to translate, 
     * 
     * @var Array
     */
    private $available_languages;

    
    /**
     * Asure url to use
     * 
     * @var String
     */
    private $azure_url = 'https://api.cognitive.microsofttranslator.com';


    /**
     * Asure endpoint and api version for the translation
     * 
     * @var String
     */
    private $azure_path = "/translate?api-version=3.0";


    /**
     * Azure api key
     * 
     * @var String
     */

    private $azure_key; 



    public function __construct()
    {

        $this->available_languages = ($langs = config('language.available')) ? $langs : []; // Set the available languages

        $this->azure_key  = config('language.azure_key'); // Set the azure key

    }

    /**
     * Translate a string from english to the apps available languages
     * 
     * @param String $string the strin that needs translating
     */
    public function translate(String $string, String $from = 'en'){

        $content = json_encode([['Text' => $string]]); // Set the content

        $from = (array_key_exists($from, $this->available_languages)) ? $from : 'en';

        unset($this->available_languages['us'], $this->available_languages[$from]); // Unset us because that's for frontent use only, and unset the from language

        $params = "&from={$from}&to=". implode("&to=",array_keys($this->available_languages) ); // Create params array

        // Build up the response with all the headers
        $response =  Curl::to($this->azure_url . $this->azure_path . $params)
            ->withHeader("Content-type: application/json")
            ->withHeader('Ocp-Apim-Subscription-Key: '. $this->azure_key)
            ->withHeader("Content-length: ". strlen($content))
            ->withHeader("X-ClientTraceId: " . $this->com_create_guid())
            ->withData($content)
            ->post();          


        $translations_array = (array)json_decode($response)[0]->translations; // Decode the response and create a translations array

        $translations_array[] = ['to' => $from, 'text' => $string]; // Add the from string to the array
                
        return array_column($translations_array, 'text', 'to'); // return array with the translations

    }


    /**
     * Create the guid for the api call
     * 
     * @return String 
     */
    private function com_create_guid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}
