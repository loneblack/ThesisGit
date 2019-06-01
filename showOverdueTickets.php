<?php
	require_once('db/mysql_connect.php');
	$query="SELECT name, t.requestedBy, t.ticketID,t.summary, rst.id,rst.serviceType,t.lastUpdateDate,t.dueDate, dateCreated,rts.status 
                                                            FROM thesis.ticket t 
                                                            JOIN thesis.ref_ticketstatus rts ON t.status=rts.ticketID
                                                            JOIN thesis.ref_servicetype rst ON t.serviceType=rst.id
                                                            JOIN employee e ON t.requestedBy = e.UserID 
															WHERE (DATE(t.dueDate) < DATE(now())) and t.status!='7'  
                                                            ORDER BY dateCreated LIMIT 10;";
    $result=mysqli_query($dbc,$query);
                                                
                                                    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                                        echo "<tr class='gradeA' id='{$row['ticketID']}'>
                                                            <td style='display: none'>{$row['ticketID']}</td>
                                                            <td>{$row['ticketID']}</td>
                                                            <td>{$row['serviceType']}</td>
                                                            <td style='display: none'>{$row['id']}</td>
                                                            <td>{$row['lastUpdateDate']}</td>
                                                            <td>{$row['dueDate']}</td>";

                                                        if($row['status']=='Open'){
                                                            echo "<td><span class='label label-success'>{$row['status']}</span></td>";
                                                        }
                                                        elseif($row['status']=='Closed'){
                                                            echo "<td><span class='label label-danger'>{$row['status']}</span></td>";
                                                        }
                                                        elseif($row['status']=='Assigned'){
                                                            echo "<td><span class='label label-info'>{$row['status']}</span></td>";
                                                        }
                                                        
                                                        elseif($row['status']=='In Progress'||$row['status']=='Waiting for Parts'){
                                                            echo "<td><span class='label label-warning'>{$row['status']}</span></td>";
                                                        }
                                                        elseif($row['status']=='Transferred'){
                                                            echo "<td><span class='label label-primary'>{$row['status']}</span></td>";
                                                        }
                                                        elseif($row['status']=='Escalated'){
                                                            echo "<td><span class='label label-default'>{$row['status']}</span></td>";
                                                        }
														 echo "<td>{$row['name']}</td></tr>";
                                                        
                                                        
                                                    }                  
			


?>