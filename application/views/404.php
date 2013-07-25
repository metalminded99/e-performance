<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Oops! Page not found</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>bootstrap/bootstrap-responsive.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>theme.css">
    <link rel="stylesheet" href="<?=base_url().CSS?>font-awesome/font-awesome.css">

    <script src="<?=base_url().JS?>jquery-1.8.3.min.js" type="text/javascript"></script>

    <!-- Demo page code -->
    
    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7"> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8"> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9"> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body> 
  <!--<![endif]-->
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="http-error">
                    <h1>Oops!</h1>
                    <p class="info">This page doesn't exist.</p>
                    <p><i class="icon-home"></i></p>
                    <p><a href="<?=$this->agent->is_referral() ? $this->agent->referrer() : $this->base_url()?>">Back to the home page</a></p>
                </div>
            </div>
        </div>
        <script src="<?=base_url().JS?>bootstrap.js"></script>
    </body>
</html>


