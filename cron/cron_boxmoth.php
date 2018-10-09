<?php
	/*
	*	Generates a new row entry in table "box_month" for each month for each box.
	*	Each row contains a number for each type of crime in that box-month.
	*	
	* 	Process:
	*	- [Potential pre-process] calculate priority.
	*	- Select a box (could be random, iterative, or priority based)
	*	- Pull all months for that box
	*	- Decide which months need processing (this could be ones that need re-
	*	  processing, or have not been processed yet. This is why we could do with an
	*	  upload manager.)
	*	- Total the types of crimes inside the box & insert to box_month!
	*	- Repeat indefinately
	*/






?>