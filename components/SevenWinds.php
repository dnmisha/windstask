<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 27.10.17
 * Time: 10:47
 */

namespace Mvc\Components;


class SevenWinds
{
    /**
     * @param $string
     * @return array
     */
    public function parseTags($string)
    {
        $matches = [];
        $result = ['description' => [], 'data' => []];
        $pattern = "#\[([\w]+):?([\w\s]*)?\](.+?)(\[/([\w]+)\]|\[)#ius";
        preg_match_all($pattern, $string, $matches);
        if (count($matches[5])) {
            foreach ($matches[5] as $key => $value) {
                if ($value == $matches[1][$key]) {
                    $result['data'][$value] = $matches[3][$key];
                    if ($matches[2][$key]) {
                        $result['description'][$value] = $matches[2][$key];
                    }
                }
            }
        }
        return $result;
    }

    /**
     * @param array $rawData
     * @return array
     */
    public function renderArrayCombination(array $rawData)
    {
        $counter = 0;
        $rowIndex = $result = [];
        foreach ($rawData as $key => $val) {
            $rowIndex[$key] = 0;
        }
        $skipNext = false;
        while (!$skipNext) {
            foreach ($rawData as $key => $value) {
                $rowCount = count($rawData[$key]);
                if ($skipNext) {
                    $rowIndex[$key]++;
                    $skipNext = false;
                }
                if ($rowIndex[$key] >= $rowCount) {
                    $rowIndex[$key] = 0;
                    $skipNext = true;
                }
                $result[$counter][$key] = $rawData[$key][$rowIndex[$key]];
            }
            $rowIndex[0]++;
            $counter++;
        }
        array_pop($result);
        return $result;
    }

    /**
     * @param $string
     * @return array
     */
    public function arrayCombinationGenerate($string)
    {
        $rawData = preg_split("/\\r\\n|\\r|\\n/", $string);
        array_walk($rawData, function (&$row) {
            $row = explode(',', $row);
            array_map('trim', $row);
        });
        return $rawData;
    }

    /**
     * @param array $treeArray
     * @param int $level
     * @return string
     */
    public static function renderTree($treeArray = [], $level = 1)
    {
        $out = '';
        foreach ($treeArray as $tree) {
            $out .= ($tree->parent > 0) ? str_repeat('&nbsp;&nbsp;', $level) . '->' . $tree->name . "<br>" : $tree->name . "<br>";
            if (count($tree->children)) {
                $out .= self::renderTree($tree->children, $level+1);
            }
        }
        return $out;
    }

}