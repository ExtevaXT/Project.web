<?php
$pieces_count = 2550; //Число файлов-тайлов
$pieces_count_on_row = 50; //Число файлов-тайлов, уложившихся в длину изображения, округленное в большую сторону.
for($i=0; $i <= $pieces_count; $i++){
    $filename = (int)($i / $pieces_count_on_row);
    $filename .= 'x' . $i % $pieces_count_on_row;
    rename("{$i}.jpg","{$filename}.jpg");
}
?>
