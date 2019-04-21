<?php


namespace App\handle;


class handle
{
    public function save2text($context)
    {
        $floder_name = public_path(). '/uploads/'. date('Ym/d', time());
        $file_name = time() . str_random(6) . '.php';
        $full_name = $floder_name. '/' .$file_name;
        if (!file_exists($floder_name)) {
            mkdir($floder_name, 0777, true);
        }
        $handle = @fopen($full_name, 'w+');
        file_put_contents($full_name, serialize($context));
        fclose($handle);
        return $full_name;
    }

    public function get2array($file)
    {
        $handle = @fopen($file, 'r');
        $data = unserialize(file_get_contents($file));
        fclose($handle);
        return $data;
    }
}
