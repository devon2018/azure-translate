<?php

return [

  /**
   * List of translatable languages
   * these should be all thje ones you wan't your app to support
   * 
   * @var Array
   */
  'available' => [
    'en' => 'English UK',
    'us' => 'English US',
    'cs' => 'Czech',
    'da' => 'Danish',
    'nl' => 'Dutch',
    'fr' => 'French',
    'de' => 'German',
    'hu' => 'Hungarian',
    'it' => 'Italian',
    'pl' => 'Polish',
    'sk' => 'Slovac',
    'es' => 'Spanish',
    'sv' => 'Swedish',
    'pt' => 'Portugese'
  ],

  /**
   * Your azure api key
   * 
   * @see https://docs.microsoft.com/en-us/azure/cognitive-services/translator/translator-text-how-to-signup
   * @var String 
   */
  'azure_key' => env('AZURE_KEY',''),

  /**
   * The driver to use for the local storage
   * this is used to access the language directory
   * and write to files
   * 
   * @var String
   */
  'local_storage' => 'local_r'
];