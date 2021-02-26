 <?php
 
  $TopBarSearch = $_POST['TopSearchBar'];
 if(!empty($TopBarSearch)){
 	$whereconjob = 'where jm.job_id = "'.$TopBarSearch.'" or ct.FirstName = "'.$TopBarSearch.'" or ct.LastName = "'.$TopBarSearch.'" or ct.Phone = "'.$TopBarSearch.'" or ct.Mobile = "'.$TopBarSearch.'" or jm.businuess = "'.$TopBarSearch.'" or jm.company_number = "'.$TopBarSearch.'" or ct.Address = "'.$TopBarSearch.'" or ct.Zip = "'.$TopBarSearch.'"';
 }
 	// error_reporting(E_ALL);
 	// ini_set('display_errors',1);

 	global $conn;
	  
	$to_date = date("Y-m-d");
	$chng = select_multi_records("job_master","*"," Set_status_to != 'Future' AND Set_status_to = 'Open' AND future_date > '$to_date'");
	while($crows = mysqli_fetch_assoc($chng))
	{
	$jobid = $crows["job_id"];			
	update_table("job_master"," Set_status_to='Future'"," job_id='$jobid'");
	}
	
	$chng1 = select_multi_records("job_master","*"," Set_status_to = 'Future' AND Set_status_to != 'Open' AND future_date <= '$to_date'");
	while($crows1 = mysqli_fetch_assoc($chng1))
	{
		$jobid1 = $crows1["job_id"];			
		update_table("job_master"," Set_status_to='Open'"," job_id='$jobid1'");
	}
	 	
	  $guid = select_single_record("user_group_detail","*"," Username = '$user'");

	  $comp_tot = totalrows("job_privileges","*"," Complete_job = 'Y' and job_status='Login' and Group_Id = '$guid[Group_Id]'");
	  $canls_tot = totalrows("job_privileges","*"," Cancelled_job = 'Y' and job_status='Login' and Group_Id = '$guid[Group_Id]' ");
	  $pre_tot = totalrows("job_privileges","*"," PreSettled_job = 'Y' and job_status='Login' and Group_Id = '$guid[Group_Id]'");
	  
	  
	  $get_prv = select_multi_records("group_privilege_details","*"," group_id = '$guid[Group_Id]'");
	  $prv_dls = array();
	  while($prows = mysqli_fetch_assoc($get_prv))
	  {
	     $prv_dls[] = $prows["Privileges_Id"];
	  }
	  $size = sizeof($prv_dls);
	  if($size)
		{
		  $addprv = in_array("9",$prv_dls);
		  $editprv = in_array("10",$prv_dls);
		  $delprv = in_array("11",$prv_dls);
		  $lookupprv = in_array("12",$prv_dls);
		}
			//Page Colum Span 
			if($editprv <> "" && $delprv <> "") 
			{
			  if($_SESSION["supadm"] == 1) {  $colspn = "colspan='2'"; }else{$colspn = "colspan='1'"; } 
			  $colspns = "colspan='16'";
			}
			else if($editprv <> "" || $delprv <> "")
			{
			  $colspn = "colspan='0'";
			  $colspns = "colspan='11'";
			}
			else
			{
			  $colspns = "colspan='10'";
			}
		
			//Getting Records to particular user
			$qryid = select_single_record("user_master","*"," Username = '$user'");
	 
        
		if($_REQUEST["posteds"])
	   {
		  $whereconjob = " where 1";
		  $weherall = " where 1 ";
		  /*if($_REQUEST["status"] <> "" && ($_REQUEST["jobids"] == "" && $_REQUEST["tech_name"]  == "" && $_REQUEST["comp_name"]  == "" && $_REQUEST["first"]  == "" && $_REQUEST["last"]  == "" && $_REQUEST["mob1"]  == "" && $_REQUEST["mob2"]  == "" && $_REQUEST["mob3"]  == "" && $_REQUEST["phon1"]  == "" && $_REQUEST["phon2"]  == "" && $_REQUEST["phon3"]  == "" && $_REQUEST["email"]  == "" && $_REQUEST["state"]  == "" && $_REQUEST["city"]  == "" && $_REQUEST["zip"]  == "" && $_REQUEST["crdit_card_auth"]  == "" && $_REQUEST["fromdt"]  == "" && $_REQUEST["todt"]  == "" && $_REQUEST["payment_type"]  == ""))
		  {
		    //echo "if ".$_REQUEST["status"]." : ".$_REQUEST["fromdt"]; exit;
			$whereconjob .= " AND jm.Set_status_to = '$_REQUEST[status]'";
			//$q_str .= "&status=$_REQUEST[status]";
			 if($_REQUEST["status"] == "Open")
			 {
			    header("location:homes.php?comd=openstatus&stas=Open");
			 }
			 if($_REQUEST["status"] == "Assigned")
			 {
			   header("location:homes.php?comd=assngjobs&stas=Assigned");
			 }
			 if($_REQUEST["status"] == "Completed" || $_REQUEST["status"] == "Settled")
			 {
			 	header("location:homes.php?comd=compjobdetails&stas=$_REQUEST[status]");
			 }
			 if($_REQUEST["status"] == "Cancelled")
			 {
			 	header("location:homes.php?comd=compjobdetails&stas=$_REQUEST[status]");
			 }
			 if($_REQUEST["status"] == "Future")
			 {
			 	header("location:homes.php?comd=jobdetails&stas=Future");
			 }
		  }*/
/*		  if($_REQUEST["comp_name"] <> "" && $_REQUEST["tech_name"] == "")
		  {
		    header("location:homes.php?comd=compjobdetails&stas=$_REQUEST[status]&comp_name=$_REQUEST[comp_name]");
			$q_str .= "&comp_name=$_REQUEST[comp_name]";
		  }


*/		  

		   if($_REQUEST["job_type"] <> "")
		  {
		    $whereconjob .= " AND jm.job_typename = '$_REQUEST[job_type]'"; 
		    //echo $whereconjob; die;
		    $q_str .= "&job_type=$_REQUEST[job_type]";
			//$q_str .= "&comp_name=$_REQUEST[comp_name]";
		  }
		  if($_REQUEST["CallType"] <> "")
		  {
		    $whereconjob .= " AND jm.CallType = '$_REQUEST[CallType]'"; 
		    //echo $whereconjob; die;
		    $q_str .= "&CallType=$_REQUEST[CallType]";
			//$q_str .= "&comp_name=$_REQUEST[comp_name]";
		  }

		   if($_REQUEST["PrposalValid"] <> "")
		  {
		    $whereconjob .= " AND jm.PrposalValid = '$_REQUEST[PrposalValid]'"; 
		    //echo $whereconjob; die;
		    $q_str .= "&PrposalValid=$_REQUEST[PrposalValid]";
			//$q_str .= "&comp_name=$_REQUEST[comp_name]";
		  }
		   if($_REQUEST["InvoiceValid"] <> "")
		  {
		    $whereconjob .= " AND jm.InvoiceValid = '$_REQUEST[InvoiceValid]'"; 
		    //echo $whereconjob; die;
		    $q_str .= "&InvoiceValid=$_REQUEST[InvoiceValid]";
			//$q_str .= "&comp_name=$_REQUEST[comp_name]";
		  }
		   if($_REQUEST["ReceiptValid"] <> "")
		  {
		    $whereconjob .= " AND jm.ReceiptValid = '$_REQUEST[ReceiptValid]'"; 
		    //echo $whereconjob; die;
		    $q_str .= "&ReceiptValid=$_REQUEST[ReceiptValid]";
			//$q_str .= "&comp_name=$_REQUEST[comp_name]";
		  }

		  //echo "mrrrr".$_REQUEST["material_receipt"]; die;

		   if($_REQUEST["material_receipt"] <> "0")
		  {
		    $whereconjob .= " AND jm.material_receipt = '$_REQUEST[material_receipt]'"; 
		    //echo $whereconjob; die;
		    $q_str .= "&material_receipt=$_REQUEST[material_receipt]";
			//$q_str .= "&comp_name=$_REQUEST[comp_name]";
		  }

		  //echo $whereconjob; die;
		  
		  if($_REQUEST["JobSizeType"] <> "")
		  {
		    $whereconjob .= " AND jm.JobSizeType = '$_REQUEST[JobSizeType]'"; 
		    //echo $whereconjob; die;
		    $q_str .= "&JobSizeType=$_REQUEST[JobSizeType]";
			//$q_str .= "&comp_name=$_REQUEST[comp_name]";
		  }
		   if($_REQUEST["industry"] <> "")
		  {
		  	//echo $_REQUEST[industry];
		    $whereconjob .= " AND jm.industry = '$_REQUEST[industry]'"; 
		    //echo $whereconjob; die;
		    $q_str .= "&ind_id=$_REQUEST[industry]";
			//$q_str .= "&comp_name=$_REQUEST[comp_name]";
		  }


		   if($_REQUEST["insurance"] <> "")
		  {
		  	//echo $_REQUEST[industry];
		    $whereconjob .= " AND jm.insurance = '$_REQUEST[insurance]'"; 
		    //echo $whereconjob; die;
		    $q_str .= "&insurance=$_REQUEST[insurance]";
			//$q_str .= "&comp_name=$_REQUEST[comp_name]";
		  }

		  if($_REQUEST["Wopayment"] <> "")
		  {
		  	//echo $_REQUEST[industry];
		    $whereconjob .= " AND jm.Wopayment = '$_REQUEST[Wopayment]'"; 
		    //echo $whereconjob; die;
		    $q_str .= "&Wopayment=$_REQUEST[Wopayment]";
			//$q_str .= "&comp_name=$_REQUEST[comp_name]";
		  }

		  /* if($_REQUEST["threeStatus"] <> "")
		  {
		    $whereconjob .= " AND jm.Set_status_to IN('Completed','Settled','Pre-Settled') ";
		    $q_str .= "&threeStatus=1"; 
		  }*/
		  
		  if($_REQUEST["comp_name"] <> "")
		  {
		    $whereconjob .= " AND jm.company_id = '$_REQUEST[comp_name]'";
			$q_str .= "&comp_name=$_REQUEST[comp_name]";
		  }		  
		  if($_REQUEST["comp_name"] <> "" && $_REQUEST["tech_names"] <> "")
		  {
		    $whereconjob .= " AND jm.company_id = '$_REQUEST[comp_name]' AND jm.Technician_ID = '$_REQUEST[tech_names]'";
			//$q_str .= "&status=$_REQUEST[status]";
		  }		  
		  if($_REQUEST["status"] <> "")
		  {
		    if($_REQUEST["status"] == '1'){
		  		 $whereconjob .= " AND jm.Set_status_to IN('Completed','Settled','Pre-Settled') ";
				 $q_str .= "&status=1"; 
		  	}else{
		  		$whereconjob .= " AND jm.Set_status_to = '$_REQUEST[status]'";
				$q_str .= "&status=$_REQUEST[status]";
		  	}
		  }
		  if($_REQUEST["jobids"] <> "")
		  {
		    $whereconjob .= " AND jm.job_id = '$_REQUEST[jobids]'";
			$q_str .= "&jobids=$_REQUEST[jobids]";
		  }
		  if($_REQUEST["tech_name"] <> "" && $_REQUEST["comp_name"] <> "")
		  {
		    $whereconjob .= " AND tc.Technician_ID = '$_REQUEST[tech_name]' AND cp.company_id = '$_REQUEST[comp_name]' AND jm.Technician_ID = tc.Technician_ID ";
			$q_str .= "&tech_name=$_REQUEST[tech_name]";
		  }

		  if($_REQUEST["first"] <> "")
		  {
		    $whereconjob .= " AND ct.FirstName like '%$_REQUEST[first]%'";
			$q_str .= "&first=$_REQUEST[first]";
		  }

		  if($_REQUEST["CustName"] <> "")
		  {
		    $whereconjob .= " AND (ct.FirstName like '%$_REQUEST[CustName]%' || ct.LastName like '%$_REQUEST[CustName]%')";
			$q_str .= "&CustName=$_REQUEST[CustName]";
		  }

		  if($_REQUEST["last"] <> "")
		  {
		    $whereconjob .= " AND ct.LastName like '%$_REQUEST[last]%'";
			$q_str .= "&last=$_REQUEST[last]";
		  }
		  if($_REQUEST["mob1"] <> "" && $_REQUEST["mob2"] <> "" && $_REQUEST["mob3"] <> "")
		  {
		    $mibile = $_REQUEST["mob1"].$_REQUEST["mob2"].$_REQUEST["mob3"];
			$whereconjob .= " AND ct.mobile = '$mibile'";
			$q_str .= "&mob1=$_REQUEST[mob1]&mob2=$_REQUEST[mob2]&mob3=$_REQUEST[mob3]";
		  }
		  if($_REQUEST["phon1"] <> "" && $_REQUEST["phon2"] <> "" && $_REQUEST["phon3"] <> "")
		  {
		    $phones = $_REQUEST["phon1"].$_REQUEST["phon2"].$_REQUEST["phon3"];
			$whereconjob .= " AND ct.Phone = '$phones'";
			$q_str .= "&phon1=$_REQUEST[phon1]&phon2=$_REQUEST[phon2]&phon3=$_REQUEST[phon3]";
		  }
		  if($_REQUEST["both1"] <> "" && $_REQUEST["both2"] <> "" && $_REQUEST["both3"] <> "")
		  {
		    $bothMP = $_REQUEST["both1"].$_REQUEST["both2"].$_REQUEST["both3"];
			$whereconjob .= " AND (ct.Phone = '$bothMP' || ct.mobile = '$bothMP')";
			$q_str .= "&phon1=$_REQUEST[both1]&phon2=$_REQUEST[both2]&phon3=$_REQUEST[both3]";
		  }
		  if($_REQUEST["email"] <> "")
		  {
		    $whereconjob .= " AND ct.email like '%$_REQUEST[email]%'";
			$q_str .= "&email=$_REQUEST[email]";
		  }		  
		  if($_REQUEST["address"] <> "")
		  {
		    $whereconjob .= " AND ct.Address like '%$_REQUEST[address]%'";
			$q_str .= "&address=$_REQUEST[address]";
		  }
		  if($_REQUEST["state"] <> "")
		  {
		    $whereconjob .= " AND ct.State = '$_REQUEST[state]'";
			$q_str .= "&state=$_REQUEST[state]";
		  }
		  if($_REQUEST["city"] <> "")
		  {
		    $whereconjob .= " AND ct.City = '$_REQUEST[city]'";
			$q_str .= "&city=$_REQUEST[city]"; 
		  }
		  if($_REQUEST["zip"] <> "")
		  {
		    $whereconjob .= " AND ct.Zip like '$_REQUEST[zip]%'";
			$q_str .= "&zip=$_REQUEST[zip]";
		  }
		  //Credit Card Auth
		  if($_REQUEST["crdit_card_auth"] <> "")
		  {
		    $whereconjob .= " AND jm.credit_card_auth like '%$_REQUEST[crdit_card_auth]%'";
			$q_str .= "&crdit_card_auth=$_REQUEST[crdit_card_auth]";
		  }
		  if($_REQUEST["fromdt"] <> "" && $_REQUEST["todt"] == "")
		  {
			$sdate = convert_date($_REQUEST["fromdt"],"Y-m-d");
		    $whereconjob .= " AND jm.Started_date = '$sdate'";
			$q_str .= "&fromdt=$_REQUEST[fromdt]";
		  }
		  if($_REQUEST["fromdt"] <> "" && $_REQUEST["todt"] <> "")
		  {
			$sdate = convert_date($_REQUEST["fromdt"],"Y-m-d");
			$sdate1 = convert_date($_REQUEST["todt"],"Y-m-d");
		    $whereconjob .= " AND jm.Started_date BETWEEN  '$sdate' AND '$sdate1'";
			$q_str .= "&todt=$_REQUEST[todt]&fromdt=$_REQUEST[fromdt]";
		  }
		  if($_REQUEST["fromdt"] == "" && $_REQUEST["todt"] <> "")
		  {
			$todt = convert_date($_REQUEST["todt"],"Y-m-d");
		    $whereconjob .= " AND jm.Started_date = '$todt'";
			$q_str .= "&todt=$_REQUEST[todt]";
		  }
		 if($_REQUEST["payment_type"]=="cash")
		  {
			$whereconjob .= " AND (jm.Cash != '0.00' OR jm.Cash != '')";
			$q_str .= "&cash=$_REQUEST[payment_type]";
		  }
		  if($_REQUEST["payment_type"]=="cheque")
		  {
			$whereconjob .= " AND (jm.Checks != '0.00' OR jm.Checks != '')";
			$q_str .= "&checks=$_REQUEST[payment_type]";
		  }
		  if($_REQUEST["payment_type"]=="cashandcheck")
		  {
			$whereconjob .= " AND (jm.Cash != '0.00' OR jm.Cash != '' AND jm.Checks != '0.00' OR jm.Checks != '')";
			$q_str .= "&cashandcheck=$_REQUEST[payment_type]";
		  }
		  if($_REQUEST["payment_type"]=="credit")
		  {
			$whereconjob .= " AND (jm.Credit_Card != '0.00' OR jm.Credit_Card != '')";
			$q_str .= "&credit=$_REQUEST[payment_type]";
		  }
		  if($_REQUEST["payment_type"]=="cashandcredit")
		  {
			$whereconjob .= " AND (jm.Cash != '0.00' OR jm.Cash != '' AND jm.Credit_Card != '0.00' OR jm.Credit_Card != '')";
			$q_str .= "&cashandcredit=$_REQUEST[payment_type]";
		  }
		  if($_REQUEST["payment_type"]=="openbill")
		  {
			$whereconjob .= " AND (jm.open_bill != '0.00' OR jm.open_bill != '')";
			$q_str .= "&openbill=$_REQUEST[payment_type]";
		  }
		  if($_REQUEST["businuess"] <> "")
		  {
			$whereconjob .= " AND jm.businuess = '$_REQUEST[businuess]'";
			$q_str .= "&businuess=$_REQUEST[businuess]";
		  }
		    if($_REQUEST["company_number_single"] <> "")
		  {
			$whereconjob .= " AND jm.company_number = '$_REQUEST[company_number_single]'";
			$q_str .= "&company_number=$_REQUEST[company_number_single]";
		  }
		  
		   if($_REQUEST["company_number"] <> "")
		  {
			$cnum = $_REQUEST["company_number"];
            $Cnumberstr = preg_replace('/\s+/',',',str_replace(array("\r\n","\r","\n"),' ',trim($cnum)));            
			$whereconjob .= " AND jm.company_number IN($Cnumberstr)";
			$q_str .= "&company_number=$Cnumberstr";
		  }
		   if($_REQUEST["verification"] <> "")
		  {		  	
			$whereconjob .= " AND jm.verification = '$_REQUEST[verification]'";
			$q_str .= "&verification=$_REQUEST[verification]";
		  }
		

	   }

			if($qryid['office_id'] == "")
			{
				$cnum = totalrows("company_master","*"," username='$user' and is_active='Y' ");
				if($cnum > 0)
				{
					if($whereconjob == "")
					{
						$whereconjob .= " where cp.username ='$user' and cp.company_id = tc.company_id and jm.Is_Active = 'Y'";
					}
					else
					{
						$whereconjob .= " AND cp.username ='$user' and cp.company_id = tc.company_id and jm.Is_Active = 'Y'";
					}
				}
				else
				{
					$whereconjob .= " AND jm.Is_Active = 'Y'";
				}
			}
			else
			{
				$whereconjob .= " AND jm.Is_Active = 'Y'";
			}

		
		//echo "<bR>whr ".$whereconjob;
		
		 // For Paging
		$page = $_REQUEST['page'];
		
		//echo "<br>select * from (job_master AS jm left join customer_master AS ct on jm.customer_id = ct.customer_id) left join company_master as cp on jm.company_id = cp.company_id left join technician as tc on jm.Technician_ID = tc.Technician_ID".$whereconjob." Group By job_id";

		$total = mysqli_num_rows(mysqli_query($conn,"select jm.*,ct.*,cp.company_id,cp.company_name,tc.Technician_ID,tc.FirstName,tc.LastName from (job_master AS jm left join customer_master AS ct on jm.customer_id = ct.customer_id) left join company_master as cp on jm.company_id = cp.company_id left join technician as tc on jm.Technician_ID = tc.Technician_ID".$whereconjob." Group By job_id "));

		//die;
		$limit = 10;
		$pager  = getPagerData($total, $limit, $page);
		$offset = $pager->offset;
		if($offset < 0)
		{
		  $offset =0;
		}
		$limit  = $pager->limit; 
		$page   = $pager->page;	

        //echo "<br>select jm.*,ct.*,cp.*,tc.Technician_ID,tc.FirstName,tc.LastName from (job_master AS jm left join customer_master AS ct on jm.customer_id = ct.customer_id) left join company_master as cp on jm.company_id = cp.company_id left join technician as tc on jm.Technician_ID = tc.Technician_ID ".$whereconjob." Group By job_id ORDER BY job_id DESC LIMIT $offset, $limit";
		
		// echo "<br>select jm.*,ct.*,cp.company_id,cp.company_name,tc.Technician_ID,tc.FirstName,tc.LastName from (job_master AS jm left join customer_master AS ct on jm.customer_id = ct.customer_id) left join company_master as cp on jm.company_id = cp.company_id left join technician as tc on jm.Technician_ID = tc.Technician_ID ".$whereconjob." Group By job_id ORDER BY job_id DESC LIMIT $offset, $limit";die;

		$job_qry = mysqli_query($conn,"SELECT 
									jm.*,
									ct.*,
									ct.FirstName AS customer_firstname,
									ct.LastName AS customer_lasttname,
									cp.company_id,
									cp.company_name,
									tc.Technician_ID,
									tc.FirstName,
									tc.LastName,
									UNIX_TIMESTAMP(jm.Created_Date) as created_time,
									UNIX_TIMESTAMP(jm.Assigned_Date) as assigned_time,
									UNIX_TIMESTAMP(jm.Completed_Date) as completed_time,
									UNIX_TIMESTAMP(jm.Cancelled_Date) as canceled_time
									
								FROM (job_master AS jm left join customer_master AS ct on jm.customer_id = ct.customer_id) left join company_master as cp on jm.company_id = cp.company_id left join technician as tc on jm.Technician_ID = tc.Technician_ID ".$whereconjob." Group By job_id ORDER BY job_id DESC LIMIT $offset, $limit");

		
		
		$totalrow =mysqli_num_rows(mysqli_query($conn,"select jm.*,ct.*,cp.company_id,cp.company_name,tc.Technician_ID,tc.FirstName,tc.LastName from (job_master AS jm left join customer_master AS ct on jm.customer_id = ct.customer_id) left join company_master as cp on jm.company_id = cp.company_id left join technician as tc on jm.Technician_ID = tc.Technician_ID ".$whereconjob." Group By job_id ORDER BY job_id DESC "));

		/*echo "select jm.*,ct.*,cp.company_id,cp.company_name,tc.Technician_ID,tc.FirstName,tc.LastName from (job_master AS jm left join customer_master AS ct on jm.customer_id = ct.customer_id) left join company_master as cp on jm.company_id = cp.company_id left join technician as tc on jm.Technician_ID = tc.Technician_ID ".$whereconjob." Group By job_id ORDER BY job_id DESC "; die;*/
        
		if($_REQUEST["delsms"] == 1) 
		{
		  $msg = "Job Deleted Successfully!";
		}
		/*if($_REQUEST["addsms"] == 1)
		{ $jid = $_REQUEST["jobids"];
		  $msg = "Job Added Successfully! Job ID is $jid"; 
		}
		if($_REQUEST["editsms"] == 1)
		{
		  $msg = "Job Updated Successfully!";
		} */
		//echo " main "; exit;	
 ?>
 <link rel="stylesheet" href="../_common/css/main.css" type="text/css" media="all">

<link href="sortableTable.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">

<script type="text/javascript" src="../script/wz_tooltip.js"></script>
<script type="text/javascript" src="../_common/js/mootools.js"></script>
<script type="text/javascript" src="sortableTable.js"></script>
<script language="javascript">
function confirmval(jid)
{
	if(jid)
	{
		  window.open('check_dls.php?complt=1&jobid='+jid,'_blank','width=650,height=250,left=200,top=200,scrollbars,resizable');
	}
}
</script>
	<script type="text/javascript">
			var myTable = {};
			window.addEvent('domready', function(){
				myTable = new sortableTable('myTable', {overCls: 'over'});
			});
		</script>
 <script language="javascript">
function delfun(id)
{
  var val = confirm("You Want To Delete The Record!");
  if(val)
  { 
     window.location = "homes.php?comd=add_job&del=1&id="+id;
  } 
}
//homes.php?comd=lookup_job
</script>
  <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tablbrd">
    <tr>
      <td align="center" colspan="5" class="title">MANAGE JOB DETAILS</td>
    </tr>
    <tr>
      <td width="3%" align="center" class="button">&nbsp;</td>
      <td width="3%" align="center" class="button">&nbsp;</td>
      <td width="61%" align="center" class="button">&nbsp;</td>
      <td width="14%" align="center" class="button"><b>
	  <?php if($addprv <> "") { ?>
	  <a href="homes.php?comd=add_job"><font color="#000000">Input Job</font></a>
	  <? } ?>
	  </b></td>
      <td width="19%" align="center" class="button"><b>
	  <?php if($lookupprv <> "") { ?>
	  <a href="homes.php?comd=lookup_job"><font color="#000000">Lookup Job</font> </a>
	  <? } ?>
	  </b></td>
    </tr>
	<?php if($msg <> "") {	?>
    <tr>
      <td <?php echo $colspns; ?> align="center" class="alert_green"><?php echo $msg; ?>&nbsp;</td>
    </tr>
	 <? }  ?>
    <tr>
      
	  <td align="center" colspan="5" class="tdtext-bg">
	  <?php
		if($totalrow > 0)
		{
	  ?>
	  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tablbrd" id="myTable">
          <!--<tr class="head">--><thead class="bg_top">
            <th width="6%" class="bg_top" axis="number">S.No</th>
        	<th width="6%" class="bg_top" axis="number">Job ID</th>
        	<th width="2%" class="bg_top" axis="number">Flag</th>
            <th width="8%" class="bg_top" axis="string">UserName</th>
            <th width="7%" class="bg_top" axis="string">Technician</th>
            <th width="6%" class="bg_top" axis="string">Customer</th>
            <th width="9%" class="bg_top" axis="string">Address</th>
            <th width="5%" class="bg_top" axis="string">Area</th>
            <th width="7%" class="bg_top" axis="string">Phone</th>
            <th width="7%" class="bg_top" axis="string">Last attempt</th>
            <th width="8%" class="bg_top" axis="string">Verification</th>
            <th width="8%" class="bg_top" axis="string">Status</th>
            <th width="8%" class="bg_top" axis="string"> Opened Date </th>
            <th width="8%" class="bg_top" axis="string"> Assigned Date </th>
            <th width="8%" class="bg_top" axis="string"> Completed Date <br /></th>
			 <th width="8%" class="bg_top" axis="string"> Cancelled Date <br /></th>
            <?php if($editprv <> "" || $delprv <> "") { ?>
		    <th <?php echo $colspn; ?> class="bg_top1" >Action</th>
			<? } ?>
			<!-- <th width="8%" class="bg_top" axis="string">Flag Change</th> -->
		</thead><tbody>
          <!--</tr>
		  <?php //if($editprv <> "" || $delprv <> "") { ?>
		  <thead  bgcolor="#f3f3f3">
            <th colspan="14" bgcolor="<?=$bgcolor?>">&nbsp;</th>
			<?php //if($editprv <> "") { ?>
            <th align="center" class="action">Edit</th>
			<? //}
			//if($delprv <> "") { 
			//if($_SESSION["supadm"] == 1) {
			?>
            <th align="center" class="action">Delete</th>
			<? //} ?>
          </tr>
          </thead>-->

          <?php //}
  $cont = 0;
   if ($page > 1) { $cont = ($page - 1) * 10; } else { $cont = 0; }

  //if($weherall == "") { $weherall = " 1" ; }
  $sno=$offset;


  while($rows = mysqli_fetch_assoc($job_qry)) 
  {
  		// if($sno==3) { echo '<pre>'; echo json_encode($rows); die;}
		
		$jobid = $rows["job_id"];

		$tcid = $rows["Technician_ID"];
		$cmpid = $rows["cpid"];
		
		$created_time =!empty($rows['created_time'])? date('m/d/Y h:j',$rows['created_time']): 'N/A'; 
	  	$assigned_time =!empty($rows['assigned_time'])? date('m/d/Y h:j',$rows['assigned_time']): 'N/A'; 
	  	$completed_time =!empty($rows['completed_time'])? date('m/d/Y h:j',$rows['completed_time']): 'N/A'; 
	  	$canceled_time =!empty($rows['canceled_time'])? date('m/d/Y h:j',$rows['canceled_time']): 'N/A';
		
		$getval = select_single_record("job_master as a,technician as b","*"," job_id = '$jobid' AND a.Technician_ID = b.Technician_ID");
		$techname = $getval["FirstName"]." ".$getval["LastName"];
		
		if($qryid['office_id'] == "")
			{
				$cnum = totalrows("company_master","*"," username='$user' ");
				if($cnum > 0)
				{
					if($tcid <> 0)
					{
						$whereconcmp = " a.company_id = b.company_id AND b.Technician_ID = '$tcid' and a.username ='$user' ";
					}
					else
					{
						$whereconcmp = " a.company_id = b.company_id AND a.username ='$user' AND a.company_id ='$cmpid' ";
					}
				}
				else
				{
					if($tcid <> 0)
					{
						$whereconcmp = " a.company_id = b.company_id AND b.Technician_ID = '$tcid'";
					}
					else
					{
						$whereconcmp = " a.company_id = b.company_id  AND a.company_id ='$cmpid'";
					}
				}
			}
			else
			{
				if($tcid <> 0)
				{
					$whereconcmp = " a.company_id = b.company_id AND b.Technician_ID = '$tcid'";
				}
				else
				{
					$whereconcmp = " a.company_id = b.company_id  AND a.company_id ='$cmpid'";
				}
			}

 //echo "<br>".$whereconcmp;
		$getcmp = select_single_record("company_master as a,technician as b","*",$whereconcmp);
		//Technician Details Window Function
		$message = technician_details($getcmp["company_id"],$tcid);
														

		$cont++; 
	    $state = $rows["State"];
		
		$area = "[".$rows['City'].' '.",".$state."]";

		
		$status1 = $rows["Set_status_to"];
		if($status1 == "Settled")
		{
			$rep_job_tot = totalrows("technician_report_job_detail","*"," job_id= '$rows[job_id]' AND Is_settled='$status1'");
			if($rep_job_tot > 0)
			{
			  $view_job = $rep_job_tot;
			}
			else
			{
			  $view_job =1;
			}
		}
		else
		{
		 $view_job =0;
		}
		
			//Alternate Row Colors
			$bgcolor = alternatecolors(($cont%2));
	
			if($rows["Phone"] <> "") { $phones = splitphone($rows["Phone"]); } else	{ $phones="";}
			$sno++;			
  ?>

          <tr class="data <?php echo ($rows['is_callback']) ? 'callback': ''; ?>">
            <td bgcolor="<?=$bgcolor?>" align="center"><?=$sno?>&nbsp;</td>
            <!-- <td bgcolor="<? //$bgcolor?>"><?php //echo $cont;  ?></td> -->
			
			<td bgcolor="<?=$bgcolor?>">&nbsp;
			<?php
			if($rows["Set_status_to"] == "Completed" && $comp_tot > 0)
			{
			?>
			<a href="javascript:confirmval(<?=$rows["job_id"]?>);"><?=$rows["job_id"]?></a>
			<? } 
			else if($rows["Set_status_to"] == "Pre-Settled" && $pre_tot > 0)
			{
			?>
			<a href="javascript:confirmval(<?=$rows["job_id"]?>);"><?=$rows["job_id"]?></a>
			<? } 
			else if($rows["Set_status_to"] == "Cancelled" && $canls_tot > 0)
			{
			?>
			<a href="javascript:confirmval(<?=$rows["job_id"]?>);"><?=$rows["job_id"]?></a>
			<? } 
			else if($rows["Set_status_to"] == "Settled")
			{ ?>
			<a href="homes.php?comd=view_job&id=<?=$rows["job_id"]?>"><?=$rows["job_id"]?></a>
			<? } else { ?>
			<?php if($_SESSION[user] == 'admin'){ ?>
			<!-- <a href="homes.php?comd=add_job&edit=1&id=<?=$rows["job_id"]?>"><?=$rows["job_id"]?></a></br> -->
			<a href="homes.php?comd=new_jobb&edit=1&id=<?=$rows["job_id"]?>"><?=$rows["job_id"]?></a>
			<!-- <a href="homes.php?comd=new_jobb&edit=1&id=<?=$rows["job_id"]?>">Duplicate</a> -->
			<?php }else{ ?>
			<a href="homes.php?comd=new_jobb&edit=1&id=<?=$rows["job_id"]?>"><?=$rows["job_id"]?></a>
			<?php } ?>
			<? } ?>
			</td>
			<?			
			?>
			<?php 
			if($rows["enumFlag"] == "1"){
			
				$icon="<img src='/images/Flag-red-icon.png'>";
			}else if($rows["enumFlag"] == "2"){
				$icon='<img src="/images/Flag-orange-icon.png" height="24px" width="24px">';
			}else
			{
				$icon='';
			}
			?>
			<td bgcolor="<?=$bgcolor?>" nowrap><?php echo $icon;?></td>
			<td bgcolor="<?=$bgcolor?>" nowrap>&nbsp;<?=$rows["username"]?></td>
            <!-- <td bgcolor="<?=$bgcolor?>" nowrap>&nbsp;<?php //if($getcmp["company_name"] <> ""){ echo $getcmp["company_name"];} ?></td> -->
            <td bgcolor="<?=$bgcolor?>">&nbsp;<span onmouseover="Tip('<?=$message?>')" onmouseout="UnTip()" ><?php echo $techname; ?></span></td>
            <td bgcolor="<?=$bgcolor?>">&nbsp;<?php echo $rows["customer_firstname"]." ".$rows["customer_lasttname"]; ?></td>
            <td bgcolor="<?=$bgcolor?>">&nbsp;<?php echo $rows["Address"];  ?></td>
            <td bgcolor="<?=$bgcolor?>"><?php echo $area;  ?>&nbsp;</td>
            <td bgcolor="<?=$bgcolor?>"><?php if($phones <> "") { echo $phones; }?>&nbsp;</td>
            <!-- <td bgcolor="<? // $bgcolor?>"><?php //echo $area;  ?></td> -->
            <td bgcolor="<?=$bgcolor?>">&nbsp;
				<?php 
			//echo "<br>sds ".$rows["mobile"];
			// if($rows["mobile"] > 0){ $mob = splitphone($rows["mobile"]); }else { $mob = ""; }  echo $mob;
				// echo 'last note';
				if(!empty($rows["verification"])) {

				$notes_obj = new job_notes($rows["job_id"]);
				$noteTime = end($notes_obj->list);
				echo $noteTime['timestamp'];
				}	
				 
				//$noteArray.slice(-1)[0];
			$sp = explode(" ",$rows["Created_Date"]);
			$curdates = convert_date($sp[0],"m/d/Y");

			$sp1 = explode(" ",$rows["Assigned_Date"]);
			$assngdates = convert_date($sp1[0],"m/d/Y");

			$sp2 = explode(" ",$rows["Completed_Date"]);
			$compsdates = convert_date($sp2[0],"m/d/Y");

			$sp3 = explode(" ",$rows["Cancelled_Date"]);
			$cnlsdates = convert_date($sp3[0],"m/d/Y");
	
			?>
			</td>
            <td bgcolor="<?=$bgcolor?>">&nbsp;
            <? //if($rows["Set_status_to"] == "Cancelled" || $rows["Set_status_to"] == "Follow-Up" || $rows["Set_status_to"] == "Completed") {
            echo $rows["verification"]; 
        // } 
            ?>
            	
            </td>
            <td bgcolor="<?=$bgcolor?>"><?php echo $rows["Set_status_to"];  ?></td>
            <td bgcolor="<?=$bgcolor?>"><?=$created_time?></td>
            <td bgcolor="<?=$bgcolor?>"><?=$assigned_time?>&nbsp;</td>
            <td bgcolor="<?=$bgcolor?>"><?=$completed_time?>&nbsp;</td>
			<td bgcolor="<?=$bgcolor?>"><?=$canceled_time?>&nbsp;</td>
           <?php if($editprv <> "" && $view_job == 0) { ?>	
		    <td width="7%" align="center" bgcolor="<?=$bgcolor?>">
			<?php
			if($rows["Set_status_to"] == "Completed" && $comp_tot > 0)
			{
			?>
			<a href="javascript:confirmval(<?=$rows["job_id"]?>);"><img src="../images/edit_icon.gif" border="0"></a>
			<? } 
			else if($rows["Set_status_to"] == "Pre-Settled" && $pre_tot > 0)
			{
			?>
			<a href="javascript:confirmval(<?=$rows["job_id"]?>);"><img src="../images/edit_icon.gif" border="0"></a>
			<? } 
			else if($rows["Set_status_to"] == "Cancelled" && $canls_tot > 0)
			{
			?>
			<a href="javascript:confirmval(<?=$rows["job_id"]?>);"><img src="../images/edit_icon.gif" border="0"></a>
			<? } 
			else
			{ ?>
			<!-- <a href="homes.php?comd=add_job&edit=1&id=<?=$rows["job_id"]?>"><img src="../images/edit_icon.gif" border="0"></a> -->
			<a href="homes.php?comd=new_jobb&edit=1&id=<?=$rows["job_id"]?>"><img src="../images/edit_icon.gif" border="0"></a>
			<? } ?>
			</td>
		   <? }
		   else if($editprv <> "" && $view_job == 1)
		   {?>
		    <td width="8%" align="center" bgcolor="<?=$bgcolor?>"><a href="homes.php?comd=view_job&id=<?=$rows["job_id"]?>"><img src="../images/view_icon.gif" border="0"></a></td>
		  <? }



			//if($delprv <> "" &&) { 
			if($_SESSION["supadm"] == 1) {
		   ?>
		    <td width="12%" align="center" bgcolor="<?=$bgcolor?>"><a onClick="javascript:delfun(<?=$rows["job_id"]?>)">
              <input type="image" src="../images/delete_icon.gif">
            </a></td>
 		   <? } ?>

 		  <!--  <td>
 		   	<select name="flag_job">
 		   		<option selected="selected">--Selected--</option>
 		   		<option value = "regular">Regular job</option>
 		   		<option value = "flagged">Flagged job</option>
 		   </select></td> -->


          </tr>
          <? }//end while ?></tbody>
   <!-- For page Numbers-->
		 <tr>
				<td align="center" <?php echo $colspns; ?>> 
				<font class="formlable_mini">
				<?php 
				if($limit < $total)
				{
				$redirect_page = "homes.php?comd=manage_job";
				$querystring = "&posteds=1$q_str";
				require_once("../include/paging.php");
				}
				?>
				</font>				</td>
			</tr>
	<?   }
   else
   { ?>
          <tr>
            <td <?php echo $colspns; ?> class="message" align="center">No Records Found</td>
          </tr>
          <? } ?>
      </table></td>
    </tr>
  </table>
 <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script language="javascript">
function confirmval(jid)
{
	if(jid)
	{
		  window.open('check_dls.php?complt=1&jobid='+jid,'_blank','width=650,height=250,left=200,top=200,scrollbars,resizable');
	}
}

$("select.changeVerification").change(function(){
	var change_this = $(this);
	$.confirm({
    title: 'Confirm!',
    content: 'Are you sure want to change status!',
    buttons: {
        confirm: function () {
            	
		var val = change_this.val(), job_id = change_this.attr('data-job_id');
		$.ajax({
			data : { job_id : job_id, val : val},
			type : "post",
			success: function(){
				$.alert({
				title: 'Updated!',
				content: 'Status has been updated Successfully',
				});
			},
			error:function(jqXhr, textStatus, errorThrown){
				$.alert({
				title: 'Error!',
				content: errorThrown,
				});
			}
		});
        },
        cancel: function () { 
            return;
        }
    }
});

});
</script>
<?php
	if(isset($_POST['job_id'])) 
	{
		$job_id = $_POST['job_id'];
		$val = $_POST['val'];
		update_table("job_master","verification = '$val'"," job_id ='$job_id' ");
	}
?>
<style type="text/css">
	
.jconfirm .jconfirm-scrollpane {
    width: 50% !important;
    margin: auto;
}
</style>