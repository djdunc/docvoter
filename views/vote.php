<?php //var_dump($collection);?>
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_3">
    		       <ul id="category-nav">
    		           <li id="top50" class="active">top 50</li>
                       <?php foreach($collection['categories'] as $cat_id=>$category){
                           echo "<li id='$category'>$category</li>";
                       } ?>
    		       </ul>
    		</div>
    		<div class="grid_1 align_right">
    				<a href="index.php?do=driver" class="button blue large">+ add driver</a>
    		</div>
	    </div>
    </div>
</div>
<div class="container_4">
	    <div class="grid-wrap" class="clearfix">
    		<div class="grid_4">
    		    <div class="panel">
    		       <ul id="vote-cloud">
    		           <?php
    		           function shuffle_assoc($list) { 
                         if (!is_array($list)) return $list; 

                         $keys = array_keys($list); 
                         shuffle($keys); 
                         $random = array(); 
                         foreach ($keys as $key) { 
                           $random[] = $list[$key]; 
                         }
                         return $random; 
                       }
    		           ?>
    		           <?php
                          $cards= shuffle_assoc($data['event_cards']); foreach ($cards as $card) { //var_dump($card);
                          	$top = in_array($card->id,$top50)?"top50":"";
                            ?>
                           <li class='<?php echo $collection['categories'][$card->category_tag_id]." ".$top;?>'><a href="" id="<?php echo $card->id;?>"<?php echo 'class="card '.$top." ".$collection['categories'][$card->category_tag_id].'-b'.'"'; ?>><?php echo($card->name);?></a></li>
                      <?php }?>
    		       </ul>
    		     </div>
    		</div>
	    </div>
</div>
<br /><br />
<!-- Load the tiptip script -->
<script src="assets/js/tipTipv13/jquery.tipTip.minified.js" type="text/javascript"></script>
<!--	Load the tiptip stylesheet. -->
<link rel="stylesheet" href="assets/js/tipTipv13/tipTip.css" type="text/css" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
	var event_id=<?php echo $event->id;?>;
	var owner=<?php echo $_SESSION['user']->id;?>;
	$('#category-nav li').click(function(){
        if($(this).hasClass('active')) {
            $('#category-nav li').removeClass('active');
            $('#vote-cloud li').show();
        } else {
            $('#category-nav li').removeClass('active');
            $(this).addClass('active');
            $('#vote-cloud li').hide();   
            var class_to_show = $(this).attr('id');
            $('#vote-cloud li.'+class_to_show).show();
        }
    });
    $(".card").tipTip({defaultPosition:"right",maxWidth:"auto",content:"click to vote",delay:800});
    $(".card").click(function(){
        //voting stuff
        if(!$(this).hasClass('voted')) {
        	//vote
        	var query_url = "includes/callAPI.php?action=vote/post&event_id="+event_id+"&owner="+owner+"&card_id="+$(this).attr('id');
            $(this).addClass('voted');
            $.ajax({
	            url: query_url,
	            success: function(data){/*uhm ... it worked*/},
	            error: function(data){/*... it didn't*/}
	        });
        } else {
            //unvote
            var query_url = "includes/callAPI.php?action=vote/delete&event_id="+event_id+"&owner="+owner+"&card_id="+$(this).attr('id');
        	$(this).removeClass('voted');
        	$.ajax({
                url: query_url,
                success: function(data){/*uhm ... it worked*/},
                error: function(data){/*... it didn't*/}
            });
        }
    });
});
</script>