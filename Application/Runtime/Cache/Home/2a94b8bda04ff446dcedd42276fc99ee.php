<?php if (!defined('THINK_PATH')) exit(); $config = D("Basic")->select(); $barMenus = D("Menu")->getBarMenus(); ?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  
  <!-- 网站配置信息的填充 -->
  <title><?php echo ($config["title"]); ?></title>
  <meta name="keywords" content="<?php echo ($config["keywords"]); ?>">
  <meta name="description" content="<?php echo ($config["description"]); ?>">
  
  <link rel="stylesheet" href="/Public/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="/Public/css/home/main.css" type="text/css" />
</head>
<body>
<header id="header">
  <div class="navbar-inverse">
    <div class="container">
      <div class="navbar-header">
        <a href="/">
          <img src="/Public/images/logo.png" alt="">
        </a>
      </div>
      <ul class="nav navbar-nav navbar-left">
        <li><a href="/" <?php if($result['catId'] == 0): ?>class="curr"<?php endif; ?>>首页</a></li>
		
		<?php if(is_array($barMenus)): foreach($barMenus as $key=>$barMenu): ?><li><a href="/index.php?c=cat&id=<?php echo ($barMenu["menu_id"]); ?>" <?php if($barMenu['menu_id'] == $result['catId']): ?>class="curr"<?php endif; ?>><?php echo ($barMenu["name"]); ?></a></li><?php endforeach; endif; ?>
      
      </ul>
    </div>
  </div>
</header>

<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-9">
        <div class="banner">
          <div class="banner-left">
          
          <!-- 首页大图数据 -->  
            <a target="_blank" href="/index.php?c=detail&id=<?php echo ($result['topNews'][0]['news_id']); ?>">
            	<img width="670" height="360" src="<?php echo ($result['topNews'][0]['thumb']); ?>" alt="">
            </a>
          
          </div>
          <div class="banner-right">
            <ul>
            
              <?php if(is_array($result['topSmallNews'])): $i = 0; $__LIST__ = $result['topSmallNews'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                <a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>">
                	<img width="150" height="113" src="<?php echo ($vo["thumb"]); ?>" alt="<?php echo ($vo["title"]); ?>">
                </a>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
            
            </ul>
          </div>
        </div>
        <div class="news-list">
        
          <?php if(is_array($result['listNews'])): $i = 0; $__LIST__ = $result['listNews'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl>
            <dt><a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><?php echo ($vo["title"]); ?></a></dt>
            
            <dd class="news-img">
              <a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><img width="200" height="120" src="<?php echo ($vo["thumb"]); ?>" alt="<?php echo ($vo["title"]); ?>"></a>
            </dd>
            
            <dd class="news-intro">
              <?php echo ($vo["description"]); ?>
            </dd>
            
            <dd class="news-info">
              <?php echo ($vo["keywords"]); ?> <span><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></span> 阅读(<i news-id="<?php echo ($vo["news_id"]); ?>" class="news_count node-<?php echo ($vo["news_id"]); ?>"><?php echo ($vo["count"]); ?></i>)
            </dd>
          
          </dl><?php endforeach; endif; else: echo "" ;endif; ?>

      </div>
	</div>
	
            <div class="col-sm-3 col-md-3">
        <div class="right-title">
          <h3>文章排行</h3>
          <span>TOP ARTICLES</span>
        </div>
        
        <div class="right-content">
          <ul>

	            <?php if(is_array($result['topCount'])): $k = 0; $__LIST__ = $result['topCount'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="num<?php echo ($k); ?> curr">
	        		<a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><?php echo ($vo["title"]); ?></a>
	        	
	        	<!--数组中是0 但是索引出来是1  -->
	        	<?php if($k == 1): ?><div class="intro"><?php echo ($vo["description"]); ?></div><?php endif; ?>
	      		</li><?php endforeach; endif; else: echo "" ;endif; ?>
          
          </ul>
        </div>
        
       <!--  <div class="right-hot">
          <img src="/Public/images/img5.jpg" alt="">
        </div>
        <div class="right-hot">
          <img src="/Public/images/img6.jpg" alt="">
        </div> -->
      </div>

    </div>
  </div>
</section>
</body>
</html>