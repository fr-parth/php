<?php
 
include("../conn.php");  
 
        $qr   = "SELECT * FROM storeScadminState";
        $res  = mysql_query($qr);
        while($ra = mysql_fetch_assoc($res))
        {
           $instState       = $ra['scadminState'];
           $deptList        = $ra['deptName'];
           $acdYear         = $ra['acdYear'];    
        }

   if($instState === 'all' && $deptList === 'all' && $acdYear === 'all')
   { 
    $sql = "SELECT school_id,school_name,dept_name,scadmin_state,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    round((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0)),2) as total_on_100, 
 
   round(((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0))/10),2) as total_on_scale_10,
    
    academic_year
    
    FROM aicte_ind_feedback_summary_report group by school_id";

    $result = mysql_query($sql);       

    $file_ending = "xls";
    $filename = "AllData";        
    //header info for browser
    header("Content-Type: application/xls");    
    header("Content-Disposition: attachment; filename=$filename.xls");  
    header("Pragma: no-cache"); 
    header("Expires: 0");
    /*******Start of Formatting for Excel*******/   
    //define separator (defines columns in excel & tabs in word)
    $sep = "\t"; //tabbed character
    //start of printing column names as names of MySQL fields
    for ($i = 0; $i < mysql_num_fields($result); $i++) {
    echo mysql_field_name($result,$i) . "\t";
    }
    print("\n");    
    //end of printing column names  
    //start while loop to get data
        while($row = mysql_fetch_row($result))
        { 
            $schema_insert = "";
            for($j=0; $j<mysql_num_fields($result);$j++)
            {
//                if(!isset($row[$j]))
//                    $schema_insert .= "NULL".$sep;
//                elseif ($row[$j] != "")
                    $schema_insert .= "$row[$j]".$sep;
//                else
//                    $schema_insert .= "".$sep;
            }
            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
            print "\n";
        }  
       
   }
  else if($instState === 'all' && $deptList === 'all' && $acdYear != '' && $acdYear != 'all')  
    {  
       $sql = ("SELECT school_id,school_name,dept_name,scadmin_state,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    round((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0)),2) as total_on_100, 
 
   round(((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0))/10),2) as total_on_scale_10,
    
    academic_year

       FROM aicte_ind_feedback_summary_report

       WHERE academic_year='$acdYear' group by school_id");      
       
        $result = mysql_query($sql);       

        $file_ending = "xls";
        $filename = "allStateDepartment";  
        //header info for browser
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=$filename.xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        /*******Start of Formatting for Excel*******/   
        //define separator (defines columns in excel & tabs in word)
        $sep = "\t"; //tabbed character
        //start of printing column names as names of MySQL fields
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
        echo mysql_field_name($result,$i) . "\t";
        }
        print("\n");    
        //end of printing column names  
        //start while loop to get data
            while($row = mysql_fetch_row($result))
            {
                $schema_insert = "";
                for($j=0; $j<mysql_num_fields($result);$j++)
                {
//                    if(!isset($row[$j]))
//                        $schema_insert .= "NULL".$sep;
//                    elseif ($row[$j] != "")
                        $schema_insert .= "$row[$j]".$sep;
//                    else
//                        $schema_insert .= "".$sep;
                }
                $schema_insert = str_replace($sep."$", "", $schema_insert);
                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                $schema_insert .= "\t";
                print(trim($schema_insert));
                print "\n";
            } 

   }else if($instState === 'all' && $deptList != '' && $deptList != 'all' && $acdYear === 'all')  
    {  
       $sql = ("SELECT school_id,school_name,dept_name,scadmin_state,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    round((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0)),2) as total_on_100, 
 
   round(((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0))/10),2) as total_on_scale_10,
    
    academic_year

       FROM aicte_ind_feedback_summary_report

       WHERE dept_name='$deptList' group by school_id");      
       
        $result = mysql_query($sql);       

        $file_ending = "xls";
        $filename = "allStateDepartment";  
        //header info for browser
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=$filename.xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        /*******Start of Formatting for Excel*******/   
        //define separator (defines columns in excel & tabs in word)
        $sep = "\t"; //tabbed character
        //start of printing column names as names of MySQL fields
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
        echo mysql_field_name($result,$i) . "\t";
        }
        print("\n");    
        //end of printing column names  
        //start while loop to get data
            while($row = mysql_fetch_row($result))
            {
                $schema_insert = "";
                for($j=0; $j<mysql_num_fields($result);$j++)
                {
//                    if(!isset($row[$j]))
//                        $schema_insert .= "NULL".$sep;
//                    elseif ($row[$j] != "")
                        $schema_insert .= "$row[$j]".$sep;
//                    else
//                        $schema_insert .= "".$sep;
                }
                $schema_insert = str_replace($sep."$", "", $schema_insert);
                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                $schema_insert .= "\t";
                print(trim($schema_insert));
                print "\n";
            } 

   }
