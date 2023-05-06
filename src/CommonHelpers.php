<?php

namespace DevTools\Helpers;

use DevTools\Helpers\Exceptions\Exceptions;

class CommonHelpers extends BaseHelpers
{
    /**
     * @param $content
     * @return mixed
     */
    public static function xmlToArray($content = '')
    {
        libxml_disable_entity_loader(true);

        return json_decode(json_encode(simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }


    public static function isXml($content = '')
    {
        $xml_parse = xml_parser_create();
        $res = xml_parse($xml_parse, $content, true);
        xml_parser_free($xml_parse);
        if ($res == 1) {
            return true;
        }

        return false;
    }

    function formatTransformImage($image_path, $to_ext, $save_path)
    {
        list('extension' => $extension) = pathinfo($image_path);
        if ($extension == $to_ext) {
            throw new Exceptions('图片格式相同', -2);
        }
        if ($to_ext == 'jpg') {
            $to_ext = 'jpeg';
        }
        if (!in_array($to_ext, ['jpeg', 'png', 'gif'])) {
            throw new Exceptions('图片不支持转换格式到' . $to_ext, -1);
        }
        switch (exif_imagetype($image_path)) {
            case    IMAGETYPE_JPEG:
            case IMAGETYPE_JPEG2000:
                $img = imagecreatefromjpeg($image_path);
                break;
            case IMAGETYPE_PNG:
                $img = imagecreatefrompng($image_path);
                break;
            case IMAGETYPE_GIF:
                $img = imagecreatefromgif($image_path);
                break;
            default :
                throw new Exceptions('Invalid image type', -3);
        }
        $function = 'image' . $to_ext;
        return $function($img, $save_path);
    }

    /** 通过版本号排序
     * @param $versions
     * @param $sort_rule
     * @return mixed
     */
    public static function sortVersion($versions, $sort_rule = true)
    {
        foreach ($versions as $key => $value) {
            $firstArr = explode('.', $value);
            $firstArrCount = count($firstArr);
            for ($i = 0; $i < $firstArrCount; $i++) {
                $firstArr[$i] = str_pad($firstArr[$i], 2, 0, STR_PAD_LEFT);
            }
            $versions[$key] = implode('.', $firstArr);
        }
        if ($sort_rule) {
            sort($versions);
        } else {
            rsort($versions);
        }
        foreach ($versions as $key => $value) {
            $firstArr = explode('.', $value);
            $firstArrCount = count($firstArr);
            for ($i = 0; $i < $firstArrCount; $i++) {
                $firstArr[$i] = intval($firstArr[$i]);
            }
            $versions[$key] = implode('.', $firstArr);
        }
        return $versions;
    }



}