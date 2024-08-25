<?php

namespace App\Controllers;

use App\Traits\Validation;
use Core\Controller;
use App\Models\RegisterHandle;

class RegisterController extends Controller {
  use Validation;

  function index() {
    $this->render("register");
  }

  function submit() {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $profilePicture = $_FILES['profile_picture'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];

    // sanitize
    list($firstName, $lastName, $username, $email, $dob, $mobile, $password, $passwordConfirm) = $this->sanitize([$firstName, $lastName, $username, $email, $dob, $mobile, $password, $passwordConfirm]);

    // check if empty - username, email, password
    $requiredFields = ['username', 'email', 'password'];
    $isEmpty = $this->isEmpty(['username' => $username, 'email' => $email, 'password' => $password], $requiredFields);

    if (is_array($isEmpty)) {
      return $this->render("register", ['errors' => $isEmpty, 'first_name' => $firstName, 'last_name' => $lastName, 'mobile' => $mobile, 'username' => $username, 'email' => $email]);
    }

    // validate --> first name, last name, username, email, mobile, password, password confirm 
    $validateFields = $this->validateField(['first_name' => ['data' => $firstName, 'validateMethod' => 'stringValidate', 'rules' => ['min_length' => 4, 'max_length' => 10]], 'last_name' => ['data' => $lastName, 'validateMethod' => 'stringValidate', 'rules' => ['min_length' => 4, 'max_length' => 10]], 'username' => ['data' => $username, 'validateMethod' => 'stringValidate', 'rules' => ['min_length' => 4, 'max_length' => 30]], 'email' => ['data' => $email, 'validateMethod' => 'emailValidate'], 'mobile' => ['data' => $mobile, 'validateMethod' => 'digitValidate', 'rules' => ['min_length' => 10, 'max_length' => 11]], 'password' => ['data' => $password, 'validateMethod' => 'passwordValidate', 'rules' => ['min_length' => 6, 'max_length' => 30]], 'password_confirm' => ['data' => $passwordConfirm, 'validateMethod' => 'passwordValidate', 'rules' => ['min_length' => 6, 'max_length' => 30]]]);

    if (is_array($validateFields)) {
      return $this->render("register", ['errors' => $validateFields, 'first_name' => $firstName, 'last_name' => $lastName, 'username' => $username, 'email' => $email, 'mobile' => $mobile]);
    }

    // check if password matches
    $passwordMatches = $this->passwordMatches($password, $passwordConfirm);

    if ($passwordMatches === false) {
      $errors['registerError'] = 'password did not matched, please try again';

      return $this->render("register", ['errors' => $errors, 'first_name' => $firstName, 'last_name' => $lastName, 'username' => $username, 'email' => $email, 'mobile' => $mobile]);
    }

    // validate & move profile picture
    $this->handleFileUpload($profilePicture, 'uploads/users/profilePictures/');

    // check if username, email, mobile already exist
    $exist = $this->checkAlreadyExist(['username' => $username, 'email' => $email, 'mobile' => $mobile]);
    if ($exist) {
      return $this->render("register", ['errors' => $exist, 'first_name' => $firstName, 'last_name' => $lastName, 'username' => $username, 'email' => $email, 'mobile' => $mobile]);
    }

    // register to db
    $register = new RegisterHandle();
    $register->save(['first_name' => $firstName, 'last_name' => $lastName, 'username' => $username, 'email' => $email, 'dob' => $dob, 'mobile' => (int) $mobile, 'profile_picture' => $profilePicture['name'], 'password' =>  password_hash($password, PASSWORD_BCRYPT)]);

    redirect('login');
  }
}
