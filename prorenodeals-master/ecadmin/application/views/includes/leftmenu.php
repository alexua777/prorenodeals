<div class="sidebar-wrapper">
                <nav id="mainnav">
                    <ul class="nav nav-list">
                        <li>
                            <a href="index.php">
                                <span class="icon"><i class="icon20 i-screen"></i></span>
                                <span class="txt">Dashboard</span>
                            </a>
                        </li>
                        <?
                        $rws_query = "SELECT * FROM ".$prev."adminmenu 	WHERE status = 'Y' AND parent_id = 0 	ORDER BY ord ASC, name ASC";
                        $rws = mysql_query( $rws_query ) or die("Menu error: ".mysql_error());
                        while($rw = @mysql_fetch_array($rws))
                        {
						    $main_name = stripslashes( $rw['name'] );

						    if(!empty($rw['url'])):
								$admin_url = $rw['url'];
							else:
								$admin_url = "#";
							endif;
							 echo'<li><a href="'.$admin_url.'" target="_blank"><span class="icon"><i class="icon20 i-table"></i></span>
                                    <span class="txt">' . $main_name . '</span></a>';
                               

								$rs_query = "SELECT * FROM ".$prev."adminmenu
												WHERE status = 'Y'
												AND parent_id = '".$rw['id']."'
												ORDER BY ord ASC, name ASC";
								$rs = mysql_query($rs_query);

								if(@mysql_num_rows($rs))
								{
									echo '<ul class="sub">';

									while($d = @mysql_fetch_array($rs))
									{
										$sub_name = stripslashes( $d['name'] );
										$sub_pic = $d['pic'];

										if(empty($d['pic']) || !file_exists($d['pic'])) {
											$sub_pic = $img;
										}

										if(!empty($d['url']))
											$admin_url2 = $d['url'];
										else
											$admin_url2 = "#";

										echo '<li><a href="'.$admin_url2.'"><span class="icon"><i class="icon20 i-cube-3"></i></span><span class="txt">'.$sub_name.'</span></a></li>';
									}

									echo "</ul>";
								}
								echo "</li>";
								
						}
	                   ?>

                    </ul>
                </nav><br>
                <div class="sidebar-widget center" style='border-bottom:solid 1px silver'>
                    <h4 class="sidebar-widget-header"><i class="icon i-pie-2"></i> Loged in Members</h4>
                    <?
                     $r1=mysql_query("select count(*) as total from " . $prev. "user where substring(ldate,1,10)='" . date("Y-m-d") . "'");
	                 $v=@mysql_result($r1,0,"total");
	                 echo"<p align=center><h3>" . $v . "</h3></p>";
                    ?>
                </div><!-- end .sidebar-widget -->
                 <!-- end .sidebar-widget -->


                <!-- end .sidebar-widget -->

            </div> <!-- End .sidebar-wrapper  -->
        </aside><!-- End #sidebar  -->