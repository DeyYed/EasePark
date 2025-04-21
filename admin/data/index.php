<?php
session_start();
require('../connection.php');
if (!isset($_SESSION["logined"])) {
  header("Location: ../");
}

if (empty($_SESSION['form_token'])) {
  $_SESSION['form_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rfid Account</title>
  <link rel="icon" href="../parkingstatus/image/favicon.ico" type="image/x-icon"> 
  <link rel="stylesheet" href="../css/rfid_account.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="sweetalert2.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

</html>

<body>
  <div class="header">
    <div class="logo-container">
      <img class="cyberpark-logo" src="image/logo1.png">
    </div>
    <div class="name-edit-container">
      <div class="website-name">
        <p>EasePark</p>
      </div>
    </div>
  </div>
  <div></div>
  <div class="left-dashboard">
    <div class="son-left-dashboard">
      <a class="cta" href="../dashboard/"><span>
            <image class="icon1" src="icons/dashboard.png"></image>Dashboard
          </span></a>
      <a class="cta" href="../data/"><span>
          <image class="icon" src="icons/rfid.png"></image>RFID Account
        </span></a>
      <a class="cta" href="../parkingstatus/"><span>
          <image class="icon" src="icons/parkingstats.png"></image>Parking Status
        </span></a>
      <a class="cta" href="../parkinglogs/"><span>
          <image class="icon" src="icons/parkinglogs.png"></image>Parking Logs
        </span></a>
    </div>
    <div class="son-profile">
      <img class="profile-icon" src="icons/Profile.png">
      <button class="edit-button js-edit-button">
        <p><?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : "Email not set"; ?></p>
      </button>
      <div class="logout-container">
        <button id="logoutBtn">
          <img class="logout-icon" src="image/logout.png" alt="Logout">
        </button>
        <button class="button-logout" id="logoutBtnAlt">Logout</button>
        <form id="logoutForm" action="../logout.php" method="POST" style="display: none;">
          <input type="hidden" name="logout" value="1">
        </form>
      </div>
    </div>
  </div>

  <div class="middle">
    <div class="rfid-account-table">
      <div class="header-table">
        <p class="header-title">Membership Account</p>
        <div id="total-users">Total Users Found: 0</div>
        <div class="search-container">
          <a href="../data/"><button class="back-button js-search-button">Back</button></a>
          <form id="searchForm" class="form" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <button type="submit" name="submitSearch">
              <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </button>
            <input id="searchInput" class="input" name="search" placeholder="Search" required type="text">
            <button class="reset" type="reset">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </form>
        </div>
        <div>
          <button class="register-button js-register-button">Register New</button>
        </div>
      </div>
      <div class="modal js-modal">
        <div class="header-modal">Register New</div>
        <div class="modal-content">
          <div class="modal-container">
            <form class="jsRegistrationform" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
              <table>
                <tr>
                  <td align="right" class="form-group">
                    <label for="first">UID</label>
                  </td>
                  <td>
                    <input type="text" id="uid" name="uid" placeholder="UID" required readonly />
                  </td>
                </tr>
                <tr>
                  <td align="right" class="form-group">
                    <label for="last">Email</label>
                  </td>
                  <td>
                    <input type="email" name="email" placeholder="Email" required />
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <input type="hidden" name="form_token" value="<?= $_SESSION['form_token']; ?>">
                    <div class="align">
                      <input class="register-new-submit" type="submit" name="registersubmit" value="Register" />
                      <button type="button" class="cancel-button js-cancel">Cancel</button>
                    </div>
                  </td>
                </tr>
              </table>
            </form>
          </div>
        </div>
      </div>


      <table class="data-table">
        <thead>
          <tr>
          </tr>
        </thead>
        <tbody>
          <!-- Table rows will be inserted here dynamically -->
        </tbody>
      </table>
    </div>
  </div>
  <div class="bottom"></div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
  // Select the edit button
  const editButton = document.querySelector('.js-edit-button');

  // Add a click event listener
  if (editButton) {
    editButton.addEventListener('click', () => {
      Swal.fire({
        title: "Are you sure?",
        text: "Do you want to change your email?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, go to settings!",
        cancelButtonText: "Cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          // Redirect to edit settings page
          window.location.href = "../editsettings/";
        }
      });
    });
  }

  let isSearchActive = false; // Flag to check if search is active

  function fetchUsers(searchValue = '') {
    $.ajax({
        url: '../fetch_users.php',
        type: 'POST',
        data: {
            search: searchValue
        },
        dataType: 'json',
        success: function(response) {
            const { total, data } = response; // Destructure the response
            let rows = '';
            data.forEach((row, index) => {
                const rowClass = index % 2 !== 0 ? 'table-row' : 'table-normal';
                rows += `
                    <tr class='${rowClass} js-table-row' data-user-id='${row.user_id}'>
                        <td class='reg-date js-fname-${row.user_id}'>${row.first_name}</td>
                        <td class='reg-date js-lname-${row.user_id}'>${row.last_name}</td>
                        <td class='reg-date js-uid-${row.user_id}'>${row.rfid_uid}</td>
                        <td class='reg-date js-platenumber-${row.user_id}'>${row.plate_number}</td> 
                        <td class='reg-date js-status-${row.user_id}'>${row.status}
                        <div class='container-button'>
                          <button class='edit-image-button-row js-status-button' data-user-id='${row.user_id}'>
                            <img class='edit-image' src='icons/block.png'>
                          </button>
                        </div>
                        </td>
                        <td class='reg-date js-reg-${row.user_id}'>${row.reg_date}
                        <div class='container-button js-edit-button-${row.user_id}'>
                          <button class='edit-image-button-row' onclick='edit(${row.user_id})'>
                            <img class='edit-image' src='icons/edit.png'>
                          </button>
                        </div>
                        <div class='container-button'>
                          <button class='edit-image-button-row js-delete-button' data-user-id='${row.user_id}'>
                            <img class='edit-image' src='icons/delete.png'>
                          </button>
                        </div>
                        </td>
                    </tr>`;
            });

            $('.data-table tbody').html(`
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>UID</th>
                    <th>PlateNumber</th>
                    <th>Status</th>
                    <th>Register Date</th>
                </tr>` + rows);

            // Display the total number of users found
            $('#total-users').text(`Total Users Found: ${total}`); // Ensure there's an element with this ID
        }
    });
}


  // Fetch data on page load
  $(document).ready(function() {
    fetchUsers(); // Initial load

    // Handle search form submission
    $('#searchForm').on('submit', function(e) {
      e.preventDefault();
      const searchValue = $('#searchInput').val();
      isSearchActive = true; // Set search flag
      fetchUsers(searchValue);
    });

    // Handle search reset
    $('#searchForm').on('reset', function() {
      isSearchActive = false; // Clear search flag
      fetchUsers(); // Load default data
    });

    // Optional: Fetch data periodically
    setInterval(() => {
      if (!isSearchActive) { // Only fetch live updates if not searching
        fetchUsers();
      }
    }, 10000); // Every 10 seconds
  });

  function deleteUIDFile() {
    fetch('../../admin/rfid/data_delete_uid.php')
      .then(response => response.text())
      .then(data => console.log(data))
      .catch(error => console.error('Error deleting UID file:', error));
  }

  // Attach the function to the Cancel button click event
  document.querySelector('.js-cancel').addEventListener('click', function() {
    const modal = document.querySelector('.js-modal');
    modal.style.display = 'none';

    deleteUIDFile();
  });

  // Attach the function to the beforeunload event
  window.addEventListener('beforeunload', function(event) {
    deleteUIDFile();
  });

 function edit(data) {
    let fnameCell = document.querySelector(`.js-fname-${data}`);
    let lnameCell = document.querySelector(`.js-lname-${data}`);
    let uidCell = document.querySelector(`.js-uid-${data}`);
    let plateCell = document.querySelector(`.js-platenumber-${data}`);


    let editButton = document.querySelector(`.js-edit-button-${data}`);

    fnameCell.innerHTML = `<input type="text" class="edit-input" value="${fnameCell.textContent.trim()}">`;
    lnameCell.innerHTML = `<input type="text" class="edit-input" value="${lnameCell.textContent.trim()}">`;
    uidCell.innerHTML = `<input type="text" class="edit-input" value="${uidCell.textContent.trim()}">`;
    plateCell.innerHTML = `<input type="text" class="edit-input" value="${plateCell.textContent.trim()}">`;


    editButton.innerHTML = '<button onclick="save(' + data + ')">Save</button>';
  }
  function save(data) {
    // Select the input fields
    let fnameInput = document.querySelector(`.js-fname-${data} input`);
    let lnameInput = document.querySelector(`.js-lname-${data} input`);
    let uidInput = document.querySelector(`.js-uid-${data} input`);
    let plateInput = document.querySelector(`.js-platenumber-${data} input`);

    // Get the new values from input fields
    let newFname = fnameInput.value.trim();
    let newLname = lnameInput.value.trim();
    let newUid = uidInput.value.trim();
    let newPlate = plateInput.value.trim();

    // Simple validation for empty fields
    if (!newFname || !newLname || !newUid || !newPlate) {
        Swal.fire({
            title: 'Error',
            text: 'All fields must be filled out.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return; // Exit function if any field is empty
    }

    // Disable the edit button temporarily to prevent multiple submissions
    let editButton = document.querySelector(`.js-edit-button-${data}`);
    editButton.innerHTML = '<button disabled>Saving...</button>';

    // Send the data via a POST request
    fetch('../save_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `user_id=${data}&fname=${encodeURIComponent(newFname)}&lname=${encodeURIComponent(newLname)}&uid=${encodeURIComponent(newUid)}&plate=${encodeURIComponent(newPlate)}`
    })
    .then(response => response.json())
.then(result => {
    if (result.success) {
        Swal.fire({
            title: 'Success',
            text: result.message,
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            // Update the table cells with the new values after success
            document.querySelector(`.js-fname-${data}`).innerHTML = newFname;
            document.querySelector(`.js-lname-${data}`).innerHTML = newLname;
            document.querySelector(`.js-uid-${data}`).innerHTML = newUid;
            document.querySelector(`.js-platenumber-${data}`).innerHTML = newPlate;

            // Change the button back to "Edit"
            editButton.innerHTML = '<button class="edit-image-button" onclick="edit(' + data + ')"><img class="edit-image" src="icons/edit.png"></button>';
        });
    } else {
        // Show error message if update failed
        Swal.fire({
            title: 'Error',
            text: result.message,
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            // Refresh the page on error
            location.reload();
        });

        // Re-enable the button in case of failure
        editButton.innerHTML = '<button class="edit-image-button" onclick="edit(' + data + ')"><img class="edit-image" src="icons/edit.png"></button>';
    }
})
.catch(error => {
    console.error('Error:', error);
    Swal.fire({
        title: 'Error',
        text: 'An unexpected error occurred.',
        icon: 'error',
        confirmButtonText: 'OK'
    }).then(() => {
        // Refresh the page on error
        location.reload();
    });

    // Re-enable the button in case of failure
    editButton.innerHTML = '<button class="edit-image-button" onclick="edit(' + data + ')"><img class="edit-image" src="icons/edit.png"></button>';
  });
}

  function fetchData() {

  }

  document.querySelector('.data-table tbody').addEventListener('click', (event) => {
    if (event.target.closest('.js-delete-button')) {
      const button = event.target.closest('.js-delete-button');
      const userId = button.dataset.userId;

      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        customClass: {
          container: 'swal-bg',
        }
      }).then((result) => {
        if (result.isConfirmed) {
          fetch('../delete_user.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
              },
              body: `userId=${userId}`
            })
            .then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                // Remove deleted row from table
                const trToDelete = document.querySelector(`tr[data-user-id="${userId}"]`);
                if (trToDelete) {
                  trToDelete.remove();
                }

                Swal.fire({
                  title: "Deleted!",
                  text: "User has been deleted.",
                  icon: "success"
                });
              } else {
                Swal.fire({
                  title: "Error!",
                  text: data.message || "Failed to delete user.",
                  icon: "error"
                });
              }
            })
            .catch(error => {
              console.error('Error deleting user:', error);
              Swal.fire({
                title: "Error!",
                text: "Failed to delete user.",
                icon: "error"
              });
            });
        }
      });
    }
  });

  document.querySelector('.data-table tbody').addEventListener('click', (event) => {
  if (event.target.closest('.js-status-button')) {
    const button = event.target.closest('.js-status-button');
    const userId = button.dataset.userId;

    // Fetch current status from the server
    fetch(`../get_user_status.php?userId=${userId}`)
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          const isBlocked = data.is_active === 0; // Check if the user is blocked

          const actionText = isBlocked ? "Unblock" : "Block";
          const confirmationText = `Are you sure you want to ${actionText} this user?`;

          Swal.fire({
            title: `Are you sure?`,
            text: confirmationText,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: `Yes, ${actionText} it!`,
            customClass: {
              container: 'swal-bg',
            }
          }).then((result) => {
            if (result.isConfirmed) {
              // Proceed to toggle the status
              fetch('../block_user.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `userId=${userId}`
              })
              .then(response => response.json())
              .then(data => {
                if (data.status === 'success') {
                  // Update the status cell in the table
                  const statusCell = document.querySelector(`.js-status-${userId}`);
                  statusCell.textContent = isBlocked ? 'Active' : 'Blocked'; // Update text based on new status

                  Swal.fire({
                    title: `${actionText.charAt(0).toUpperCase() + actionText.slice(1)}`,
                    text: `User has been ${actionText}`,
                    icon: "success"
                  });
                } else {
                  Swal.fire({
                    title: "Error!",
                    text: data.message || "Failed to toggle user status.",
                    icon: "error"
                  });
                }
              })
              .catch(error => {
                console.error('Error toggling user status:', error);
                Swal.fire({
                  title: "Error!",
                  text: "Failed to toggle user status.",
                  icon: "error"
                });
              });
            }
          });
        } else {
          Swal.fire({
            title: "Error!",
            text: data.message || "Failed to retrieve user status.",
            icon: "error"
          });
        }
      })
      .catch(error => {
        console.error('Error fetching user status:', error);
        Swal.fire({
          title: "Error!",
          text: "Failed to fetch user status.",
          icon: "error"
        });
      });
  }
});

