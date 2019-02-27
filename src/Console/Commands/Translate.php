<?php

namespace Devonray\AzureTranslate\Console\Commands;

use Illuminate\Console\Command;
use Devonray\AzureTranslate\AzureTranslate;

class Translate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation:create {key} {string}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new translation from a string';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $translator = new AzureTranslate(); // new up the translation class

        $string = $this->argument('string'); // set the string

        $translations = $translator->translate($string); // translate the string

        $key = explode('.', $this->argument('key')); // create the right path

        // check if the translation should go in the main file
        if(count($key) > 1){
            $file = $key[0];
            unset($key[0]);
        }else{
            $file = 'main';
        }

        // Check the available languages in the config
        $available_languages = config('language.available');

        // Create the files and folders for the translation
        $this->createFilesAndFolders($available_languages, $file);

        $lang_k = implode('_',$key);

        // loop over the translations returned 
        foreach ($translations as $key => $value) {
            $lang_line_v = htmlspecialchars($value); // encode the line
            $this->addLineToLanguageFile($key.'/'.$file, "
    '{$lang_k}' => \"{$lang_line_v}\", // {$string}".PHP_EOL);
        }

    }

    /**
     * Create the files and folders if any are missing for the current translation
     * 
     * @param Array $available_languages the available languages in the config file
     * @param String $file the file to create.
     */
    private function createFilesAndFolders(Array $available_languages, String $file = 'main'){
        // Loop and create
        foreach ($available_languages as $key => $value) {
            if (!file_exists(base_path().'/resources/lang/'.$key. '/')) {
                mkdir(base_path().'/resources/lang/'. $key , 0766);
            }   
            // indentation is anoying but it stops the page from breakings
            if(!file_exists(base_path().'/resources/lang/'.$key. '/'.$file.'.php')){
                $base = '<?php

return [

];              
                ';

                $w = \Storage::disk('local_r')->put('resources/lang/'.$key. '/'.$file.'.php', $base);
            }
        }
    }

    /**
     * Add the language line to an existing file
     * 
     * @param String $file the name of the file to write
     * @param String $line the line to write
     */
    private function addLineToLanguageFile(String $file, String $line){
        
        $langFile = file(base_path().'/resources/lang/'.$file.'.php'); // find the file

        $fl_array = preg_grep("/];/", $langFile); // find the last line of the file

        // find the line to insert the translation
        $end = key( array_slice( $fl_array, -1, 1, TRUE ) ); 
        array_splice( $langFile, $end, 0, $line ); 

        return file_put_contents(base_path().'/resources/lang/'.$file.'.php',  $langFile); // write the contents
    }
}
