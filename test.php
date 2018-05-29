<!DOCTYPE html>
<html>
<head>
    <title>Demo 1: Menucool jQuery Slider</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="1/thumbs2.css" rel="stylesheet" />
    <link href="1/thumbnail-slider.css" rel="stylesheet" type="text/css" />
    <script src="1/thumbnail-slider.js" type="text/javascript"></script>
    <style>
        body {font: normal 0.9em Arial;color: #222;}
        header {display:block; font-size:1.2em; margin-bottom:100px;}
        header a, header span {
            display: inline-block;
            padding: 4px 8px;
            margin-right: 10px;
            border: 2px solid #000;
            background: #DDD;
            color: #000;
            text-decoration: none;
            text-align: center;
            height: 20px;
        }
        header span {background:white;}
        a {color: #1155CC;}
    </style>
</head>
<body>
    <!--start-->
    <div style="max-width:900px;margin:0 auto;padding:100px 0;">

      <!--  <div style="float:left;padding-top:98px;">
            <div id="thumbnail-slider">-->
                <div class="inner">
                    <ul>
                        <?php
            for($i=1;$i<=77;$i++) {
            echo ' <li>
                <a class="thumb" href="images/Website Gallery/'.$i.'.jpg" /></a></li>
            ';}
            ?>
                   
                    </ul>
                </div>
          <!--  </div>
        </div>

       -->

        <div style="clear:both;"></div>

    </div>
    <!--end-->
   
</body>
</html>
