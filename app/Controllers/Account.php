<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Account extends Controller {

    public function __construct() {
        helper(['langs', 'islogedin', 'Phonecodes', 'Sendmail', 'Sendsms', 'emailBody', 'functions_zone', 'app_info']);
        $this->account_model = new \App\Models\Account_model();
        $this->comman_model = new \App\Models\Comman_model();

      $getLang = filter_var(htmlentities(\Config\Services::request()->getGet('lang'), FILTER_SANITIZE_STRING));
        if (!empty($getLang)) {
            session()->set('language', $getLang);
        } else {
            session()->set('language', "العربية");
        }

        LoadLang();
    }

    public function terms() {
      $data['page'] = "Terms";
      $data['title'] = "";
        $url = base_url("Dashboard");
        echo view('account/terms', $data);
    }

    public function login() {
        $data['google_client_id'] = $_ENV['GOOGLE_SIGNUP_PUBLIC_KEY'];
        $data['public_key'] = $_ENV['GOOGLE_CAPTCHA_PUBLIC_KEY'];
				$data['page'] = "login";
        $data['title'] = "";
        $data['token'] = bin2hex(random_bytes(32));
        session()->set('csrf_token', $data['token']);
        $url = base_url("Dashboard");
      loginRedirect($url);
         echo view('account/login', $data);
    }
    public function index() {
        $data['google_client_id'] = $_ENV['GOOGLE_SIGNUP_PUBLIC_KEY'];
        $data['public_key'] = $_ENV['GOOGLE_CAPTCHA_PUBLIC_KEY'];
        $data['page'] = "login";
        $data['title'] = "";
        $data['token'] = bin2hex(random_bytes(32));
        session()->set('csrf_token', $data['token']);
        $url = base_url("Dashboard");
      loginRedirect($url);
         echo view('account/login', $data);
    }

    public function unsubscribe() {
        // Your unsubscribe code goes here
    }

    public function Forgot_password() {
        $data['page_name'] = "";
        $data['page'] = "forget password";
        $data['title'] = "";
        $url = base_url("Dashboard");
        loginRedirect($url);
        $message = "";
        echo view('account/Forgot_password', $data);
    }

    public function doforgotpass() {
        $email = $this->request->getPost('email');

        if (empty($email)) {
            echo "<p class='alertRed'>" . langs('email_cant_null') . "</p>";
            return false;
        }

        $emExist = "SELECT email FROM signup WHERE email = '$email'";
        $fetchData = $this->comman_model->get_all_data_by_query($emExist);
        $emExistCount = count($fetchData);

        foreach ($fetchData as $postsfetch) {
            $emxv = $postsfetch['email'];
        }

        if ($emExistCount > 0) {
            if ($email != $emxv) {
                echo "<p class='alertRed'>" . langs('invalid_email_address') . "</p>";
                return false;
            }

            $emExist = "SELECT username FROM signup WHERE email ='$email'";
            $fetchData = $this->comman_model->get_all_data_by_query($emExist);

            foreach ($fetchData as $postsfetch) {
                $username = $postsfetch['username'];
            }

            $forg_id = rand(0, 9999999) + time();
            $time = time();
            $data = [
                'email' => $email,
                'numi' => $forg_id,
                'time' => $time
            ];

            $this->account_model->insert_entry("forg_pass", $data);

            $terms_mail = "Your terms mail goes here"; // Update this with your terms mail content
            $mail_body = emailBody($username, base_url('Account/forgot_verifi?veri=' . $forg_id), 'Your message here', $terms_mail);

            $result = SendEmail('Change your Alsaraf password', $email, $mail_body);

            if ($result) {
                echo 1;
            } else {
                echo "<p class='alertRed'>unexpected error email had not been sent</p>";
            }
        } else {
            echo "<p class='alertRed'>" . langs('email_not_exist') . "</p>";
        }
    }

    public function logout() {
        $myid = session()->get('id');
        $online_status = "0";

        $data = [
            'online' => $online_status,
        ];

        $where = ['id' => $myid];
        $this->comman_model->update_entry("signup", $data, $where);

        setcookie("id", "", time() - (10 * 365 * 24 * 60 * 60), "/", false, true);
        session_destroy();
        session_unset();
        $baseurl = base_url("Account/login");

        return redirect()->to($baseurl);
    }
//==================================[login_function]=====================================
public function dologin() {
    error_reporting(0);

    if (filter_var(htmlentities($this->request->getPost('csrf_token')), FILTER_SANITIZE_STRING) !== session()->get('csrf_token')) {
        echo "<p class='alertRed'>Invalid token</p>";
        return false;
    }

    $username = htmlentities($this->request->getPost('un'), ENT_QUOTES);
    $password = htmlentities($this->request->getPost('pd'), ENT_QUOTES);

    if ($username == null && $password == null) {
        echo "<p class='alertRed'>" . langs('enter_username_to_login') . "</p>";
    } elseif ($username == null) {
        echo "<p class='alertRed'>" . langs('enter_username_to_login') . "</p>";
    } elseif ($password == null) {
        echo "<p class='alertRed'>" . langs('enter_password_to_login') . "</p>";
    } else {
      $datax = $this->account_model->get_account_by_username($username);
    // Assuming you expect only one result
    $row = $datax[0];
    $rUsername = $row['username'];
    $rEmail = $row['email'];
    $rPassword = $row['Password']; // Assuming 'password' is the correct column name
    $sus = $row['sus'];


        if (NULL !==($_COOKIE['linAtt']) && $_COOKIE['linAtt'] == $username) {
            echo "<p class='alertRed'>" . langs('cannot_login_attempts') . ".</p>";
        } else {
            $email_pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
            $un_or_em = preg_match($email_pattern, $username) ? $rEmail : $rUsername;
            $is_verified = password_verify($password, $rPassword);

            if ($un_or_em != $username) {
                echo "<p class='alertRed'>" . langs('un_email_not_exist') . "!</p>";
            } elseif (!$is_verified) {
                $checkAttempts = "SELECT login_attempts FROM signup WHERE username = '$username'";
                $fetchData = $this->comman_model->get_all_data_by_query($checkAttempts);

                foreach ($fetchData as $attR) {
                    $login_attempts = $attR['login_attempts'];
                }

                if ($login_attempts < 3) {
                    $attempts = $login_attempts + 1;
                    $addAttempts = "UPDATE signup SET login_attempts ='$attempts' WHERE username='$username'";
                    $addAttempts = $this->comman_model->run_query($addAttempts);
                } elseif ($login_attempts >= 3) {
                    $attempts = 0;
                    $addAttempts = "UPDATE signup SET login_attempts ='$attempts' WHERE username='$username'";
                    $addAttempts = $this->comman_model->run_query($addAttempts);
                    setcookie("linAtt", "$username", time() + (60 * 5), '/');
                }

                $LoginTry = 3 - $login_attempts;
                echo "<p class='alertRed'>" . langs('password_incorrect_you_have') . " $LoginTry " . langs('attempts_to_login') . "</p>";
            } elseif ($sus == "1") {
                echo "<p class='alertRed'>" . langs('sus_msg') . "!</p>";
            } else {
                $query = $this->account_model->check_login($username, $rPassword);
                $num = $query->getNumRows();

                if ($num == 0) {
                    echo "<p class='alertRed'>" . langs('un_and_pwd_incorrect') . "!</p>";
                } else {
                    $attempts = "0";
                    $addAttempts = "UPDATE signup SET login_attempts ='$attempts' WHERE username='$username'";
                    $addAttempts = $this->comman_model->run_query($addAttempts);

                    session()->set('attempts', 0);
                }

                $this->GetLoginWhileFetch($query, $req);
                echo 1;
            }
        }
    }
}

function GetLoginWhileFetch($query, $req) {
    $row_fetch = $query->getRowArray();

    $fields = $this->account_model->getFieldData('signup');
    foreach ($fields as $postsfetchi) {
        ${"var" . $postsfetchi->name} = $row_fetch[$postsfetchi->name];
    }

    $online_status = "1";
    $data = [
        'online' => $online_status,
    ];
    $where = ['id' => $varid];
    $this->comman_model->update_entry("signup", $data, $where);
$ip_status = 0;
    $fetchUsers_sql = "SELECT status FROM devices WHERE user_id='$varid' AND ip='" . $this->request->getIPAddress() . "'";
    $result = $this->comman_model->get_all_data_by_query($fetchUsers_sql);
    $count_ip = count($result);

    foreach ($result as $item) {
        $ip_status = $item["status"];
    }

    if ($ip_status == 1) {
        echo "<p class='alertRed'>" . langs('sus_msg') . "</p>";
        return false;
    }

    if ($count_ip < 1) {
        $data = [
          'id' => rand(0,9999),
            'user_id' => $varid,
            'ip' => $this->request->getIPAddress(),
        ];
        $this->account_model->insert_entry("devices", $data);
    }

    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = $this->request->getIPAddress();
    $encryption = openssl_encrypt($varid, $ciphering, $encryption_key, $options, $encryption_iv);

    setcookie('id', $encryption, time() + (10 * 365 * 24 * 60 * 60), "/", false, true);

    $uisql = "SELECT * FROM settings WHERE user_id= '$varid' AND access='user'";
    $udata = $this->comman_model->get_all_data_by_query($uisql);

    foreach ($udata as $rowx) {
        $value_n = $rowx['value'];
        $type_n = $rowx['type'];
        session()->set($type_n, $value_n);
    }

    $fields = $this->account_model->getFieldData('signup');
    foreach ($fields as $postsfetchi) {
        session()->set($postsfetchi->name, ${"var" . $postsfetchi->name});
    }
}


public function register() {
    if ($_ENV['REGISTER_PAGE'] == "FALSE") {
        echo view('errors/404');
    } else {
        $public_key = $_ENV['GOOGLE_CAPTCHA_PUBLIC_KEY']; // Set your public key here
        $data['captcha']["public_key"] = $public_key;

        $data['page'] = "register";
        $data['title'] = "";

        $data['token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $data['token'];

        $url = base_url() . "Dashboard";
        loginRedirect($url);

        $phones = LoadPhoneCodes();
        $data["phones"] = $phones;
        echo view('account/register', $data);
    }
}

public function dogoogle() {
    $google_token = $this->request->getPost('google_token');
    $google_client_id = $_ENV['GOOGLE_SIGNUP_PUBLIC_KEY']; // Set your Google Client ID here
    $google_secret_id = $_ENV['GOOGLE_SIGNUP_SECRET_KEY']; // Set your Google Secret ID here

    $client = new Google_Client();
    $client->setClientId($google_client_id);
    $client->setClientSecret($google_secret_id);
    $client->setScopes(['email', 'profile']);

    $payload = $client->verifyIdToken($google_token);
    $google_id = $payload['sub'];
    $google_name = $payload['name'];
    $google_email = $payload['email'];

    $accessToken = $client->fetchAccessTokenWithAuthCode($google_token);
    $refreshToken = $accessToken['refresh_token'];
    $accessToken = $accessToken['access_token'];

    // Check if the user's Google ID is already in the database
    $userExists = $this->account_model->check_google($google_id);

    if ($userExists->num_rows() == 0) {
        // Create a new user account in the database
        $data = [
            'id' => $google_id,
            'username' => $google_name,
            'email' => $google_email,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'language' => 'العربية',
            'account_type' => 'google',
            'mode' => 'auto',
            'account_setup' => date('d/m/Y'),
            'user_email_status' => 'verified',
        ];

        $this->account_model->insert_entry("signup", $data);
    } else {
        // Update the user's access token and refresh token in the database
        $this->account_model->update_google_tokens($google_id, $accessToken, $refreshToken);
    }

    $query = $this->account_model->check_google($google_id);

    $num = $query->num_rows();
    // Set the session variables and redirect to the home page
    $this->GetLoginWhileFetch($query, 'google_sign');
    echo 1;
    exit;
}

// ============================= [ Signup code ] =============================
	public function doregister(){

//===================================[signup enteries]==========================
		if(filter_var(htmlentities($this->request->getPost('csrf_token')), FILTER_SANITIZE_STRING) !== $_SESSION['csrf_token']){
			echo"<p class='alertRed'>Invalid token</p>";
			return false;
		}
		$user_activation_code = md5(rand());
		$signup_id = (rand(0,99999).time()) + time();
		$phone_activation_code = rand(0,999999);
		$account_type = filter_var(htmlentities($this->request->getPost('account_type')),FILTER_SANITIZE_STRING);
		if($account_type == NULL){
			$account_type = "user";
		}
		$req= htmlentities($this->request->getPost('req'), ENT_QUOTES);
		$uncode = filter_var(htmlentities($this->request->getPost('phone_code')),FILTER_SANITIZE_NUMBER_INT);
		if(empty($uncode)){
			$uncode = "218";
		}
		$phone_val = filter_var(htmlentities($this->request->getPost('fn')),FILTER_SANITIZE_STRING);
		$phone_format = ltrim($phone_val, '0');
		$signup_fullname = "+".$uncode."".$phone_format;

		$signup_username = filter_var(htmlentities($this->request->getPost('un')),FILTER_SANITIZE_STRING);
		$signup_email = filter_var(htmlentities($this->request->getPost('em')),FILTER_SANITIZE_STRING);
// =========================== password hashinng ==================================
		$signup_password_var = filter_var(htmlentities($this->request->getPost('pd')),FILTER_SANITIZE_STRING);
		$options = array(
			'cost' => 12,
		);

		$signup_password = password_hash($signup_password_var, PASSWORD_BCRYPT, $options);

		$signup_cpassword = filter_var(htmlentities($this->request->getPost('cpd')),FILTER_SANITIZE_STRING);

if($_ENV['MAIN_LANGUAGE_ARABIC'] == "TRUE"){
  $signup_language = "العربية";
}else{
    $signup_language = "English";
}
		if ($req == "sign" && !isset($_SESSION['id'])) {
			//===================================[start of the reCAPTCHA]===========================
			function getData($url,$dataArray){
				$ch = curl_init();
				$data = http_build_query($dataArray);
				$getUrl = $url."?".$data;
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_URL, $getUrl);
				curl_setopt($ch, CURLOPT_TIMEOUT, 80);
				$response = curl_exec($ch);
				if(curl_error($ch)){
					return 'Request Error:' . curl_error($ch);
				}else{
					return json_decode($response,true);
				}
				curl_close($ch);
			}

			if($_ENV['CAPTCHA'] == "TRUE"){
				$urlGoogleCaptcha = 'https://www.google.com/recaptcha/api/siteverify';
				$checkkey = $_ENV['GOOGLE_CAPTCHA_SECRET_KEY'];
				$recaptchaSecretKey = $checkkey;
				$verficationResponse = $this->request->getPost('recaptchaResponses');
				$dataArray = [
					'secret'=>$recaptchaSecretKey,
					'response'=>$verficationResponse
				];
				$recaptchaResonse = getData($urlGoogleCaptcha,$dataArray);
				if(is_array($recaptchaResonse))
				{
					if($recaptchaResonse['success'] == 1)
					{}else{
						//google returns false;
						echo "<p class='alertRed'>".json_encode(['msg'=>'Google reCaptcha Error'])."</p>";
						return false;
					}
				}else{
					//issue in curl request
					echo "<p class='alertRed'>".json_encode(['msg'=>'Error with google'])."</p>";
					return false;
				}
			}

		}
		//===================================[end of the reCAPTCHA]=============================
		//===============================check username==================================
		$exist_username=$this->comman_model->get_dataCount_where("signup","username",$signup_username);

		$exist_email=$this->comman_model->get_dataCount_where("signup","email",$signup_email);
		$num_un_ex = $exist_username;
		$num_em_ex = $exist_email;

		if(($signup_fullname == null || $signup_username == null || $signup_email == null || $signup_password == null || $signup_cpassword == null) || ($signup_username == null) && $typ == "shop"){
			echo "<p class='alertRed'>".langs('please_fill_required_fields')."</p>";
			return false;
		}elseif($num_un_ex >= 1){
			echo "<p class='alertRed'>".langs('user_already_exist')."</p>";
			return false;
		}elseif($num_em_ex >= 1){
			echo "<p class='alertRed'>".langs('email_already_exist')."</p>";
			return false;
		}elseif((strlen($signup_password_var) < 6 || $signup_password_var == "qwe123()" || $signup_password_var == "Qwe123()")){
			echo "
		<ul class='alertRed' style='list-style:none;'>
		<li><b>".langs('password_not_allowed')." :</b></li>
		<li><span class='fa fa-times'></span> ".langs('signup_password_should_be_1').".</li>
		<li><span class='fa fa-times'></span> ".langs('signup_password_should_be_2').".</li>
		<li><span class='fa fa-times'></span> ".langs('signup_password_should_be_3').".</li>
		<li><span class='fa fa-times'></span> ".langs('signup_password_should_be_4').".</li>
		</ul>";
			return false;
		}elseif($signup_password_var != $signup_cpassword){
			echo "<p class='alertRed'>".langs('password_not_match_with_cpassword')."</p>";
			return false;
		}elseif((strpos($signup_username, ' ') !== false || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/', $signup_username) || !preg_match('/[A-Za-z0-9]+/', $signup_username))) {
			echo "
		<ul class='alertRed' style='list-style:none;'>
		<li><b>".langs('username_not_allowed')." :</b></li>
		<li><span class='fa fa-times'></span> ".langs('signup_username_should_be_1').".</li>
		<li><span class='fa fa-times'></span> ".langs('signup_username_should_be_2').".</li>
		<li><span class='fa fa-times'></span> ".langs('signup_username_should_be_3').".</li>
		<li><span class='fa fa-times'></span> ".langs('signup_username_should_be_4').".</li>
		<li><span class='fa fa-times'></span> ".langs('signup_username_should_be_5').".</li>
		</ul>";
			return false;
		}elseif (!filter_var($signup_email, FILTER_VALIDATE_EMAIL)) {
			echo "<p class='alertRed'>".langs('invalid_email_address')."</p>";
			return false;
		}elseif (!preg_match("/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/", $signup_email)) {
			echo "<p class='alertRed'>".langs('invalid_email_address')."</p>";
			return false;
		}elseif ((!preg_match('/[0-9]/', $signup_fullname) || strlen($signup_fullname) < 6)) {
			echo "<p class='alertRed'>".langs('invalid_phone_number')."</p>";
			return false;
		}else{
			if (($req == "admin_sign" && NULL !==($_SESSION['id'])) || $_ENV['EMAIL_VERIFICATION'] == "FALSE"){
				$verifi_now = "verified";
			}else{
				$verifi_now = "not verified";
			}

			$recordCounts=$this->comman_model->get_all_dataCounts_by_query("SELECT id FROM signup");

			$cusers_q_num_rows =$recordCounts;

			$data = array(
				'id'      => $signup_id,
				'phone'      => $signup_fullname,
				'username'      => $signup_username,
				'email'      => $signup_email,
				'Password'      => $signup_password,
				'language'      => $signup_language,
				'account_type'      => $account_type,
				'mode'      => 'auto',
				'account_setup'      => date('d/m/Y'),
				'user_activation_code'      => $user_activation_code,
				'phone_activation_code'      => $phone_activation_code,
				'user_email_status'      => $verifi_now,
			);
			$this->account_model->insert_entry("signup",$data);

if($_ENV['TRAIL_DAYS'] == "" || $_ENV['TRAIL_DAYS'] == "0"){}else{
      $next_pay = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " + ".$_ENV['TRAIL_DAYS']." day"));
      $data = array(
        'user_id' => $signup_id,
        'next_pay' => $next_pay,
			);
			$this->comman_model->insert_entry("payment",$data);
    }
		}
		//===========================================[email send]======================================================================
		if ($req == "sign" && !isset($_SESSION['id']))
		{
			if($_ENV['EMAIL_VERIFICATION'] == "TRUE"){
				$terms_mail = "يتم ارسال هده الرساله لانك سجلت في نظام الصرايتم ارسال هذه الرسالة من قبل تطبيق الصرّاف فقط لتأكيد البريد الإلكتروني ، ولا يتم طلب أي معلومات شخصية أو مالية أو بيانات الحساب بأي شكل من الأشكال ، ويتم مخاطبة المستخدم بإسم المستخدم الذي إختاره عند التسجيل فقط ، ولا يتحمل فريق الصرّاف أي مسئولية عن عدم الإنتباه لأي محاولة تلاعب بالبيانات أو احتيال قد تتم بتمثيل دور الصرّاف وإرسال رسالة إلى بريدك الإلكتروني، فرجاء الإنتباه والتأكد من إسم المستخدم الذي اخترت أنه هو المخاطب به في الرسالة";
				$mail_body = emailBody($signup_username,base_url().'Account/email_check?activation_code='.$user_activation_code,'شكرا لتسجيلك في نظام الصرّاف. للإتمام عملية فتح الحساب رجاء الضغط على الرابط التالي، أو نسخه للمتصفح ليتم تفعيل حسابك بنجاح.',$terms_mail);
			}

			//SendSms($signup_fullname,'رقم التأكيد:'.$phone_activation_code);

			$result = SendEmail('Email Verification',$signup_email,$mail_body);


			if($result){
				$message = '<label class="text-success">Register Done, Please check your mail.</label>';
			}
			// ========================== login code after signup ============================

			$query=$this->account_model->check_login($signup_username,$signup_password);
			$num = $query->getNumRows();

			$this->GetLoginWhileFetch($query,$req);

		}else{
			if($_ENV['EMAIL_VERIFICATION'] == "TRUE"){
				$terms_mail = "يتم ارسال هده الرساله لان تم تسجيلك في نظام project ارسال هذه الرسالة من قبل تطبيق الصرّاف وهده هي بيانات تسجيل الدخول.
<br> اسم المستخدم: $signup_username
<br> كلمة السر: $signup_password_var";
				$mail_body = emailBody($signup_username,'','شكرا لتسجيلك في نظام الصرّاف. للإتمام عملية فتح الحساب رجاء الضغط على الرابط التالي، أو نسخه للمتصفح ليتم تفعيل حسابك بنجاح.',$terms_mail);

			//SendSms($signup_fullname,'رقم التأكيد:'.$phone_activation_code);

			$result = SendEmail('Email Verification',$signup_email,$mail_body);
		}}
		echo 1;

	}
