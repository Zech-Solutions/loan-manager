<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profile</h1>
</div>
<!-- Content Row -->
<div class="row">
    <div class="col-xl-4">
        <!-- Profile picture card-->
        <div class="card mb-4 mb-xl-0">
            <div class="card-header">Profile Picture</div>
            <div class="card-body text-center">
                <!-- Profile picture label for file input -->
                <label for="profile-image" style="cursor: pointer">
                    <!-- Profile picture image -->
                    <img id="image-preview" class="img-account-profile rounded-circle mb-2" src="assets/img/profiles/<?=$_SESSION['etally']['user_img']?>" alt="" style="width: 200px; height: 200px;object-fit:cover;">
                    <!-- Profile picture help block -->
                    <div class="small font-italic text-muted mb-4">Click profile picture to change a new one.</div>
                </label>
                <!-- Hidden input element for file upload -->
                <input type="file" id="profile-image" style="display: none" accept="image/jpeg, image/png" onchange="previewImage(event)">
                <!-- Profile picture upload button -->
                <button class="btn btn-outline-success btn-sm" type="button" onclick="changeProfile()">
                    <span class="fa fa-upload"></span> Change Profile
                </button>
            </div>

        </div>
    </div>
    <div class="col-xl-8">
        <!-- Account details card-->
        <div class="card mb-4">
            <div class="card-header">Account Details</div>
            <div class="card-body">
                <form id="frm_account">
                    <!-- Form Group (username)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="inputUsername">Username</label>
                        <input class="form-control" name="username" id="inputUsername" type="text" placeholder="Enter your username" value="<?=$_SESSION['etally']['username']?>">
                    </div>
                    <!-- Form Row-->
                    <div class="row gx-3 mb-3">
                        <!-- Form Group (first name)-->
                        <div class="col-md-12">
                            <label class="small mb-1" for="inputFirstName">Account name</label>
                            <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" name="account_name" value="<?=$_SESSION['etally']['account_name']?>">
                        </div>
                    </div>
                    <!-- Save changes button-->
                    <button class="btn btn-sm btn-outline-primary" type="submit"><span class="fa fa-check-circle"></span> Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const imagePreview = document.getElementById('image-preview');
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function changeProfile(){
        const file = $("#profile-image")[0].files[0];
        console.log(file);
        const formData = new FormData();
        formData.append('image', file);
        $.ajax({
            url: 'ajax/change_profile.php', // Change to the path of your PHP file
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Handle the response from the server, if needed
                if(response == 1){
                    swal_success("Profile Picture","Successfully change profile picture");
                }else if(response == -1){
                    swal_warning("Profile Picture","Picture is too big.");
                }else{
                    swal_error("Profile Picture","Error occur while changing profile picture");
                }
            },
            error: function () {
                console.error('File upload failed');
            }
        });
    }
    $("#frm_account").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'ajax/change_account_details.php', // Change to the path of your PHP file
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                // Handle the response from the server, if needed
                if(response == 1){
                    swal_success("Account","Successfully change account details");
                }else{
                    swal_error("Account","Error occur while updating account");
                }
            },
            error: function () {
                swal_error("Account","Error occur while updating account");
            }
        });
    });
</script>