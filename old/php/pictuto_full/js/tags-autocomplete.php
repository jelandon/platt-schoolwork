<?php 
//needed full path, not sure why... probably because we are in a different directory
require_once('C:/xampp/htdocs/trish/PHP/pictuto_full/includes/db-connect.php'); 

 ?>
<script type="text/javascript">
$(function(){
  var tags = [
  <?php  
  $query = "SELECT * FROM tags";
  $result = $db->query($query);
  if($result->num_rows> 0){
    while ($row = $result->fetch_assoc()) {  
    //this gets all the current tags from the db and puts them into a JSON object.  
  ?>
    { value: '<?php echo $row['tag_name'] ?>', id: <?php echo $row['tag_id'] ?> },
<?php  
    //
    }//end while

    } //end if
?>

  ];
  
  // setup autocomplete function pulling from currencies[] array
  $('#autocomplete').autocomplete({
    lookup: tags,
    onSelect: function (suggestion) {
      // var thehtml = '<strong>Tag Name:</strong> ' + suggestion.value + ' <br> <strong>Symbol:</strong> ' + suggestion.id;
      console.log(suggestion.value);
      var theId = suggestion.id || '0';
      $('#new_tag_id').val('').val(theId);

    },
    onBlur: function(suggestion){
     var theId = suggestion.id || '0';
      $('#new_tag_id').val('').val(theId);
      console.log(suggestion.value);        
    }
    //see what you can find out about this argument

  });
  

});

</script>