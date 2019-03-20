$queryDept="SELECT aa.id AS assetID, ras.description AS assetStatus, aa.date, a.propertyCode, rac.name AS assetCategory, rb.name AS brand,
                                                                am.description AS model, b.name AS building, far.floorRoom, d.name AS department, e.name AS employee FROM assetaudit aa
                                                                JOIN ref_assetStatus ras ON aa.assetStatus = ras.id
                                                                JOIN asset a ON aa.assetID = a.assetID
                                                                JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                JOIN assetassignment assass ON a.assetID = assass.assetID
                                                                JOIN building b ON assass.BuildingID = b.BuildingID
                                                                JOIN floorandroom far ON assass.FloorAndRoomID = far.FloorAndRoomID
                                                                LEFT JOIN department d ON assass.DepartmentID = d.DepartmentID
                                                                JOIN employee e ON assass.personresponsibleID = e.UserID;";
                                                            
																$resultDept=mysqli_query($dbc,$queryDept);
																while($rowDept=mysqli_fetch_array($resultDept,MYSQLI_ASSOC)){
																	echo "<tr>
																		<td class='hidden'>{$rowDept['assetID']}</td>
																		<td>{$rowDept['assetStatus']}</td>
                                                                        <td>{$rowDept['date']}</td>
                                                                        <td>{$rowDept['assetCategory']}</td>
                                                                        <td>{$rowDept['propertyCode']}</td>
                                                                        <td>{$rowDept['brand']}</td>
                                                                        <td>{$rowDept['model']}</td>
                                                                        <td>{$rowDept['building']}</td>
                                                                        <td>{$rowDept['floorRoom']}</td>
                                                                        <td>{$rowDept['department']}</td>
                                                                        <td>{$rowDept['employee']}</td>
                                                                        </tr>";
																}