</script>

<script>
  document.querySelector('.js-register-button').addEventListener('click', function() {
    const modal = document.querySelector('.js-modal');
    modal.style.display = 'block';

    const emailInput = document.querySelector('input[name="email"]');
    emailInput.value = '';
    
    // Fetch UID every second
    setInterval(function() {
      fetch('../../admin/rfid/data_get_uid.php')
        .then(response => response.text())
        .then(data => {
          console.log(data); // Debug the response
          document.getElementById('uid').value = data;
        })
        .catch(error => console.error('Error fetching UID:', error)); // Add error handling
    }, 1000);
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const logoutButtons = document.querySelectorAll('#logoutBtn, #logoutBtnAlt');

    logoutButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action of the button

        Swal.fire({
          title: 'Are you sure?',
          text: "You will be logged out!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, logout!',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            // Create a FormData object from the form
            const formData = new FormData(document.getElementById('logoutForm'));

            fetch('../logout.php', {
              method: 'POST',
              body: formData
            }).then(response => response.json()).then(data => {
              if (data.status === 'success') {
                window.location.href = '../'; // Redirect after successful logout
              } else {
                Swal.fire('Error', 'Logout failed', 'error');
              }
            }).catch(error => {
              Swal.fire('Error', 'Logout failed', 'error');
            });
          }
        });
      });
    });
  });
