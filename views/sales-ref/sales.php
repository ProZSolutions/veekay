<html>
<head>
<style type="text/css">
<!--
#

.style3 {
    font-size: 15px;
    font-weight: bold;
    font-family: "Times New Roman";
}
.style2 {
    font-size: 13px;
    font-weight: bold;
    font-family: serif;
}
.style9 {font-size: 13px; }
.style10 {font-size: 17px; font-weight: bold;}

-->
</style>
</head>
<body>

<table style="width: 100%;">
    <tbody>
    <tr>
    <td>
    
  <p align="left"><span class="style3">Europasonic (UK) Ltd </span><BR>
  <span >11 Sherbourne Street, Manchester M3 1JS </span><BR>
  <span class="style3">Tel :</span><span>0161 831 7819</span><br>
  <span class="style3">Fax :</span><span>0161 835 2125</span><br>
  <span class="style3">Email:</span><span>sales@europasonic.com</span></p> 
    </td>
    <td align="right">
<span class="style2">Order ID :</span><span><?php echo '123456789';?></span><BR>
  <!-- <span class="style2">Customer ID : </span><span><?php echo $custData->cust_ID; ?></span><BR> -->
  <span class="style2">Customer Type :</span><span><?php echo $custData->cust_band; ?></span><br>
  <span class="style2">Date :</span><span><?php echo $ordrdate; ?></span><br>
  <span><?php echo $custData->cust_Name;  ?></span><br>
  <span><?php echo $custData->cust_Door_No; echo","; echo $custData->cust_Street_Name ; ?></span><br>
  <span><?php echo $custData->cust_town; echo","; echo $custData->cust_country;echo","; echo $custData->cust_postcode;?></span><br><br>
   <span class="style2">Tel :</span><span><?php echo $custData->cust_no;?></span><br>
  <span class="style2">Email :</span><span><?php echo $custData->cust_mail;?></span><br>

   
    </td></tr>
        
    </tbody>   
    
</table>
<hr>
<table style="width: 100%;">
    <tbody>
    <tr>
    <td>
  <p align="left"><span class="style3">PURSWANI VIJAY </span><BR>
  <span class="style9">T/A VEEKAY ENTERPRISES,</span><BR>
  <span class="style9">ACCESS SELF SOTRE,</span><br>
  <span class="style9">13 WHITE STONE WAY,</span><br>
  <span class="style9">CROY DON,</span><br>
  <span class="style9">CRO 4</span><br><br>
  <span class="style3">Tel:</span><span>Evo-Mail-Contact:0774 844 910</span><br>
  <span class="style3">Fax:</span><span>No fax number</span><br>
  <span class ="style3">Email:</span><span>No email contact</span></p> 
    </td>
    <td align="right" style="vertical-align:top;">
  <span class="style10">ORDER CONFIRMATION </span><BR><br><br>
 <!--  <span class="style2">Ref ID :</span><span><?php echo $salesRef->sales_RefID; ?></span><br> -->
  <span class="style2">Ref Name :</span><span><?php echo $salesRef->sales_Name; ?></span><br><br>
  <span class="style2">Mobile No : </span><span><?php echo $salesRef->sales_No; ?></span><br>
  <span class="style2">Email : </span><span><?php echo $salesRef->sales_Email; ?></span><br>
    </td>
    </tr>        
    </tbody>
        
    
</table>


  <span style="text-decoration: underline;"></span>


<br>


<hr>
 <table cellpadding="10" style="width: 100%; border-top: 1px dashed #cdd0d4; border-bottom: 1px dashed #cdd0d4;">
     <!-- table header to be repeated on each PDF page -->
        <thead >
            <tr >
                <th align="left" style="border-bottom: 1px dashed #cdd0d4;">Description</th>                          
                <th align="center" style="border-bottom: 1px dashed #cdd0d4;">Qunatity</th>   
                <th align="center" style="border-bottom: 1px dashed #cdd0d4;">Item Price</th> 
                <th align="center" style="border-bottom: 1px dashed #cdd0d4;">Line Price</th>             
            </tr>
        </thead>
        
        <tbody>            
                      <?php 
                      $value = count($one);
                      for($i=0; $i<$value;$i++) {
                      ?>
                        <tr>
                            <td>
                               <?php                        
                               echo $productData[$i]['product_Desc'] ;             
                                 
                                ?>
                            </td>
                            <td align="center">
                                <?php print_r( $one[$i]->qty); ?>
                            </td>
                            <td align="center">
                                <?php print_r( $one[$i]->item_price); ?>
                            </td>
                            <td align="center">
                                <?php print_r( $one[$i]->Line_price); ?>
                            </td>
                        </tr>
                        <?php } ?>
                   
            
            
        </tbody>
    </table >
    <table cellpadding="10" align="right" style=" width: 42%;">
        <tbody>
                <tr><td style="border-bottom:0.80px dashed #cdd0d4;">Order Total</td><td style="border-bottom:0.80px dashed #cdd0d4;"><?php echo $ordrtot; ?></td></tr>
                <tr><td style="border-bottom:1px dashed #cdd0d4;">Order Carriage</td><td style="border-bottom:1px dashed #cdd0d4;"><?php echo $ordrCarge; ?></td></tr>
                <tr><td style="border-bottom:1px dashed #cdd0d4;">Total</td><td style="border-bottom:1px dashed #cdd0d4;"><?php echo $tot; ?></td></tr>   
      
        </tbody>
    </table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>