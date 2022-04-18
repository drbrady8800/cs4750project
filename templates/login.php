<?php


/* TODO:
        [1] write function to check if session token is valid, if so, redirect to your meetings
        [2] write functions for signup and login. 
        [3] After [2] is done, edit form actions to call those functions in the controller
        [4] need to handle what happens if server rejects creditentials
        NOTE: server-side validation will be handler in controller

*/
?>

<?php
include "header.php";
?>


<?php
require('../connect-db.php');
global $db;

if(isset($_POST['login_submit'])){  
    $computing_id = !empty($_POST['computingID']) ? trim($_POST['computingID']) : null;
    $passwordComparator = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $sql = "SELECT computing_id, password FROM User WHERE computing_id = :computing_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':computing_id', $computing_id);
    $stmt->execute();
    

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user === false){
       echo '<script>alert("invalid username or password")</script>';
    } else{
         
        //validate password
        $validaty = password_verify($passwordComparator, $user['password']);
        
        if($validaty){
            
            //SESSION 
            $_SESSION['computing_id'] = $computing_id;
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();

            //location of next page
            //echo '<script>alert("Successfully Logged In")</script>';
            echo '<script>window.location.replace("index.php");</script>';
            exit;
            
        } else{
            //passwords dont match
            echo '<script>alert("invalid username or password")</script>';
        }
    }
}

elseif(isset($_POST['signup_submit'])){    
    $user = $_POST['computingID'];
    $pass = $_POST['password'];
    $fname = $_POST['first-name'];
    $lname = $_POST['last-name'];
    $email = $_POST['email'];

    $pass = password_hash($pass, PASSWORD_BCRYPT);

    //check if computingID exists
    $sql = "SELECT COUNT(computing_id) AS num FROM User WHERE computing_id = :computing_id";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':computing_id', $user);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row['num'] > 0){
        echo '<script>alert("Account with this computing ID already exists")</script>';
   }
   
    else{
        $stmt = $db->prepare("INSERT INTO `drb6pje`.`User` (`computing_id`, `first_name`, `last_name`, `email`, `password`, `temp_password`) VALUES (:computing_id, :first_name, :last_name, :email, :password, NULL)");
        $stmt->bindParam(':computing_id', $user);
        $stmt->bindParam(':first_name', $fname);
        $stmt->bindParam(':last_name', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $pass);



        try 
        {
          $stmt->execute();
          echo '<script>alert("New account successfully created")</script>';
          //redirect to login
          echo '<script>window.location.replace("login.php")</script>';
        } catch (Exception $e)       // handle any type of exception
        {
           $error_message = $e->getMessage();
           echo '<script>alert("Error: ' . $error_message . '")</script>';
        }

    }
}
?>


<section class="py-5 mt-5">
      <div class="container py-5">
        <div class="row mb-4 mb-lg-5">
          <div class="col-md-8 col-xl-6 text-center mx-auto">
            <h2 class="fw-bold">Welcome back</h2>
          </div>
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-md-6 col-xl-4">
            <div>
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <a
                    class="nav-link active"
                    role="tab"
                    data-bs-toggle="tab"
                    data-bss-disabled-mobile="true"
                    data-bss-hover-animate="pulse"
                    href="#tab-1"
                    >Login</a
                  >
                </li>
                <li class="nav-item" role="presentation">
                  <a
                    class="nav-link"
                    role="tab"
                    data-bs-toggle="tab"
                    data-bss-disabled-mobile="true"
                    data-bss-hover-animate="pulse"
                    href="#tab-2"
                    >Sign Up</a
                  >
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="tab-1">
                  <div class="card">
                    <div
                      class="card-body text-center d-flex flex-column align-items-center"
                    >
                      <div
                        class="bs-icon-xl bs-icon-circle bs-icon-primary shadow bs-icon my-4"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="1em"
                          height="1em"
                          fill="currentColor"
                          viewBox="0 0 16 16"
                          class="bi bi-person"
                        >
                          <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"
                          ></path>
                        </svg>
                      </div>
                      <form id="login-form" method="post">
                        <div class="mb-3">
                          <input
                            class="form-control"
                            type="text"
                            name="computingID"
                            placeholder="computing ID"
                            autofocus=""
                            minlength="1"
                            maxlength="7"
                            required=""
                            title="Please enter a valid UVA computing id"
                          />
                        </div>
                        <div class="mb-3">
                          <input
                            class="form-control"
                            type="password"
                            name="password"
                            placeholder="Password"
                            minlength="8"
                            maxlength="64"
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                            required=""
                          />
                        </div>
                        <div class="mb-3">
                          <button
                            class="btn btn-primary shadow d-block w-100"
                            id="login-submit"
                            name="login_submit"
                            type="submit"
                          >
                            Log in
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" role="tabpanel" id="tab-2">
                  <div class="card">
                    <div
                      class="card-body text-center d-flex flex-column align-items-center"
                    >
                      <div
                        class="bs-icon-xl bs-icon-circle bs-icon-primary shadow bs-icon my-4"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="1em"
                          height="1em"
                          fill="currentColor"
                          viewBox="0 0 16 16"
                          class="bi bi-person-plus"
                        >
                          <path
                            d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"
                          ></path>
                          <path
                            fill-rule="evenodd"
                            d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"
                          ></path>
                        </svg>
                      </div>
                      <form id="signup-form" method="post">
                        <div class="mb-3">
                          <input
                            class="form-control"
                            type="text"
                            name="first-name"
                            placeholder="First Name"
                            required=""
                            minlength="1"
                            maxlength="64"
                          />
                        </div>
                        <div class="mb-3">
                          <input
                            class="form-control"
                            type="text"
                            name="last-name"
                            placeholder="Last Name"
                            required=""
                            minlength="1"
                            maxlength="64"
                          />
                        </div>
                        <div class="mb-3">
                          <input
                            class="form-control"
                            type="email"
                            name="email"
                            placeholder="Email"
                            required=""
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                            minlength="3"
                          />
                        </div>
                        <div class="mb-3">
                          <input
                            class="form-control"
                            type="text"
                            name="computingID"
                            placeholder="computing ID"
                            required=""
                            minlength="1"
                            maxlength="7"
                          />
                        </div>
                        <div class="mb-3">
                          <input
                            class="form-control"
                            type="password"
                            name="password"
                            placeholder="Password"
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                            required=""
                            minlength="8"
                            maxlength="24"
                          />
                        </div>
                        <div class="mb-3">
                          <button
                            class="btn btn-primary shadow d-block w-100"
                            id="signup-submit"
                            name="signup_submit"
                            type="submit"
                          >
                            Sign Up
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

<?php
include "footer.php";
?>