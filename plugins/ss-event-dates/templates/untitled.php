
<table class="table table-striped">
<thead>
  <tr style="font-weight: bold;">
    <th>Name</th>
    <th>Details</th>
    <th>Price</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td>Membership</td>
    <td>
<?php 
if(isset($user_detail['euser_meta_type'])){

}
?>


    </td>
    <td>Canada</td>
  </tr>

  </tbody>
</table>





<?php
$arr = array(1, 2, 3, 4);
foreach ($arr as &$value) {
    $value = $value * 2;
}
?>