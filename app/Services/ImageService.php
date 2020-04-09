<?php


namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ImageService
{
    /**
     * @var string
     */
    private $storage_subfolder = 'app/';
    /**
     * @var string
     */
    private $filename = 'image.';
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $file;
    /**
     * @var array
     */
    protected $props = [
        'min' => ['z'],
        'max' => ['z'],
        'mean' => ['r', 'g', 'b', 'z'],
        //'standard deviation',
        'kurtosis' => ['z'],
        'skewness' => ['z'],
        'entropy' => ['z']
    ];
    /**
     * @var string
     */
    private $full_image_info;

    /**
     * ImageService constructor.
     */
    public function __construct()
    {
        $this->path = storage_path($this->storage_subfolder);
    }

    /**
     * @param Request $request
     */
    public function fetchImage()
    {

        preg_match('/(.[a-z]+$)/', app('request')->post('url'), $extension);
        $this->file = app('request')->post('id') . $extension[1];
        $path = $this->path . $this->file;

        print($path);

        $client = new Client();
        $response = $client->get($request->post('url'))
            ->setResponseBody($request->post('id'));
            ->send();
        print_r($client);
        //store the file...

    }

    /**
     * @param Request $request
     * @return string
     * @throws \Exception
     */
    public function storeImage(Request $request)
    {
        if (
            $request->hasFile('image')
            && $request->file('image')->isValid()
        ) {
            $this->file = $this->filename . $request->file('image')->guessExtension();
            $request->file('image')->move($this->path, $this->file);
            return $this;
        }
        throw new \Exception('Valid image file not found in request');
    }

    /**
     * @param int $div
     * @return $this
     */
    public function tileImage($div = 5) {
        //tile the image into $div * $div
        return $this;
    }

    /**
     * @param bool $return_data
     * @return ImageService|string|null
     */
    public function imageInfo(bool $return_data = false) {
        $this->full_image_info = $this->execute(
            'magick
            identify -verbose
            ' . $this->path . $this->file
        );
        return ($return_data) ? $this->full_image_info : $this;
    }

    /**
     * @param string|null $full_image_info
     * @return array
     * @throws \Exception
     */
    public function extractProperties(string $full_image_info = null)
    {
        $full_image_info = ($full_image_info) ? $full_image_info : $this->full_image_info;
        $value = [];
        $keys = ['r', 'g', 'b', 'z'];
        foreach ($this->props as $prop => $prop_keys) {
            $pattern = '/' . $prop . ': ([0-9.-]+)/';
            preg_match_all($pattern, $full_image_info, $matches);
            if (is_array($matches[1])) {
                foreach ($matches[1] as $k => $v) {
                    if (in_array($keys[$k], $prop_keys)) {
                        $value[$prop][$keys[$k]] = $v;
                    }
                }
            } else {
                throw new \Exception('Image info missing - ' . $prop);
            }
        }
        return $value;
    }

    /**
     * @param null $image_path
     */
    public function removeImage(string $image_path = null)
    {
        $image_path = ($image_path) ? $image_path : $this->path . $this->file;
        if (is_file($image_path)) {
            unlink($image_path);
        }
    }

    /**
     * @param string $command
     * @return string|null
     */
    protected function execute(string $command)
    {
        //remove newlines and convert single quotes to double to prevent errors
        $command = str_replace(array("\n", "'"), array('', '"'), $command);
        //replace multiple spaces with one
        $command = preg_replace('#(\s){2,}#is', ' ', $command);
        //escape shell metacharacters
        //$command = escapeshellcmd($command);
        //execute command
        return shell_exec($command);
    }


}
