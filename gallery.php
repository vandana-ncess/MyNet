<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
  <link rel="stylesheet" href="demo/css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="dist/css/glightbox.css">
<link rel="shortcut icon" href="images/logo1.png" type="image/x-icon"/>

  <title>NCESS Gallery</title>
</head>

<body>
  

  <!-- Simple images example -->
  <section id="examples" class="section">
    <div class="wrap">
      <h3><i class="fa fa-camera-retro heading-icon" aria-hidden="true"></i>NCESS Gallery</h3>
      <div class="clear"></div>

      <ul class="box-container three-cols">
           <?php
                        for($i=1;$i<=77;$i++) {
                          echo '<li class="box"><a href="images/Website Gallery/' . $i .'.jpg"  class="glightbox"><img src="images/Website Gallery/'. $i.'.jpg" /></a></li>' ;
                        }
                    ?>
     
      </ul>
    </div>
  </section>


  <script src="dist/js/glightbox.min.js"></script>
  
  <script>
    var lightbox = GLightbox();
    var lightboxDescription = GLightbox({
      selector: 'glightbox2'
    });
    var lightboxVideo = GLightbox({
      selector: 'glightbox3',
      jwplayer: {
        api: 'https://content.jwplatform.com/libraries/QzXs2BlW.js',
        licenseKey: 'imB2/QF0crMqHks7/tAxcTRRjnqA9ZwxWQ2N1A=='
      }
    });
    var lightboxInlineIframe = GLightbox({
      'selector': 'glightbox4'
    });
  </script>
</body>

</html>