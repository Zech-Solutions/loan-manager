<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Suppliers</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm" onclick="addSupplierModal()">
        <i class="fas fa-plus-circle fa-sm"></i> Add Record
    </a>
</div>

<div class="card shadow mb-4 border-left-success">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tbl_supplier" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th>#</th>
                      <th>Supplier Name</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="supplierModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add</h5>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="addForm">
          <input type="hidden" name="supplier_id" id="supplier_id" class="form-input">
          <div class="form-group">
            <label for="supplier_name">Supplier Name</label>
            <input type="text" class="form-control form-input" id="supplier_name" name="supplier_name" placeholder="Supplier Name"
              required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-success" form="addForm" type="submit" id="btn_submit">
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

    $('#tbl_supplier tbody').on('click', '.btn-update-data', function() {
        var data = table.row($(this).closest('tr')).data();
        editModal(data);
        // You can access and use the data as needed
    });
  });
  function renderUser() {
    $("#tbl_supplier").DataTable().destroy();
    table = $("#tbl_supplier").DataTable({
      ajax: "ajax/get_suppliers.php",
      columns: [
        { data: 'count' },
        { data: 'supplier_name' },
        {
          mRender: function(data, type, row) {
            return `<button type="button" class="btn btn-warning btn-rounded btn-icon btn-sm btn-update-data"><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteEntry(${row.supplier_id})"><i class="fas fa-trash"></i></button>`;
          }
        },
      ]
    });
  }

  function addSupplierModal() {
    $("#supplierModal").modal('show');
  }

  function editModal(form_data) {
    $(".modal-title").html("Edit Entry");
    $('.form-input').each(function(index) {
      // 'this' refers to the current element in the loop
      var currentElement = $(this);
      var current_id = currentElement.attr('id');
      $(this).val(form_data[current_id]);
    });
    $("#supplierModal").modal('show');
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

  $("#addForm").submit(function(e) {
    e.preventDefault();
    var form_data = $(this).serialize();
    console.log(form_data);
    $.post("ajax/add_supplier.php", form_data, function(data, status) {
      if(data == 1){
        $("#supplier_id").val() > 0 ? success_update("Suppliers"):  success_add("Suppliers");
      }
      $("#supplierModal").modal('hide');
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