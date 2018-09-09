<?php

    namespace thumb\waterMark;

    class gdDemoWatermark
    {
        /** 
         * @Author: min.xu 
         * @Date: 2018-09-07 17:50:01 
         * @param:$markImage   水印图片路径
         * @param:$oriImage      原图路径  
         * @param:$waterWidth    水印图的宽
         * @param:$waterHeight   水印图的高
         * @param:$watercontent  水印文字
         * @param:$waterX  水印位置x
         * @param:$waterY  水印位置y
         * @param:$fontX  水印字体位置x
         * @param:$fontY  水印字体位置y
         * @param:$fontSize  水印字体大小
         */        
        public function waterMark($markImage,$oriImage,$waterWidth,$waterHeight,$watercontent,$waterX,$waterY,$fontX,$fontY,$fontSize)
        {
            // 图片水印
            $mark_filename = $markImage;   
            $info = getimagesize($mark_filename);

            // 获取图片的后缀
            $type = image_type_to_extension($info[2],false);
            // 拼接图片资源句柄函数
            $func = 'imagecreatefrom'.$type;
            // 创建图片资源句柄
            $image = $func($mark_filename);

            // 裁剪图片的大小为原图的1/4
            $w = $waterWidth;
            $h = $waterHeight;
            $mark_image = imagecreatetruecolor($w,$h);

            // 裁剪
            imagecopyresampled($mark_image,$image,0,0,0,0,$w,$h,$info[0],$info[1]);
            // 销毁内存
            imagedestroy($image);


            // 需要添加水印的图片
            $filename = $oriImage;
            $mark = getimagesize($filename);

            // 获取图片后缀
            $mark_type = image_type_to_extension($mark[2],false);
            $mark_func = 'imagecreatefrom'.$mark_type;
            $image = $mark_func($filename);

            // 合并,添加水印图片
            imagecopymerge($image,$mark_image,$waterX,$waterY,0,0,$w,$h,30);
            
            imagedestroy($mark_image);

            // 文字水印
            $font = 'PingFang.ttc';
            $content = $watercontent;
            $col = imagecolorallocatealpha($image,45,56,123,50);  # 为一幅图像分配颜色和透明度
            imagettftext($image,$fontSize,30,$fontX,$fontY,$col,$font,$content);    #字体大小 , 0 度为从左向右读的文本。更高数值表示逆时针旋转。例如 90 度表示从下向上读的文本,由 x，y 所表示的坐标定义了第一个字符的基本点

            // 输出函数
            $outFunc = 'image'.$type;

            // 保存图片
            $outFunc($image,'neww.'.$type);
            // 输出到浏览器
            header("Content-Type:".$info['mime']);
            $outFunc($image);
    }
    
}