//==================================[forget_verification]=========================
	public function forgot_verifi(){
    $data['page'] = "Terms";
    $data['title'] = "";
		$url=base_url()."Dashboard";
		loginRedirect($url);

		ini_set('error_log', dirname(__file__) . 'error_log.txt');
// ========================= config the languages ================================
		error_reporting(E_NOTICE ^ E_ALL);
		$data['page_name']['name'] = "verify";

		$story_id = filter_var(htmlentities($_GET['veri']), FILTER_SANITIZE_NUMBER_INT);
		$data["story_id"]=$story_id;

		$fPosts_sql_sql = "SELECT * FROM forg_pass WHERE numi = '$story_id'";
		$FetchData=$this->comman_model->get_all_data_by_query($fPosts_sql_sql);
		$countSaved = count($FetchData);
		$data["countSaved"]=$countSaved;

		if($countSaved < 1){
			echo view('errors/404',$data);
		}else{
			echo view('account/forgot_verifi',$data);
		}

	}
	public function doforgot_verifi(){
		$passco = filter_var(htmlentities($this->request->getPost('passco')), FILTER_SANITIZE_STRING);
		$pd = filter_var(htmlentities($this->request->getPost('pd')), FILTER_SANITIZE_STRING);
		$cpd = filter_var(htmlentities($this->request->getPost('cpd')), FILTER_SANITIZE_STRING);

		$emExist ="SELECT email FROM forg_pass WHERE numi ='$passco'";
		$FetchData=$this->comman_model->get_all_data_by_query($emExist);
		foreach ($FetchData as $postsfetch) {
			$email = $postsfetch['email'];
		}

		if($pd == null || $cpd == null){
			echo "<p class='alertRed'>".langs('please_fill_required_fields')."</p>";
		}elseif(strlen($pd) < 6){
			echo "<p class='alertRed'>".langs('password_short').".</p>";
		}elseif($pd != $cpd){
			echo "<p class='alertRed'>".langs('password_not_match_with_cpassword')."</p>";
		}else{

			$options = array(
				'cost' => 12,
			);
			$password_var = password_hash($pd, PASSWORD_BCRYPT, $options);

			$update_info_sql = "UPDATE signup SET Password= '$password_var' WHERE email= '$email'";
			$update_info=$this->comman_model->run_query($update_info_sql);
			echo 1;

			$query=$this->account_model->check_login($email,$password_var);

			$num = $query->getNumRows();
			$this->GetLoginWhileFetch($query,'login_code');

			$loginsql = "DELETE FROM forg_pass WHERE email= '$email'";
			$IsDelete = $this->comman_model->run_query($loginsql);

			exit;
		}
	}
