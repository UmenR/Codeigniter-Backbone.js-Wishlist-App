<link rel="stylesheet" type="text/css" href="<?php echo(base_url());?>css/share.css">
<script src="<?php echo(base_url());?>js/Collections/test.js" type="text/javascript"></script>
  <?php 
  if($userdata->listtitle == NULL  || $userdata->listdescription == NULL){
    echo('<h2 class="text-primary" style="text-align:center">Oh no '.$userdata->username.'  has not created a list yet!!!</h2>');
  } else {
    echo('
    <div class="card text-white bg-primary mb-3" style="margin-top:0px; width: 100%;border-radius: 0 !important;">
      <div class="card-header">
      <h1 style="text-align: center">'.$userdata->username.'\'s Wish List</h1>
      </div>
        <div class="card-body">
        <h3>'.$userdata->listtitle.'</h3>
        <h6>'.$userdata->listdescription.'</h6>
      </div>
    </div> 
    ');
    if(sizeof($items)>0){
        echo(
            '<ul id="wishList">'
        );
        foreach($items as $item){
          echo(
            '<li>'.
            '<div class="card text-white bg-success mb-3" style="width: 400px;">'.
            '<div class="card-header" style="text-align:center">'.$item->title.'</div>'.
            '<div class="card-body">'.
              '<h6 class="card-title">'.checkPriority($item->priority).'</h6>'.
              '<h6 class="card-title"> $'.$item->price.'</h6>'.
              '<h6 class="card-title">'.$item->url.'</h6>'.
            '</div>'.
          '</div>'.
          '</li>'
          );
        }
        echo(
          '</ul>'
        );
    } else {
        echo(
            '<h3 style="text-align:center">No items in this users wish list</h3>'
        );
    }
  }

  function checkPriority($priority){
    switch($priority){
    case 1: return 'Must Have';
    break;
    case 2: return 'Nice to Have';
    break;
    case 3: return 'If possible';
    break;
    }
  }
  ?>
</body>
</html>