 <?php  
    include('conn.php'); 

 /*Updated by Rutuja for solving issue SMC-5052 on 19-12-2020*/
        if(isset($_POST['dept']))
        {   
            $schoolId   = $_SESSION['school_id'];  
            
            $dept = $_POST['dept'];
             
            $query = "SELECT DISTINCT branch_Name,ExtBranchId FROM tbl_branch_master where DepartmentName = '$dept' AND school_id = '$schoolId'";

            $res = mysql_query($query);
            
            $result = mysql_num_rows($res);
            
            if($result > 0)
            {
                 echo '<option value="">Select</option>';
                 while($row = mysql_fetch_assoc($res))
                    {
                        //ExtBranchId added in dropdown value by Pranali for SMC-5006
                        $branchName = $row['branch_Name'];
                        echo '<option value="'.$branchName .",". $row["ExtBranchId"].'">'.$branchName.'</option>';
                    }  
            }
            
        }


       if(isset($_POST['branch']))
        {   
            $schoolId   = $_SESSION['school_id'];  
            
            $branch = $_POST['branch'];
             
            $query = "SELECT DISTINCT Semester_Name,Semester_Id,ExtSemesterId FROM tbl_semester_master where Branch_name = '$branch' AND school_id = '$schoolId'";

            $res = mysql_query($query);
            
            $result = mysql_num_rows($res);
            
            if($result > 0)
            {   
                 echo '<option value="">Select</option>';
                 while($row = mysql_fetch_assoc($res))
                    {
                        //ExtSemesterId added in dropdown value by Pranali for SMC-5006
                        $Semester_Name = $row['Semester_Name'];
                        $Semester_Id   = $row['Semester_Id'];
                        echo '<option value="'.$Semester_Name.','.$row["ExtSemesterId"].'">'.$Semester_Name.'</option>';
                    }  
            }
            
        }
?>
