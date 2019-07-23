<?php
	require_once('db/mysql_connect.php');
	session_start();
	$count = 1;

                                                    $query = "SELECT name, t.requestedBy, t.ticketID, (convert(aes_decrypt(au.firstName, 'Fusion') using utf8)) AS 'firstName' ,(convert(aes_decrypt(au.lastName, 'Fusion')using utf8)) AS 'lastName', lastUpdateDate, dateCreated, dateClosed, dueDate, priority,summary,
                                                             t.description, t.serviceType as 'serviceTypeID', st.serviceType,t.status as 'statusID', s.status
                                                            FROM thesis.ticket t
                                                            JOIN user au
                                                                ON t.assigneeUserID = au.UserID
                                                            JOIN ref_ticketstatus s
                                                                ON t.status = s.ticketID
                                                            JOIN ref_servicetype st
                                                                ON t.serviceType = st.id
                                                            JOIN employee e 
                                                                ON t.requestedBy = e.UserID
                                                            WHERE au.UserID = '{$_SESSION['userID']}' and t.status != 7 
                                                            ORDER BY dateCreated DESC LIMIT 10;";
                                                                  
                                                    $result = mysqli_query($dbc, $query);
                                                    
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                      
                                                      echo "<tr class='gradeA'>
                                                            <td style='display: none'>{$row['ticketID']}</td>
                                                            <td>{$count}</td>
                                                            <td style='display: none'>{$row['serviceTypeID']}</td>
                                                            <td>{$row['serviceType']}</td>
                                                            <td>{$row['lastUpdateDate']}</td>
                                                            <td>{$row['dueDate']}</td>";

                                                        if($row['priority'] == "High" || $row['priority'] == "Urgent"){
                                                            echo "<td><span class='label label-danger'>{$row['priority']}</span></td>";
                                                        }
                                                        if($row['priority'] == "Medium"){
                                                            echo "<td><span class='label label-warning'>{$row['priority']}</span></td>";
                                                        }
                                                        if($row['priority'] == "Low"){
                                                            echo "<td><span class='label label-success'>{$row['priority']}</span></td>";
                                                        }
                                                        

                                                        if($row['statusID'] == "1"){
                                                            echo "<td><span class='label label-success'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "2"){
                                                            echo "<td><span class='label label-default'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "3"){
                                                            echo "<td><span class='label label-primary'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "4" || $row['statusID'] == "5"){
                                                            echo "<td><span class='label label-info'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "6"){
                                                            echo "<td><span class='label label-warning'>{$row['status']}</span></td>";
                                                        }
                                                        if($row['statusID'] == "7"){
                                                            echo "<td><span class='label label-danger'>{$row['status']}</span></td>";
                                                        }
                                                    
                                                        echo "<td>{$row['name']}</td></tr>";

                                                          $count++;
                                                    }


?>