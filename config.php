<?php

return [
    /**
     * 源码路径 后面不带斜杠
     * 
     * 默认是当前目录
     */
    'path' => '.',

    /**
     * 只读取哪些后缀的
     */
    'suffix' => [
        'php'
    ],

    /**
     * 需要排除的目录
     */
    'except' => [
        'tests',
        'vendor'
    ],

    /**
     * 输出文件名称
     */
    'outfile' => 'code.txt'
];
