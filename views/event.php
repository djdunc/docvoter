[EVENT]

EDIT OR CREATE IF NO EVENT IS SET

<?php //var_dump($collections);?>

<script type="text/javascript">
$.ajax("includes/callAPI?action=event/get&id=3&include_card_count=1", {
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