//==================================[phone_number_check]=========================
	public  function phone_check(){
		$code = htmlentities($this->request->getPost('cContent'), ENT_QUOTES);
		$id = $_SESSION['id'];

		$fetchUsers_sql = "UPDATE signup SET user_email_status= 'verified' WHERE phone_activation_code='$code' AND id='$id'";
		$resultx = $this->comman_model->run_query($fetchUsers_sql);

		$fetchUsers_sql = "SELECT user_email_status FROM signup WHERE id='$id' AND phone_activation_code='$code'";
		$result = $this->comman_model->get_all_data_by_query($fetchUsers_sql);

		foreach($result as $item){
			$user_email_status = $item["user_email_status"];
			$_SESSION['user_email_status'] = $user_email_status;
		}
		if($user_email_status == "verified"){
			echo"yes";
		}
	}
//========================================[email_verification]==========================
	public function Email_verification(){

		if($_SESSION['user_email_status'] == "verified"){
			header("location:".base_url()."Dashboard");
		}
    $data['page'] = "Terms";
    $data['title'] = "";

		$email_var = filter_var(htmlentities($this->request->getPost('edit_email')),FILTER_SANITIZE_STRING);
		$data["email_var"]=$email_var;
		if (NULL !==($this->request->getPost('general_save_changes'))) {

			if (empty($email_var)) {
				$data["general_save_result"] = "<p id='error_msg'>".langs('please_fill_required_fields')."</p>";
				return false;
			}

			if (!filter_var($email_var, FILTER_VALIDATE_EMAIL)) {
				$data["general_save_result"] = "<p id='error_msg'>".langs('invalid_email_address')."</p>";
				return false;
			}

			$session_un = $_SESSION['Username'];
			$emExist = "SELECT Email FROM signup WHERE Email ='$email_var'";
			$FetchedData = $this->comman_model->get_all_data_by_query($emExist);
			$emExistCount = count($FetchedData);
			if ($emExistCount > 0) {
				if ($email_var != $_SESSION['Email']) {
					$data["general_save_result"] = "<p id='error_msg'>".langs('email_already_exist')."</p>";
					return false;
				}
			}


			$update_info_sql = "UPDATE signup SET Email= '$email_var' WHERE username= '$session_un'";
			$update_info = $this->comman_model->run_query($update_info_sql);

			if (NULL !==($update_info)) {
				$_SESSION['Email'] = $email_var;
				$user_activation_code = $_SESSION['user_activation_code'];
				$terms_mail = "يتم ارسال هده الرساله لانك سجلت في نظام الصرايتم ارسال هذه الرسالة من قبل تطبيق الصرّاف فقط لتأكيد البريد الإلكتروني ، ولا يتم طلب أي معلومات شخصية أو مالية أو بيانات الحساب بأي شكل من الأشكال ، ويتم مخاطبة المستخدم بإسم المستخدم الذي إختاره عند التسجيل فقط ، ولا يتحمل فريق الصرّاف أي مسئولية عن عدم الإنتباه لأي محاولة تلاعب بالبيانات أو احتيال قد تتم بتمثيل دور الصرّاف وإرسال رسالة إلى بريدك الإلكتروني، فرجاء الإنتباه والتأكد من إسم المستخدم الذي اخترت أنه هو المخاطب به في الرسالة";
				$mail_body = emailBody($signup_username,base_url().'Account/email_check?activation_code='.$user_activation_code,'شكرا لتسجيلك في نظام الصرّاف. للإتمام عملية فتح الحساب رجاء الضغط على الرابط التالي، أو نسخه للمتصفح ليتم تفعيل حسابك بنجاح.',$terms_mail);

				//SendSms($signup_fullname,'رقم التأكيد:'.$phone_activation_code);

				$result = SendEmail('Email Verification',$signup_email,$mail_body);

				echo "<p class='success_msg'>".langs('changes_email_seccessfully')."</p>";
			} else {
				echo "<p id='error_msg'>".langs('errorSomthingWrong')."</p>";
			}

		}
		error_reporting(0);

		$email_var = filter_var(htmlentities($this->request->getPost('edit_email')),FILTER_SANITIZE_STRING);
		$phone_var = filter_var(htmlentities($this->request->getPost('edit_phone')),FILTER_SANITIZE_STRING);

		if(NULL !==($this->request->getPost('resend'))){
			$id = $_SESSION['id'];

			if (empty($email_var) || empty($phone_var)) {
				echo "<p id='error_msg'>".langs('please_fill_required_fields')."</p>";
				return false;
			}

			if (!filter_var($email_var, FILTER_VALIDATE_EMAIL)) {
				echo "<p id='error_msg'>".langs('invalid_email_address')."</p>";
				return false;
			}

			$session_un = $_SESSION['Username'];
			$emExist = "SELECT Email FROM signup WHERE Email ='$email_var' AND id!='$id'";
			$FetchedData = $this->comman_model->get_all_data_by_query($emExist);

			$emExistCount = count($FetchedData); //$emExist->rowCount();
			if ($emExistCount > 0) {
				if ($email_var != $_SESSION['Email']) {
					echo "<p id='error_msg'>".langs('email_already_exist')."</p>";
					return false;
				}
			}


			$phExist = "SELECT phone FROM signup WHERE phone ='$phone_var' AND id!='$id'";
			$FetchedData = $this->comman_model->get_all_data_by_query($phExist);

			$phExistCount = count($FetchedData); //$emExist->rowCount();
			if ($phExistCount > 0) {
				if ($phone_var != $_SESSION['phone']) {
					echo "<p id='error_msg'>".langs('invalid_phone_number')."</p>";
					return false;
				}
			}

			$update_info_sql = "UPDATE signup SET Email= '$email_var' AND phone= '$phone_var' WHERE id= '$id'";
			$update_info = $this->comman_model->run_query($update_info_sql);

			if (NULL !==($update_info)) {
				$_SESSION['Email'] = $email_var;
				$_SESSION['phone'] = $phone_var;
				$user_activation_code = $_SESSION['user_activation_code'];

				$phone_activation_code = $_SESSION['phone_activation_code'];

				//SendSms($signup_fullname,'رقم التأكيد:'.$phone_activation_code);

				$terms_mail = "يتم ارسال هده الرساله لانك سجلت في نظام الصرايتم ارسال هذه الرسالة من قبل تطبيق الصرّاف فقط لتأكيد البريد الإلكتروني ، ولا يتم طلب أي معلومات شخصية أو مالية أو بيانات الحساب بأي شكل من الأشكال ، ويتم مخاطبة المستخدم بإسم المستخدم الذي إختاره عند التسجيل فقط ، ولا يتحمل فريق الصرّاف أي مسئولية عن عدم الإنتباه لأي محاولة تلاعب بالبيانات أو احتيال قد تتم بتمثيل دور الصرّاف وإرسال رسالة إلى بريدك الإلكتروني، فرجاء الإنتباه والتأكد من إسم المستخدم الذي اخترت أنه هو المخاطب به في الرسالة";
				$mail_body = emailBody($signup_username,base_url().'Account/email_check?activation_code='.$user_activation_code,'شكرا لتسجيلك في نظام الصرّاف. للإتمام عملية فتح الحساب رجاء الضغط على الرابط التالي، أو نسخه للمتصفح ليتم تفعيل حسابك بنجاح.',$terms_mail);

				$result = SendEmail('Email Verification',$signup_email,$mail_body);

			}


		}

		$fetchUsers_sql = "SELECT user_email_status FROM signup WHERE id='$id'";
		$result = $this->comman_model->get_all_data_by_query($fetchUsers_sql);
		$array=array();
		foreach($result as $item){
			$user_email_status = $item["user_email_status"];
			$_SESSION['user_email_status'] = $user_email_status;
		}


		echo view('Account/Email_verification', $data);
	}
//==================================[email_check]=========================
	public  function email_check(){

		$activation_code_url = $_GET['activation_code'];
		if(NULL !==($_GET['activation_code'])) {

			$activationCode=$_GET['activation_code'];
			$query = " SELECT * FROM signup WHERE user_activation_code = '$activationCode' ";
			$FetchData=$this->comman_model->get_all_data_by_query($query);
			$no_of_row =count($FetchData);
			if($no_of_row > 0){

				$result = $FetchData;
				foreach($result as $row)
				{
					if($row['user_email_status'] == 'not verified'){
						$update_query = "
	UPDATE signup SET user_email_status = 'verified' WHERE user_activation_code = '$activation_code_url'";
						$statement=$this->comman_model->run_query($update_query);
						if(NULL !==($statement)){
							$url=base_url()."Dashboard";
							header("location: $url");
							$_SESSION['user_email_status'] = "verified";
						}
					}else{
						$url=base_url()."Dashboard";
						header("location: $url");
						$_SESSION['user_email_status'] = "verified";

					}
				}

			}else{
				echo '<label class="text-danger">Invalid Link</label>';
			}

		}
	}
}
