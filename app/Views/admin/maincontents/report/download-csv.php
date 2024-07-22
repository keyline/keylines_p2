<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=Contact_Enquiry_Report-".date('ymd').".xls");
?>
<table  border="1" cellpadding="5" cellspacing="3" style="border-collapse: collapse; width: 1000px;" align="center">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>                                         
            <th>DOB</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Language</th>
            <th>State</th>                
            <th>District</th>
            <th>Pincode</th>
            <th>Certificate</th> 
            <th>Created date</th>                                             
        </tr>
    </thead>
    <tbody>
        <?php if($rows) { $i=1; foreach($rows as $row) { ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row->name; ?></td>
            <td><?php echo $row->dob;?></td>
            <td><?php echo $row->gender;?></td>
            <td><?php echo $row->email; ?></td>
            <td><?php echo $row->phone ?></td>
            <td><?php echo $row->language;?></td>
            <td><?php echo $row->state;?></td>          
            <td><?php echo $row->district;?></td>
            <td><?php echo $row->pincode;?></td>
            <td><a href="<?= base_url('/uploads/certificate/'.$row->certificate_url) ?>" target="blank"><?php echo $row->certificate_url;?></a></td>  
            <td><?php echo $row->created_at;?></td>                                           
        </tr>                                    
        <?php } } ?>
    </tbody>
</table>