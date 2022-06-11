<?php
error_reporting(1);
if(isset($_POST['submit'])){

    controller('Car');
    $car = new Car();
    $photo = $car->getFile('photo');
    $edit = $car->edit('b9244592bfd55c88ad90b0ad6e9b13c4', 'photo', '34455', 'available');

    echo json_encode($edit);

    

}
?>
<form method="post" enctype="multipart/form-data">
    
<input type="file" name="photo" id="photo" class="form-control">
    <button type="submit" name="submit">Submit</button>
</form>

