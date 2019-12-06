
---------------------------------------------
 
Date : 17 july 2018

 FLANCE_V3 UPGRADE CHANGES [ CI 2.1.4 -> 3.1.9]
 

----------------------------------------------

-------------------------------------------------------

/* Upgrading flance_v3 codeigniter version from 2.1.4 to 3.1.9 */

Change Log : 

replace system folder

replace application/config folder. 
	copy and paste the config file setting and constants and database

new folder inside application/views [foldername=errors]

replace third_party/MX folder

change models/auto_model.php

replacing index.php

Libraries/Models/Controller filename must be  in ucfirst


ADMIN

replace application/config folder. 
	copy and paste the config file setting and constants and database

replacing index.php


replace third_party/MX folder

change models/auto_model.php


----------------- Project modification -------------


 >> When freelancer is requesting milestones it first request milestone ... then employer approves it then he sends the invoice and then employer pays it .... this is a lot of bounding back and forward we want the invoice sent when freelancer is requesting milestone so it will say request milestone an send invoice. so we will skip one step of sending it invoice as whole ..

 >> when freelancer requests milestone the invoice is sent at that time
so it will be Request Milestone & Send Invoice
all in one step
i just dont see the point you request milestone then i approve then you send the invoice then i pay
its a bit long winded
it should be request milestone and send invoice
simple
it should be one step

Modified files :

 FRONT END
	
	-> projectdashboard_new/views/freelancer_milestone_fixed.php



 
