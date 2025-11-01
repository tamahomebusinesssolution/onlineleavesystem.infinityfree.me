<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		$this->permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_department(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `department_list` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Department already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `department_list` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `department_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Department successfully saved.");
			else
				$this->settings->set_flashdata('success',"Department successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_department(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `department_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Department successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_designation(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `designation_list` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Designation already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `designation_list` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `designation_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Designation successfully saved.");
			else
				$this->settings->set_flashdata('success',"Designation successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_designation(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `designation_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Designation successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_position(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `position_list` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Position already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `position_list` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `position_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Position successfully saved.");
			else
				$this->settings->set_flashdata('success',"Position successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_position(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `position_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Position successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_leave_type(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `leave_types` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Leave Type already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `leave_types` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `leave_types` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Leave Type successfully saved.");
			else
				$this->settings->set_flashdata('success',"Leave Type successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_leave_type(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `leave_types` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Leave Type successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function generate_string($input, $strength = 10) {
		
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
	 
		return $random_string;
	}
	function upload_files(){
		extract($_POST);
		$data = "";
		if(empty($upload_code)){
			while(true){
				$code = $this->generate_string($this->permitted_chars);
				$chk = $this->conn->query("SELECT * FROM `uploads` where dir_code ='{$code}' ")->num_rows;
				if($chk <= 0){
					$upload_code = $code;
					$resp['upload_code'] =$upload_code;
					break;
				}
			}
		}

		if(!is_dir(base_app.'uploads/blog_uploads/'.$upload_code))
			mkdir(base_app.'uploads/blog_uploads/'.$upload_code);
		$dir = 'uploads/blog_uploads/'.$upload_code.'/';
		$images = array();
		for($i = 0;$i < count($_FILES['img']['tmp_name']); $i++){
			if(!empty($_FILES['img']['tmp_name'][$i])){
				$fname = $dir.(time()).'_'.$_FILES['img']['name'][$i];
				$f = 0;
				while(true){
					$f++;
					if(is_file(base_app.$fname)){
						$fname = $f."_".$fname;
					}else{
						break;
					}
				}
				$move = move_uploaded_file($_FILES['img']['tmp_name'][$i],base_app.$fname);
				if($move){
					$this->conn->query("INSERT INTO `uploads` (dir_code,user_id,file_path)VALUES('{$upload_code}','{$this->settings->userdata('id')}','{$fname}')");
					$this->capture_err();
					$images[] = $fname;
				}
			}
		}
		$resp['images'] = $images;
		$resp['status'] = 'success';
		return json_encode($resp);
	}
	function save_employee(){
        foreach($_POST as $k =>$v){
            $_POST[$k] = addslashes($v);
        }
        extract($_POST);// meta
        $chk = $this->conn->query("SELECT * FROM `employee_meta` where meta_field ='employee_id' and  meta_value = '{$employee_id}' ".($id>0? " and user_id!= '{$id}' " : ""))->num_rows;
        $this->capture_err();
        if($chk > 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Employee ID already exist in the database. Please review and try again.";
            return json_encode($resp);
            exit;
        }

        // users
        $chk2 = $this->conn->query("SELECT * FROM `users` where username ='{$username}' ".($id>0? " and id!= '{$id}' " : ""))->num_rows;
        $this->capture_err();
        if($chk2 > 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Username is not available. Please review and try again.";
            return json_encode($resp);
            exit;
        }
        ////////insert to users
        // $user_id = empty($id) ? $this->conn->insert_id : $id ;
        // $this->conn->query("SELECT FROM `other_leave_credits` where user_id = '{$user_id}' ");
        // $this->capture_err();
 		
        $data = "";
        foreach($_POST as $k =>$v){
            if(in_array($k,array('user_id','employee_id','firstname','lastname','middlename','username','salary','type','position_id','department_id','designation_id'))){
                if(!empty($data)) $data.=" , ";
                $data .= " `{$k}` = '{$v}' ";
            }
        }

        if(empty($id)){
            $data .= ", `password` = md5('{$employee_id}') ";
        }elseif(!empty($id)){
        	$data .= ", `password` = md5('{$employee_id}') ";
        }
        	
        if(empty($id)){
            $data .= ", `user_id` = '{$id}' ";
        }elseif(!empty($id)){
            $data .= ", `user_id` = '{$id}' ";
        }    

        if(empty($id)){
            $sql1 = "INSERT INTO `users` set {$data} ";
            // $sql2 = "INSERT INTO `other_leave_credits` set {$data} ";
            $save1 = $this->conn->query($sql1);
            // $save1 = $this->conn->query($sql1);
        }else{
            $sql1 = "UPDATE `users` set {$data} where id = '{$id}' ";
            // $sql2 = "UPDATE `other_leave_credits` set {$data} where id = '{$id}' ";
            $save1 = $this->conn->query($sql1);
            // $save2 = $this->conn->query($sql2);
        }

        // $this->capture_err();
        // if(!$save1 && !$save2){
        //     $resp['status'] = 'failed';
        //     $resp['error_sql'] = $sql1 || $sql1;
        // }
        $this->capture_err();
    	if($save1){
       	 	$resp['status'] = 'success';
        	$resp['user_id'] = $id;
        }
        // insert to others


         // insert to meta
        $user_id = empty($id) ? $this->conn->insert_id : $id ;
        $this->conn->query("DELETE FROM `employee_meta` where user_id = '{$user_id}' and meta_field not in ('leave_type_ids','leave_type_credits') ");
        $this->capture_err();
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id','avatar'))){
                if(!empty($data)) $data .=",";
                $v = addslashes($v);
                $data .= " ('{$user_id}','{$k}','{$v}') ";
            }
        }

	    if(!isset($approver)){
	        $data .= ", ('{$user_id}','approver','off') ";
	        }

	    if ($position_id == 1) {
		    if(!isset($leave_type_ids)){// spl
		    	$data .= ", ('{$user_id}','leave_type_ids','3,4') ";
		    }
		    $spl = '{"3":"0","4":"0"}';
		    if(!isset($leave_type_credits)){// no of spl
		    	$data .= ", ('{$user_id}','leave_type_credits','$spl') ";
		    }
		}elseif($position_id == 2) {
		    if(!isset($leave_type_ids)){// spl
		    	$data .= ", ('{$user_id}','leave_type_ids','1,2,3,5,6,7,16') ";
		    }
		    $spl = '{"1":"0","2":"0","3":"0","5":"0","6":"3","7":"0","16":"0"}';
		    if(!isset($leave_type_credits)){// no of spl
		    	$data .= ", ('{$user_id}','leave_type_credits','$spl') ";
		    }
		} 


    	$sql = "INSERT INTO `employee_meta` (`user_id`,`meta_field`,`meta_value`) VALUES {$data} ";
	    $save = $this->conn->query($sql);
	    $this->capture_err();
	    if($save){
    	$resp['status'] = 'success';
    	$resp['id'] = $user_id;
    	if(empty($id))
    		$this->settings->set_flashdata('success',"New User successfully saved.");
        else
            $this->settings->set_flashdata('success',"Update Details successfully updated.");
        $dir = 'uploads/';
        if(!is_dir(base_app.$dir))
            mkdir(base_app.$dir);
        if(isset($_FILES['img'])){
            if(!empty($_FILES['img']['tmp_name']) && isset($_SESSION['userdata']) && isset($_SESSION['system_info'])){
                $fname = $dir.$user_id."_user.".(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
                $move =  move_uploaded_file($_FILES['img']['tmp_name'],base_app.$fname);
                if($move){
                    $this->conn->query("UPDATE `users` set `avatar` = '{$fname}' where id ='{$user_id}' ");
                    if(!empty($avatar) && is_file(base_app.$avatar))
                        unlink(base_app.$avatar);
                }
            }
        }
    }else{
        $resp['status'] = 'failed';
        $resp['err'] = $this->conn->error."[{$sql}]";
    }
    return json_encode($resp);
}
	function reset_password(){
		extract($_POST);
		$employee_id = $this->conn->query("SELECT meta_value FROM `employee_meta` where meta_field = 'employee_id' and user_id = '{$id}'")->fetch_array()['meta_value'];
		$this->capture_err();
		$update = $this->conn->query("UPDATE `users` set `password` = md5('{$employee_id}') where id = '{$id}'");
		$this->capture_err();
		$resp['status']='success';
		$this->settings->set_flashdata('success',' User\'s password successfully updated. ');
		return json_encode($resp);
	}
	function delete_img(){
		extract($_POST);
		if(is_file(base_app.$path)){
			if(unlink(base_app.$path)){
				$del = $this->conn->query("DELETE FROM `uploads` where file_path = '{$path}'");
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_emp_leave_type(){
		extract($_POST);
		
		$leave_type_ids = array();
		$leave_type_credits = array();


		if(isset($leave_type_id) && count($leave_type_id) > 0){
			$leave_type_ids = $leave_type_id;
			foreach($leave_type_id as $k=> $v){
				$leave_type_credits[$v] = $leave_credit[$k];
			}
		}

		$this->conn->query("DELETE FROM `employee_meta` where (meta_field = 'leave_type_ids' or meta_field = 'leave_type_credits') and user_id = '{$user_id}' ");

		$leave_type_ids = implode(',',$leave_type_ids);
		$leave_type_credits = json_encode($leave_type_credits);

		$data = "('{$user_id}','leave_type_ids','{$leave_type_ids}')";
		$data .= ",('{$user_id}','leave_type_credits','{$leave_type_credits}')";

		$save = $this->conn->query("INSERT INTO `employee_meta` (`user_id`,`meta_field`,`meta_value`) Values {$data}");
		$this->capture_err();
		$resp['status'] = 'success';
		$this->settings->set_flashdata("success"," Leave Type Credits successfully updated.");
		return json_encode($resp);
	}
	function save_application(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$meta_qry = $this->conn->query("SELECT * FROM employee_meta where user_id = '{$user_id}' ");
		while($row = $meta_qry->fetch_assoc()){
			$meta[$row['meta_field']] = $row['meta_value'];
		}
		$leave_type_credits = isset($meta['leave_type_credits']) ? json_decode($meta['leave_type_credits']) : array();
		$ltc = array();
		foreach($leave_type_credits as $k=> $v){
			$ltc[$k] = $v;
		}
		$leaveDays = $leave_days;
			    	
  //////////////////////////////////////////////////////////////////// 
			$used = $this->conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM leave_applications where user_id = '{$user_id}' and `leave_type_id` = '{$leave_type_id}'  and status = 1 and date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' ")->fetch_array()['total'];
		

			$used1 = $this->conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM leave_applications where user_id = '{$user_id}' and `leave_type_id` = '{$leave_type_id}' and date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' and status = 1 ")->fetch_array()['total'];

			$used2 = $this->conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM leave_applications where user_id = '{$user_id}' and `leave_type_id` = '{$leave_type_id}'  and status = 1 ")->fetch_array()['total'];

			$current_sl = $this->conn->query("SELECT COALESCE(sum(`sl_current`),0) as total FROM  `users` where  user_id = '{$user_id}' ")->fetch_array()['total'];

			$current_vl = $this->conn->query("SELECT COALESCE(sum(`vl_current`),0) as total FROM  `users` where  user_id = '{$user_id}' ")->fetch_array()['total'];

			$total_sl = $this->conn->query("SELECT COALESCE(sum(`sl_total`),0) as total FROM  `users` where  user_id = '{$user_id}' ")->fetch_array()['total'];

			$total_vl = $this->conn->query("SELECT COALESCE(sum(`vl_total`),0) as total FROM  `users` where  user_id = '{$user_id}' ")->fetch_array()['total'];

			// $current_mfl = $this->conn->query("SELECT l.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `name`,concat(u.mfl_current) as 'mflCurrent',lt.code,lt.name as lname from `leave_credits` l inner join `users` u on l.user_id=u.id inner join `leave_types` lt on lt.id = l.leave_type_id where (date_format(l.date_start,'%Y') = '".date("Y")."' or date_format(l.date_end,'%Y') = '".date("Y")."') order by FIELD(l.status,0,1,2,3), unix_timestamp(l.date_created) desc ")->fetch_array()['mflCurrent'];

			$allowed2 = $this->conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM leave_credits where user_id = '{$user_id}' and `leave_type_id` = '{$leave_type_id}'  and status = 1 ")->fetch_array()['total'];

			$current_used = $this->conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM `leave_applications` where user_id = '{$user_id}' and status = 1 and date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' and `leave_type_id` = '{$leave_type_id}' ")->fetch_array()['total'];
            $all_expired_used = $this->conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM `leave_applications` where `leave_type_id` = 5 and user_id = '{$user_id}' and status = 1 and date_format(date_end,'%Y') < '".date('Y')."' ")->fetch_array()['total'];  

            $all_expired_coc = $this->conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM `leave_credits` where `leave_type_id` = 5 and user_id = '{$user_id}' and status = 1 and date_format(date_end,'%Y') < '".date('Y')."' ")->fetch_array()['total'];  

            $used_last_yr = $this->conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM `leave_applications` where `leave_type_id` = '{$leave_type_id}' and user_id = '{$user_id}' and status = 1 and date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];  

            $coc_last_yr = $this->conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM `leave_credits` where user_id = '{$user_id}' and status = 1 and `leave_type_id` = '{$leave_type_id}' and date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];

            $active = $this->conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$user_id}' and status = 1 and date_format(date_end,'%Y-%m-%d') > '".date('Y-m-d')."' and leave_type_id = '{$leave_type_id}' ")->fetch_array()['total'];

            // $active = $this->conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM leave_credits where user_id = '{$user_id}' and `leave_type_id` = '{$leave_type_id}' and date_format(date_end,'%Y') = '".date('Y')."' and status = 1 ")->fetch_array()['total'];

			$allowed = (isset($ltc[$leave_type_id])) ? $ltc[$leave_type_id] : 0;

  			$available =  $allowed - $used; //meta

  			$available_solo =  $allowed2 - $used1;
  			// 4 & others
  			$available2 =  $allowed2 - $used2;

  			////// vacation and mfl /////////////
  			$tl_vl_allow = $total_vl + $current_vl;
  			$tl_sl_allow = $total_sl + $current_sl;

  			if (($leave_type_id == 3 || $leave_type_id == 4 || $leave_type_id == 8 || $leave_type_id == 9 || $leave_type_id == 11 || $leave_type_id == 12 || $leave_type_id == 13 || $leave_type_id == 14 || $leave_type_id == 15 || $leave_type_id == 17 || $leave_type_id == 18) and ($leave_type_id != 1 || $leave_type_id != 2 || $leave_type_id != 5 || $leave_type_id != 6 || $leave_type_id != 7 || $leave_type_id != 10 || $leave_type_id != 16)): 
  				{
  					$available2 =  $allowed2 - $used2;
  				}
  			endif;	

  			if ($leave_type_id == 6):// meta spl
  				{
  					$available =  $allowed - $used; //meta
  				}
  			endif;	

  			if ($tl_vl_allow <= 10):
	  			{
	  				$tl_vl_allow = $total_vl + $current_vl;
	  				$current_mfl = 0;
	  			}
  			elseif ($tl_vl_allow > 10 and $tl_vl_allow <= 15):
	  			{

	  				$current_mfl = $tl_vl_allow -10;
	  				$tl_vl_allow = $tl_vl_allow - $current_mfl;
	  			}
  			elseif ($tl_vl_allow > 15):
	  			{
	  				$tl_vl_allow = $tl_vl_allow - 5;
	  				$current_mfl = 5;
	  			}
	  		endif;
	  			
  			$available_vl = $tl_vl_allow - $used2;
                        //// mfl    
            $available_mfl = $current_mfl - $used1;
            $available_sl = $tl_sl_allow - $used2;

            ///////// coc /////
            
            $coc_reserve = 0;
            if ($leave_type_id == 5 && $used_last_yr > $coc_last_yr):
             	{
                	$active = $active - ($all_expired_used - $all_expired_coc);
            }elseif ($leave_type_id == 5 && $all_expired_used > $all_expired_coc):
	            {
	                $active = $active - ($all_expired_used - $all_expired_coc);
	            }
	        endif; 

	        $all_expired =  $all_expired_coc - $all_expired_used;
            $current_available =  $active - $current_used;

            if ($leave_type_id == 5 && $current_available <= 15): 
	            {
	                $current_available =  $active - $current_used;
	            }
            elseif ($leave_type_id == 5 && $current_available > 15):  
	            {
	                $current_available = 15;
	                $coc_reserve = (floatval($active) - floatval($current_used)) - 15;
	            }
			endif; 

			if(!isset($ltc[$leave_type_id]) && $leave_type_id != 3 && $leave_type_id != 16){
				$resp['status'] = 'failed';
				$resp['msg'] = " Selected employee does not have previlege for the selected leave type.";
				return json_encode($resp);
				exit;
			}	        
			if ($leave_type_id == 1 && $leaveDays > $available_vl){	
	            $resp['status'] = 'failed';
	            $resp['msg'] = " ! Days of Leave is greated than available days of selected leave type. Available ({$available_vl}).";
	            return json_encode($resp);
	            exit;
            }
            if($leave_type_id == 2 && $leaveDays > $available_sl) {
	        	$resp['status'] = 'failed';
				$resp['msg'] = " @ Days of Leave is greated than available days of selected leave type. Available ({$available_sl}).";
					return json_encode($resp);
					exit;
	        } 
	        if($leave_type_id == 5 && $leaveDays > $current_available) {
	        	$resp['status'] = 'failed';
				$resp['msg'] = " # Days of Leave is greated than available days of selected leave type. Available ({$current_available}).";
					return json_encode($resp);
					exit;
	        } 
	        if ($all_expired > 1) {
	        	$day = 'days';
	        }else{
	        	$day = 'day';
	        }
	        if($all_expired_coc > $all_expired_used) {
	        	$resp['status'] = 'failed';
				$resp['msg'] = " You have expired COC. Please confirm before applying any leave ({$all_expired} {$day}).";
					return json_encode($resp);
					exit;
	        } 
            if ($leave_type_id == 6 && $leaveDays > $available){	
	            $resp['status'] = 'failed';
	            $resp['msg'] = " $ Days of Leave is greated than available days of selected leave type. Available ({$available}).";
	            return json_encode($resp);
	            exit;
            }	           
                
            if ($leave_type_id == 7 && $leaveDays > $available_mfl){	
	            $resp['status'] = 'failed';
	            $resp['msg'] = " % Days of Leave is greated than available days of selected leave type. Available ({$available_mfl}).";
	            return json_encode($resp);
	            exit;
            }
            if ($leave_type_id == 10 && $leaveDays > $available_solo){	
	            $resp['status'] = 'failed';
	            $resp['msg'] = " ^ Days of Leave is greated than available days of selected leave type. Available ({$available_solo}).";
	            return json_encode($resp);
	            exit;
            }
            if (($leave_type_id == 4 && $leaveDays > $available2) || ($leave_type_id == 8 && $leaveDays > $available2) || ($leave_type_id == 9 && $leaveDays > $available2) || ($leave_type_id == 11 && $leaveDays > $available2)  || ($leave_type_id == 12 && $leaveDays > $available2) || ($leave_type_id == 13 && $leaveDays > $available2) || ($leave_type_id == 14 && $leaveDays > $available2) || ($leave_type_id == 15 && $leaveDays > $available2) || ($leave_type_id == 17 && $leaveDays > $available2) || ($leave_type_id == 18 && $leaveDays > $available2)){	
	            $resp['status'] = 'failed';
	            $resp['msg'] = " & Days of Leave is greated than available days of selected leave type. Available ({$available2}).";
	            return json_encode($resp);
	            exit;
            }
			if($leaveDays == 0 && $leave_type_id != 16){
				$resp['status'] = 'failed';
				$resp['msg'] = " Leave Days do not allow zero.";
					return json_encode($resp);
					exit;
			}
			// $balance = $all_expired_coc - $all_expired_used;
			// if (empty($id) && $all_expired_coc > $all_expired_used)
			// $data .= ", `leave_type_id` = '5' ";	
   //          $data .= ", `reason` = 'Expired' ";
   //          $data .= ", `leave_days` = '{$balance}' ";	
			

		$check = $this->conn->query("SELECT * FROM `leave_applications` where (('{$date_start}' BETWEEN date(date_start) and date(date_end)) OR ('{$date_end}' BETWEEN date(date_start) and date(date_end))) and user_id = '{$user_id}' and status in (0,1) ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Leave date has conflict to other applications. Please review and try again.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `leave_applications` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `leave_applications` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Leave Application successfully saved.");
			else
				$this->settings->set_flashdata('success',"Leave Application successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_leave_application(){
		extract($_POST);

		// $del = $this->conn->query("DELETE FROM `leave_applications` where leave_type_id = 6");
		// $del1 = $this->conn->query("DELETE FROM `leave_applications` where leave_type_id = 7");
		//if($del and $del1){
		$del = $this->conn->query("DELETE FROM `leave_applications` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Leave Application successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_credit(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$meta_qry = $this->conn->query("SELECT * FROM employee_meta where user_id = '{$user_id}' ");
		while($row = $meta_qry->fetch_assoc()){
			$meta[$row['meta_field']] = $row['meta_value'];
		}
		$leave_type_credits = isset($meta['leave_type_credits']) ? json_decode($meta['leave_type_credits']) : array();
		$ltc = array();
		foreach($leave_type_credits as $k=> $v){
			$ltc[$k] = $v;
		}
		$used1 = $this->conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM leave_credits where user_id = '{$user_id}' and `leave_type_id` = '{$leave_type_id}' and status = 1 ")->fetch_array()['total'];
		$allowed1 = (isset($ltc[$leave_type_id])) ? $ltc[$leave_type_id] : 0;
		$available1 =  $allowed1 - $used1;
		
		if(!isset($ltc[$leave_type_id])){
			$resp['status'] = 'failed';
			$resp['msg'] = " Selected employee does not have previlege for the selected leave type.";
			return json_encode($resp);
			exit;
		}

		$creditDays = $credit_days;
		$dateStart = 'date_start';
		$currentDateTime = date('Y-m-d H:i:s');
		
		$allowed = $this->conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM leave_credits where user_id = '{$user_id}' and `leave_type_id` = '{$leave_type_id}' and date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' and status in (1,2) ")->fetch_array()['total'];
		
		// $allowedCredit = $allowed + $creditDays;
		$allowable = 30 - $allowed ;

		if($leave_type_id == 4 and $creditDays > $allowable) {
	        $resp['status'] = 'failed';
			$resp['msg'] = " Service Credit is greated than 30 days allowed for a Year {$allowable} only.";
				return json_encode($resp);
				exit;
		}
		if($creditDays == 0){
				$resp['status'] = 'failed';
				$resp['msg'] = " Credit Leaves do not allow zero.";
				return json_encode($resp);
				exit;
			}		


		if(empty($id)){
			$sql = "INSERT INTO `leave_credits` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `leave_credits` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Leave credit successfully saved.");
			else
				$this->settings->set_flashdata('success',"Leave credit successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}

	function delete_leave_credit(){
		extract($_POST);
		// delete all records in the database
		// $del = $this->conn->query("TRUNCATE TABLE leave_credits");

		// delete specific item in the database
		// $del = $this->conn->query("DELETE FROM `leave_credits` where leave_type_id = 1");

		$del = $this->conn->query("DELETE FROM `leave_credits` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Leave credit successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function update_leave_application(){
		extract($_POST);
		// delete all records in the database
		// $del = $this->conn->query("TRUNCATE TABLE leave_credits");

		// delete specific item in the database
		$del = $this->conn->query("DELETE FROM `leave_applications` where leave_type_id = 2");
		// $del = $this->conn->query("DELETE FROM `leave_credits` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Leave credit successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function update_status(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$sql = "UPDATE `leave_applications` set {$data} where id = '{$id}' ";
		$save = $this->conn->query($sql);
		$this->capture_err();
		$resp['status'] = 'success';
		return json_encode($resp);
	}
	function update_status_cr(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$sql = "UPDATE `leave_credits` set {$data} where id = '{$id}' ";
		$save = $this->conn->query($sql);
		$this->capture_err();
		$resp['status'] = 'success';
		return json_encode($resp);
	}
	
	function save_mfl(){
		foreach($_POST as $k =>$v){
		$_POST[$k] = addslashes($v);
		}

		$data = "";
		
		foreach($_POST as $k =>$v){
			if(in_array($k,array('user_id','beg','use','bal'))){
				if(!empty($data)) $data.=" , ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}
		//////////////////////////////////
		// if(empty($id))
		// $data .= ", `user_id` = '{$user_id}' ";

		// 	$user_id = json_decode($_POST["user_id"]);
		// 	$beg = json_decode($_POST["beg"]);
		// 	$use = json_decode($_POST["use"]);
		// 	$bal = json_decode($_POST["bal"]);

		// 	for ($i = 0; $i < count($user_id); $i++) {
		// 		if(($user_id[$i] != "")){ /*not allowing empty values and the row which has been removed.*/
		// 			$sql="INSERT INTO mfl (user_id, beg, use, bal) VALUES ('$user_id[$i]','$beg[$i]','$use[$i]','$bal[$i]')";
		// 			if (!mysqli_query($con,$sql)){
		// 				die('Error: ' . mysqli_error($con));
		// 			}
		// 		}
		// 	}
		////////////////////////////
		if(empty($id)){
			$sql = "INSERT INTO `mfl` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `mfl` set {$data} ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New mfl successfully saved.");
			else
				$this->settings->set_flashdata('success',"mfl successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function update_status_all(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$sql = "UPDATE `leave_credits` set {$data} where id = '{$id}' ";
		$save = $this->conn->query($sql);
		$this->capture_err();
		$resp['status'] = 'success';


		$leave_type_ids = array();
		$leave_type_credits = array();


		if(isset($leave_type_id) && count($leave_type_id) > 0){
			$leave_type_ids = $leave_type_id;
			foreach($leave_type_id as $k=> $v){
				$leave_type_credits[$v] = $leave_credit[$k];
			}
		}

		$this->conn->query("DELETE FROM `employee_meta` where (meta_field = 'leave_type_ids' or meta_field = 'leave_type_credits') and user_id = '{$user_id}' ");

		$leave_type_ids = implode(',',$leave_type_ids);
		$leave_type_credits = json_encode($leave_type_credits);

		$data = "('{$user_id}','leave_type_ids','{$leave_type_ids}')";
		$data .= ",('{$user_id}','leave_type_credits','{$leave_type_credits}')";

		$save1 = $this->conn->query("INSERT INTO `employee_meta` (`user_id`,`meta_field`,`meta_value`) Values {$data}");
		$this->capture_err();
		$resp['status'] = 'success';
		$this->settings->set_flashdata("success"," Leave Type Credits successfully updated.");
	}
	// function save_all_credit(){
	// 	extract($_POST);
	// 	$data = "";
	// 	// foreach($_POST as $k =>$v){
	// 	// 	if(!in_array($k,array('user_id','leave_type_id','reason','date_started','date_end','type','status','option1','options2','approved_by','leave_days','date_created','date_updated'))){
	// 	// 		$v = addslashes($v);
	// 	// 		if(!empty($data)) $data .=",";
	// 	// 		$data .= " `{$k}`='{$v}' ";
	// 	// 	}
	// 	foreach($_POST as $k =>$v){
	// 		if(!in_array($k,array('id'))){
	// 			$v = addslashes($v);
	// 			if(!empty($data)) $data .=",";
	// 			$data .= " `{$k}`='{$v}' ";
	// 		}
	// 	}
	// 	// $check = $this->conn->query("SELECT * FROM `department_list` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
	// 	// $check = $this->conn->query("SELECT * FROM `leave_credits` ")->num_rows;
	// 	// if($this->capture_err())
	// 	// 	return $this->capture_err();
	// 	// if($check > 0){
	// 	// 	$resp['status'] = 'failed';
	// 	// 	$resp['msg'] = " Department already exist.";
	// 	// 	return json_encode($resp);
	// 	// 	exit;
	// 	// }
	// 	if(empty($id)){
	// 		$sql = "INSERT INTO `leave_credits` set {$data} ";
			
	// 		$save = $this->conn->query($sql);
	// 	}else{
	// 		$sql = "UPDATE `leave_credits` set {$data}  ";
	// 		$save = $this->conn->query($sql);
	// 	}
	// 	if($save){
	// 		$resp['status'] = 'success';
	// 		if(empty($id))
	// 			$this->settings->set_flashdata('success',"New Department successfully saved.");
	// 		else
	// 			$this->settings->set_flashdata('success',"Department successfully updated.");
	// 	}else{
	// 		$resp['status'] = 'failed';
	// 		$resp['err'] = $this->conn->error."[{$sql}]";
	// 	}
	// 	return json_encode($resp);
	// }
	function save_users_other(){
		extract($_POST);
		// delete all records in the database
		// $del = $this->conn->query("TRUNCATE TABLE leave_credits");
		// $sql = "INSERT INTO `leave_credits` set {$data} ";
			
		// 	$save = $this->conn->query($sql);
		// delete specific item in the database
////////////////////copy database from one to other///////////////
		// $sql = "INSERT INTO other_leave_credits (user_id,leave_type_id,reason,date_start,date_end,type,status,option1,option2,approved_by,leave_days,date_created,date_updated) SELECT user_id,leave_type_id,reason,date_start,date_end,type,status,option1,option2,approved_by,leave_days,date_created,date_updated FROM leave_applications ";
		//////////////////////////////////////////
		// $sql = "INSERT INTO leave_credits (user_id,leave_type_id,reason,date_start,date_end,type,status,option1,option2,approved_by,leave_days,date_created,date_updated) SELECT user_id,leave_type_id,reason,date_start,date_end,type,status,option1,option2,approved_by,leave_days,date_created,date_updated FROM other_leave_credits ";

		$sql = "INSERT INTO other_leave_credits (id,user_id,employee_id,firstname,middlename,lastname,salary,username,password,avatar,last_login,type,position_id,date_added,date_updated) SELECT id,user_id,employee_id,firstname,middlename,lastname,salary,username,password,avatar,last_login,type,position_id,date_added,date_updated FROM users ";

		// $sql = $this->conn->query("INSERT INTO `leave_credits` ('user_id','leave_type_id','reason','date_started','date_end','type','status','option1','options2','approved_by','leave_days','date_created','date_updated') ");
		$save = $this->conn->query($sql);
		// $del = $this->conn->query("DELETE FROM `leave_credits` where id = '{$id}'");
		if($save){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Leave credit successfully created.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	//////////////////////////////////////////////////
	function save_other_credit(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$currentDateTime = date('Y-m-d H:i:s');
		
			
		if($date_updated > $currentDateTime){
	        $resp['status'] = 'failed';
	        $resp['msg'] = " You cannot set future date.";
	            return json_encode($resp);
	            exit;
	    } 
		if(empty($id)){
			$sql = "INSERT INTO `users` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `users` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"Successfully saved.");
			else
				$this->settings->set_flashdata('success',"Successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function save_expired_coc(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$meta_qry = $this->conn->query("SELECT * FROM employee_meta where user_id = '{$user_id}' ");
		while($row = $meta_qry->fetch_assoc()){
			$meta[$row['meta_field']] = $row['meta_value'];
		}
		$leave_type_credits = isset($meta['leave_type_credits']) ? json_decode($meta['leave_type_credits']) : array();
		$ltc = array();
		foreach($leave_type_credits as $k=> $v){
			$ltc[$k] = $v;
		}
		$leaveDays = $leave_days;

			$current_used = $this->conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM `leave_applications` where user_id = '{$user_id}' and status = 1 and date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' and `leave_type_id` = '{$leave_type_id}' ")->fetch_array()['total'];
            $all_expired_used = $this->conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM `leave_applications` where `leave_type_id` = '{$leave_type_id}' and user_id = '{$user_id}' and status = 1 and date_format(date_end,'%Y') < '".date('Y')."' ")->fetch_array()['total'];                    
            $all_expired_coc = $this->conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM `leave_credits` where user_id = '{$user_id}' and status = 1 and date_format(date_end,'%Y') < '".date('Y')."' and `leave_type_id` = '{$leave_type_id}' ")->fetch_array()['total'];
            $used_last_yr = $this->conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM `leave_applications` where `leave_type_id` = '{$leave_type_id}' and user_id = '{$user_id}' and status = 1 and date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];  

            $coc_last_yr = $this->conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM `leave_credits` where user_id = '{$user_id}' and status = 1 and `leave_type_id` = '{$leave_type_id}' and date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];

            $active = $this->conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$user_id}' and status = 1 and date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y-%m-%d') > '".date('Y-m-d')."' and leave_type_id = '{$leave_type_id}' ")->fetch_array()['total'];

            // $active = $this->conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM leave_credits where user_id = '{$user_id}' and `leave_type_id` = '{$leave_type_id}' and date_format(date_end,'%Y') = '".date('Y')."' and status = 1 ")->fetch_array()['total'];
            
             $coc_reserve = 0;
            if ($leave_type_id == 5 && $used_last_yr > $coc_last_yr): 
            	{
                	$active = $active - ($all_expired_used - $all_expired_coc);
            	}
        	elseif ($leave_type_id == 5 && $all_expired_used > $all_expired_coc): 
	            {
	                $active = $active - ($all_expired_used - $all_expired_coc);
	            }
	        endif;

            $current_available =  $active - $current_used;

            if ($leave_type_id == 5 && $current_available <= 15):
	            {
	                $current_available =  $active - $current_used;
	            }
            elseif ($leave_type_id == 5 && $current_available > 15):  
	            {
	                $current_available = 15;
	                $coc_reserve = (floatval($active) - floatval($current_used)) - 15;
	            }
            endif;

			if(!isset($ltc[$leave_type_id])){
				$resp['status'] = 'failed';
				$resp['msg'] = " Employee does not have previlege for the selected leave type.";
				return json_encode($resp);
				exit;
			}     
			// if($leave_type_id == 5 && $leaveDays > $current_available) {
	  //       	$resp['status'] = 'failed';
			// 	$resp['msg'] = " # Days of Leave is greated than available days of selected leave type. Available ({$current_available}).";
			// 		return json_encode($resp);
			// 		exit;
	  //       }
   			if($leaveDays == 0){
				$resp['status'] = 'failed';
				$resp['msg'] = " Already Confirmed, Thank you. Please click cancel";
					return json_encode($resp);
					exit;
			}

	if(empty($id)){
			$sql = "INSERT INTO `leave_applications` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `leave_applications` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"Successfully confirmed.");
			else
				$this->settings->set_flashdata('success',"Successfully confirmed..");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_other_leave_credits(){
		extract($_POST);
		// delete all records in the database
		 $del = $this->conn->query("TRUNCATE TABLE other_leave_credits");

		// delete specific item in the database
		// $del = $this->conn->query("DELETE FROM `leave_credits` where leave_type_id = 4");
		// $del = $this->conn->query("DELETE FROM `leave_credits` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Leave credit successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
}


$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_expired_coc':
		echo $Master->save_expired_coc();
	break;
	case 'save_department':
		echo $Master->save_department();
	break;
	case 'delete_department':
		echo $Master->delete_department();
	break;
	case 'save_designation':
		echo $Master->save_designation();
	break;
	case 'delete_designation':
		echo $Master->delete_designation();
	break;
	case 'save_position':
		echo $Master->save_position();
	break;
	case 'delete_position':
		echo $Master->delete_position();
	break;
	case 'save_leave_type':
		echo $Master->save_leave_type();
	break;
	case 'delete_leave_type':
		echo $Master->delete_leave_type();
	break;
	case 'upload_files':
		echo $Master->upload_files();
	break;
	case 'save_employee':
		echo $Master->save_employee();
	break;
	case 'reset_password':
		echo $Master->reset_password();
	break;
	case 'save_emp_leave_type':
		echo $Master->save_emp_leave_type();
	break;
	case 'save_application':
		echo $Master->save_application();
	break;
	case 'delete_leave_application':
		echo $Master->delete_leave_application();
	break;
	case 'save_credit':
		echo $Master->save_credit();
	break;
	case 'save_mfl':
		echo $Master->save_mfl();
	break;
	case 'delete_leave_credit':
		echo $Master->delete_leave_credit();
	break;
	case 'delete_other_leave_credits':
		echo $Master->delete_other_leave_credits();
	break;
	case 'update_status':
		echo $Master->update_status();
	break;
	case 'update_status_cr':
		echo $Master->update_status_cr();
	break;
	case 'update_status_all':
		echo $Master->update_status_all();
	break;
	case 'save_all_credit':
		echo $Master->save_all_credit();
	break;
	case 'save_other_credit':
		echo $Master->save_other_credit();
	break;
	case 'update_leave_application':
		echo $Master->update_leave_application();
	break;
	case 'delete_img':
		echo $Master->delete_img();
	break;
	default:
		// echo $sysset->index();
		break;
}