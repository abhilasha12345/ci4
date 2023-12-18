<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>	
    <title>Users List</title>
	<style>
	table{
		border-collapse:collapse;
	}
	table th{
		text-align:left;
	}
	</style>
</head>
<body>
    <div style="margin: 0 auto;display: block;">
        <table width="100%" border="1">
            <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>DOB</th>
                            <th>Gender</th>                            
                            
                        </tr>
                        <?php

                        if($user_data)
                        {   $i=1;
                            foreach($user_data as $user)
                            {
                                /*if(!empty($user['profile_pic'])){
									$img_url = base_url('/uploads/'.$user['profile_pic']);
									$img='<img src="'. $img_url.'" width="60" height="60" />';
								}
								else $img='';*/
								$img='';
								
								
								echo '
                                <tr>
                                    <td>&nbsp;'.$i.'</td>
                                    <td width="150">&nbsp;'.$user["first_name"].' '.$user["last_name"].' '.$img.'</td>
                                    <td>&nbsp;'.$user["email"].'</td>
									<td>&nbsp;'.date('d-m-Y',strtotime($user["dob"])).'</td>
                                    <td>&nbsp;'.$user["gender"].'</td>
                                   
                                </tr>';
								$i++;
                            }
                        }

                        ?>
        </table>
    </div>
</body>
</html>