else if($instState === 'all' && $deptList != '' && $deptList != 'all' && $acdYear != '' && $acdYear != 'all')  
    {  
       $sql = ("SELECT school_id,school_name,dept_name,scadmin_state,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    round((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0)),2) as total_on_100, 
 
   round(((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0))/10),2) as total_on_scale_10,
    
    academic_year

       FROM aicte_ind_feedback_summary_report

       WHERE dept_name='$deptList' and academic_year='$acdYear' group by school_id");      
       
        $result = mysql_query($sql);       

        $file_ending = "xls";
        $filename = "allStateDepartment";  
        //header info for browser
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=$filename.xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        /*******Start of Formatting for Excel*******/   
        //define separator (defines columns in excel & tabs in word)
        $sep = "\t"; //tabbed character
        //start of printing column names as names of MySQL fields
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
        echo mysql_field_name($result,$i) . "\t";
        }
        print("\n");    
        //end of printing column names  
        //start while loop to get data
            while($row = mysql_fetch_row($result))
            {
                $schema_insert = "";
                for($j=0; $j<mysql_num_fields($result);$j++)
                {
//                    if(!isset($row[$j]))
//                        $schema_insert .= "NULL".$sep;
//                    elseif ($row[$j] != "")
                        $schema_insert .= "$row[$j]".$sep;
//                    else
//                        $schema_insert .= "".$sep;
                }
                $schema_insert = str_replace($sep."$", "", $schema_insert);
                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                $schema_insert .= "\t";
                print(trim($schema_insert));
                print "\n";
            } 

   }

else if($instState != '' && $instState != 'all' && $deptList === 'all' && $acdYear != '' && $acdYear != 'all')  
    {  
       $sql = ("SELECT school_id,school_name,dept_name,scadmin_state,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    round((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0)),2) as total_on_100, 
 
   round(((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0))/10),2) as total_on_scale_10,
    
    academic_year

       FROM aicte_ind_feedback_summary_report

       WHERE scadmin_state='$instState' and academic_year='$acdYear' group by school_id");      
       
        $result = mysql_query($sql);       

        $file_ending = "xls";
        $filename = "allStateDepartment";  
        //header info for browser
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=$filename.xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        /*******Start of Formatting for Excel*******/   
        //define separator (defines columns in excel & tabs in word)
        $sep = "\t"; //tabbed character
        //start of printing column names as names of MySQL fields
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
        echo mysql_field_name($result,$i) . "\t";
        }
        print("\n");    
        //end of printing column names  
        //start while loop to get data
            while($row = mysql_fetch_row($result))
            {
                $schema_insert = "";
                for($j=0; $j<mysql_num_fields($result);$j++)
                {
//                    if(!isset($row[$j]))
//                        $schema_insert .= "NULL".$sep;
//                    elseif ($row[$j] != "")
                        $schema_insert .= "$row[$j]".$sep;
//                    else
//                        $schema_insert .= "".$sep;
                }
                $schema_insert = str_replace($sep."$", "", $schema_insert);
                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                $schema_insert .= "\t";
                print(trim($schema_insert));
                print "\n";
            } 

   }else if($instState != '' && $instState != 'all' && $deptList === 'all' && $acdYear === 'all')  
    {  
       $sql = ("SELECT school_id,school_name,dept_name,scadmin_state,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    round((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0)),2) as total_on_100, 
 
   round(((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0))/10),2) as total_on_scale_10,
    
    academic_year

       FROM aicte_ind_feedback_summary_report

       WHERE scadmin_state='$instState'  group by school_id");      
       
        $result = mysql_query($sql);       

        $file_ending = "xls";
        $filename = "allStateDepartment";  
        //header info for browser
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=$filename.xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        /*******Start of Formatting for Excel*******/   
        //define separator (defines columns in excel & tabs in word)
        $sep = "\t"; //tabbed character
        //start of printing column names as names of MySQL fields
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
        echo mysql_field_name($result,$i) . "\t";
        }
        print("\n");    
        //end of printing column names  
        //start while loop to get data
            while($row = mysql_fetch_row($result))
            {
                $schema_insert = "";
                for($j=0; $j<mysql_num_fields($result);$j++)
                {
//                    if(!isset($row[$j]))
//                        $schema_insert .= "NULL".$sep;
//                    elseif ($row[$j] != "")
                        $schema_insert .= "$row[$j]".$sep;
//                    else
//                        $schema_insert .= "".$sep;
                }
                $schema_insert = str_replace($sep."$", "", $schema_insert);
                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                $schema_insert .= "\t";
                print(trim($schema_insert));
                print "\n";
            } 

   }

