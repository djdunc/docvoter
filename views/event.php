[EVENT]

EDIT OR CREATE IF NO EVENT IS SET

<?php //var_dump($collections);?>

<?php

$params = "event/get";
if(!is('super')) $params.="&owner=".$_SESSION['user']->id;

?>

<script type="text/javascript">
$.ajax("includes/callAPI?action=<?php echo $params; ?>", {
    success: function(data){
        try {
            var data = $.parseJSON(data);
            //
            // DO STUFF HERE. DATA CONTAINS THE OBJECT REQUESTED
            //
        } catch (err) {
            //
            // ERROR. data SHOULD CONTAIN DESCRIPTION OF WHAT WENT WRONG
            //
            // displayAlertMessage(data);
        }
    },
    error: function(data){ console.log(data); }
});
</script>