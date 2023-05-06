<?php
//$a=[
//    ['name'=>"xiao",'parent_id'=>0,'id'=>1],
//    ['name'=>"xiao1",'parent_id'=>1,'id'=>2],
//    ['name'=>"xiao2",'parent_id'=>2,'id'=>3],
//    ['name'=>"xiao3",'parent_id'=>1,'id'=>4],
//    ['name'=>"xiao4",'parent_id'=>3,'id'=>5],
//    ['name'=>"xiao5",'parent_id'=>3,'id'=>6],
//];
//$tree = \DevTools\Helpers\ArrayHelpers::BuildTree($a);
//var_dump($tree);die;

$tree = [
    ['id' => 1, 'name' => 'A', 'children' => [
        ['id' => 2, 'name' => 'B', 'children' => [
            ['id' => 3, 'name' => 'C'],
            ['id' => 4, 'name' => 'D']
        ]],
        ['id' => 5, 'name' => 'E']
    ]],
    ['id' => 6, 'name' => 'F']
];
$result = \DevTools\Helpers\ArrayHelpers::FlattenTree($tree);
var_dump($result);