else if($instState != '' && $instState != 'all' && $deptList != '' && $deptList != 'all' && $acdYear === 'all')  
    {  
       $sql = ("SELECT school_id,school_name,dept_name,scadmin_state,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    round((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0)),2) as total_on_100, 
 
   round(((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0))/10),2) as total_on_scale_10,
    
    academic_year

       FROM aicte_ind_feedback_summary_report

       WHERE scadmin_state='$instState' and dept_name='$deptList' group by school_id");      
       
        $result = mysql_query($sql);       

        $file_ending = "xls";
        $filename = "allStateDepartment";  
        //header info for browser
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=$filename.xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        /*******Start of Formatting for Excel*******/   
        //define separator (defines columns in excel & tabs in word)
        $sep = "\t"; //tabbed character
        //start of printing column names as names of MySQL fields
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
        echo mysql_field_name($result,$i) . "\t";
        }
        print("\n");    
        //end of printing column names  
        //start while loop to get data
            while($row = mysql_fetch_row($result))
            {
                $schema_insert = "";
                for($j=0; $j<mysql_num_fields($result);$j++)
                {
//                    if(!isset($row[$j]))
//                        $schema_insert .= "NULL".$sep;
//                    elseif ($row[$j] != "")
                        $schema_insert .= "$row[$j]".$sep;
//                    else
//                        $schema_insert .= "".$sep;
                }
                $schema_insert = str_replace($sep."$", "", $schema_insert);
                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                $schema_insert .= "\t";
                print(trim($schema_insert));
                print "\n";
            } 

   }
else if($instState != '' && $instState != 'all' && $deptList != '' && $deptList != 'all' && $acdYear != '' && $acdYear != 'all')  
    { 
    $sql = ("SELECT school_id,school_name,dept_name,scadmin_state,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    round((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0)),2) as total_on_100, 
 
   round(((ifnull(SUM(teaching_process)/COUNT(id), 0) + ifnull(SUM(student_feedback)/COUNT(id), 0) + ifnull(SUM(dept_activity)/COUNT(id), 0) + ifnull(SUM(inst_activity)/COUNT(id), 0) + ifnull(SUM(acr)/COUNT(id), 0) + ifnull(SUM(cont_society)/COUNT(id), 0))/10),2) as total_on_scale_10,
    
    academic_year
    
    FROM aicte_ind_feedback_summary_report

    WHERE scadmin_state='$instState' and dept_name='$deptList' and academic_year='$acdYear' group by school_id");      
       
        $result = mysql_query($sql);       

        $file_ending = "xls";
        $filename = "allStateDepartment";  
        //header info for browser
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=$filename.xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        /*******Start of Formatting for Excel*******/   
        //define separator (defines columns in excel & tabs in word)
        $sep = "\t"; //tabbed character
        //start of printing column names as names of MySQL fields
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
        echo mysql_field_name($result,$i) . "\t";
        }
        print("\n");    
        //end of printing column names  
        //start while loop to get data
            while($row = mysql_fetch_row($result))
            {
                $schema_insert = "";
                for($j=0; $j<mysql_num_fields($result);$j++)
                {
//                    if(!isset($row[$j]))
//                        $schema_insert .= "NULL".$sep;
//                    elseif ($row[$j] != "")
                        $schema_insert .= "$row[$j]".$sep;
//                    else
//                        $schema_insert .= "".$sep;
                }
                $schema_insert = str_replace($sep."$", "", $schema_insert);
                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                $schema_insert .= "\t";
                print(trim($schema_insert));
                print "\n";
            } 

   }
  exit;
 
  

?>