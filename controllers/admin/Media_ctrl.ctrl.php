<?php
class Media_ctrl
{
    public function gallery()
    {
        $dir = MEDIA_ROOT . "images/pages";
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $pattern = $dir . '/*.{' . implode(',', $imageExtensions) . '}';
        $imageList = glob($pattern, GLOB_BRACE);
        $arrimg = array();
        foreach ($imageList as $imgv) {
            $img = explode("/", $imgv);
            $arrimg[] = end($img);
        }
        $this->generate_json_file($data = $arrimg);
        return $arrimg;
    }

    public function generate_json_file($data)
    {
        // Encode the data as JSON
        $json = json_encode($data);

        // Define the filename and path for the JSON file
        $filename = 'gallery.json';
        $path = RPATH . '/data/json/media/images/pages/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        // Write the JSON data to the file
        file_put_contents($path . $filename, $json);
    }
}
