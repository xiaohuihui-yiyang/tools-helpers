<?php

namespace DevTools\Helpers;

class ArrayHelpers extends BaseHelpers
{
    /**
     * @param $array
     * @return array|string[]
     */
    public static function Trim($array = [])
    {
        return array_map(function ($val) {
            return trim($val);
        }, $array);
    }

    /**
     * @param array $array
     * @param $column_key
     * @param int $mark 用于遍历数组时重置保存在内存中的静态变量
     * @return array
     */
    public static function Columns($array = [], $column_key, $mark = 1)
    {
        static $newArray = [];
        if ($mark == 1) {
            $newArray = [];
        }
        foreach ($array as $key => $row) {
            if ($key == $column_key && $array[$column_key] && !in_array($array[$column_key], $newArray)) {
                $newArray[] = $row;
            } elseif (is_array($row)) {
                $value = self::Columns($row, $column_key, 2);
            } else {
                continue;
            }
        }
        return $newArray;
    }

    /**
     * @param $params array
     * @return string|void
     */
    public static function ToXml($params)
    {
        if (!is_array($params) || count($params) == 0) {
            return;
        }
        $xml = '<xml>';
        foreach ($params as $k => $param) {
            if (is_array($param)) {
                $xml .= '<' . $k . '>' . self::ToXml($param) . '</' . $k . '>';
            } else {
                $xml .= '<' . $k . '>' . $param . '</' . $k . '>';
            }
        }
        $xml .= '</xml>';
        return $xml;
    }


    public static function BuildTree($array = [], $parent_id = 0)
    {
        $tree = array();
        foreach ($array as $item) {
            if ($item['parent_id'] == $parent_id) {
                $children = self::BuildTree($array, $item['id']);
                if ($children) {
                    $item['children'] = $children;
                }
                $tree[] = $item;
            }
        }
        return $tree;
    }

    public static function TreeBuild($array = [])
    {
        static $list = [];
        foreach ($array as $item) {
            if ($item['children']) {
                self::BuildTree($item['children']);
            } else {
                $list[] = $item;
            }
        }
        return $list;
    }


}