<?php
$a=[
    ['name'=>"xiao",'parent_id'=>0,'id'=>1],
    ['name'=>"xiao1",'parent_id'=>1,'id'=>2],
    ['name'=>"xiao2",'parent_id'=>2,'id'=>3],
    ['name'=>"xiao3",'parent_id'=>1,'id'=>4],
    ['name'=>"xiao4",'parent_id'=>3,'id'=>5],
    ['name'=>"xiao5",'parent_id'=>3,'id'=>6],
];
$tree = \DevTools\Helpers\ArrayHelpers::BuildTree($a);
var_dump($tree);die;