</script>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

function generateNumber()
{
  return random_int(100000, 999999);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Check if the token is set and valid
  if (
    isset($_SESSION['form_token']) && isset($_POST['form_token']) &&
    hash_equals($_SESSION['form_token'], $_POST['form_token'])
  ) {

    // Check if 'email' and 'uid' are provided
    if (empty($_POST['email']) || empty($_POST['uid'])) {
      echo '<script>
        Swal.fire({
          title: "Error!",
          text: "Email and UID are required.",
          icon: "error",
          timer: 2000,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading();
          },
          willClose: () => {
            window.history.back();
          }
        });
      </script>';
      exit;  // Stop further execution if email or uid is empty
    }

    if (isset($_POST['registersubmit'])) {
      $verificationCode = generateNumber();
      $sql = "SELECT * from verification_number where verify_number = ?";;
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$verificationCode]);

      $existingCode = $stmt->fetchAll();
      if ($existingCode) {
        $verificationCode = generateNumber();
      } else {
        $is_used = false;
        $sql = "INSERT INTO verification_number(verify_number, is_used)VALUES(?,?)";;
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$verificationCode, $is_used]);

        $email = $_POST['email'];
        $uid = $_POST['uid'];

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'easeparksolutions@gmail.com';
        $mail->Password = 'fkgw ghsy nask myrr';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('facethereality01@gmail.com');
        $mail->addAddress($email);

        $mail->isHTML(true);

        $subject = "Registration Link";

        $message = "
    <div style='font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; background-color: #fff;'>
        <div style='background-color: rgb(0, 13, 24); color: #fff; padding: 20px; text-align: center;'>
            <img src='https://easepark.online/admin/data/image/test.png' alt='EasePark' style='width: 50px; height: 50px; vertical-align: middle;'>
            <div style='margin-top: 10px;'>
                <span style='font-size: 24px; font-weight: bold;'>EasePark</span>
            </div>
        </div>
        
        <div style='padding: 20px; background-color: #f9f9f9;'>
            <p style='color: #000;'>Dear User,</p>
            <p style='color: #000;'>This is your verification code for the registration link below:</p>
            <p><strong>Verification Code: {$verificationCode}</strong></p>
            <p><strong>Your UID:</strong> <strong>{$uid}</strong></p>
            
            <p style='text-align: center; margin-top: 20px;'>
                <a href='http://easepark.online/register' style='display: inline-block; padding: 10px 20px; background-color: rgb(0, 13, 24); color: #fff; text-decoration: none; border-radius: 5px; transition: background-color 0.3s ease;'>
                    Click to Register
                </a>
            </p>
        </div>
        
        <div style='background-color: rgb(0, 13, 24); color: #fff; padding: 10px; text-align: center;'>
            <p>&copy; " . date('Y') . " EasePark. All rights reserved.</p>
        </div>
    </div>
";

        $mail->Subject = $subject;
        $mail->Body = $message;

        if ($mail->send()) {
          echo '<script>
                  Swal.fire({
                    title: "Mail Sent Successfully!",
                    text: "Your message has been sent.",
                    icon: "success",
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                      Swal.showLoading();
                    },
                    willClose: () => {
                      window.history.back();
                    }
                  })
                  </script>';
        } else {
          echo "Sent failed";
        }
      }
    }
    unset($_SESSION['form_token']);
  } else {
    echo '<script>
      Swal.fire({
          title: "Mail Sent Fail!",
          text: "Invalid form of Submission or possible CSRF attack.",
          icon: "error",
          timer: 2000,
          timerProgressBar: true,
          didOpen: () => {
              Swal.showLoading();
          },
          willClose: () => {
            window.history.back();
          }
      });
      </script>';
  }
}
?>