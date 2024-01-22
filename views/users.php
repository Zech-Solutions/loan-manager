<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Users</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm" onclick="addUserModal()">
        <i class="fas fa-plus-circle fa-sm"></i> Add Record
    </a>
</div>

<div class="card shadow mb-4 border-left-success">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tbl_user" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th>#</th>
                      <th>Account Name</th>
                      <th>Username</th>
                      <th>Category</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="userModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add</h5>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="userForm">
          <input type="hidden" name="user_id" id="user_id" class="form-input">
          <div class="form-group">
            <label for="account_name">Account Name</label>
            <input type="text" class="form-control form-input" id="account_name" name="account_name" placeholder="Account Name"
              required>
          </div>
          <div class="form-group">
            <label for="user_category">Category</label>
            <select class="form-control form-input" id="user_category" name="user_category" required>
              <option value="">&mdash; Please Select &mdash;</option>
              <option value="A"> Admin </option>
              <option value="O"> Organizer </option>
              <option value="P"> Participant </option>
              <option value="J"> Judge </option>
            </select>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control form-input" id="username" name="username" placeholder="Username" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-success" form="userForm" type="submit" id="btn_submit">
            <span class="fa fa-check-circle"></span> Submit
        </button>
        <button class="btn btn-sm btn-outline-danger" data-dismiss="modal">
            <span class="fa fa-times-circle"></span> Close
        </button>
      </div>
    </div>
  </div>
</div>
<script>
  var isEdit = false, table;
  $(document).ready(function() {
    renderUser();

    $('#tbl_user tbody').on('click', '.btn-update-data', function() {
        var data = table.row($(this).closest('tr')).data();
        editModal(data);
        // You can access and use the data as needed
    });
  });
  function renderUser() {
    $("#tbl_user").DataTable().destroy();
    table = $("#tbl_user").DataTable({
      ajax: "ajax/get_user.php",
      columns: [
        { data: 'count' },
        { data: 'account_name' },
        { data: 'username' },
        {
          mRender: function(data, type, row) {
            return row.user_category == 'O' ? "Organizer" : (row.user_category == 'J' ? "Judge" : "Admin");
          }
        },
        {
          mRender: function(data, type, row) {
            var btn_delete = row.user_category == 'O' ? `<button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteEntry(${row.user_id})"><i class="fas fa-trash"></i></button>` : "";
            return `<button type="button" class="btn btn-warning btn-rounded btn-icon btn-sm btn-update-data"><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteEntry(${row.user_id})"><i class="fas fa-trash"></i></button>`;
          }
        },
      ]
    });
  }

  function addUserModal() {
    $("#userModal").modal('show');
  }

  function editModal(form_data) {
    $(".modal-title").html("Edit Entry");
    $('.form-input').each(function(index) {
      // 'this' refers to the current element in the loop
      var currentElement = $(this);
      var current_id = currentElement.attr('id');
      $(this).val(form_data[current_id]);
    });
    $("#userModal").modal('show');
  }
  function deleteEntry(user_id){
    Swal.fire({
      icon: 'question',
      title: 'Users',
      text: 'Are you sure to delete entry?',
      showCancelButton: true,
      allowOutsideClick: false
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $.post("ajax/delete_user.php", {
          user_id:user_id
        }, function(data, status) {
          if(data == 1){
            success_add("Users");
          }
          renderUser();
        });
      } else {
      }
    });
  }

  $("#userForm").submit(function(e) {
    e.preventDefault();
    var form_data = $(this).serialize();
    console.log(form_data);
    $.post("ajax/add_user.php", form_data, function(data, status) {
      if(data == 1){
        $("#user_id").val() > 0 ? success_update("Users"):  success_add("Users");
      }
      $("#userModal").modal('hide');
      renderUser();
      $("#btn_submit").prop("disabled",false).html("<span class='fa fa-check-circle'></span> Submit");
    });
  });
</script>
<style>
  .flex {
    display: flex;
  }

  .flex2 {
    justify-content: space-around;
  }

  .flex3 {
    justify-content: space-between;
  }

  .flex-items {
    text-align: center;
  }
</style>