<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Loans</h1>
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
                      <th>Supplier</th>
                      <th>Loan Date</th>
                      <th>Loan Amount</th>
                      <th>Paid Amount</th>
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
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add Loan</h5>
      </div>
      <div class="modal-body">
        <div class="row col-md-12">
          <div class="col-md-5">
            <form class="forms-sample" id="addForm">
              <input type="hidden" name="loan_id" id="loan_id" class="form-input">
              <div class="form-group">
                <label for="supplier_id">Supplier</label>
                <select class="form-control form-input" id="supplier_id" name="supplier_id" required>
                </select>
              </div>
              <div class="col-md-12">
                <div class="form-group col-md-6">
                  <label for="loan_amount">Loan Amount</label>
                  <input type="number" step="0.01" class="form-control form-input" id="loan_amount" name="loan_amount" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="interest_rate">Interest Rate</label>
                  <input type="number" step="0.01" class="form-control form-input" id="interest_rate" name="interest_rate" required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group col-md-6">
                  <label for="frequency">Frequency</label>
                  <input type="number" class="form-control form-input" id="frequency" name="frequency" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="loan_period">Loan Period</label>
                  <input type="number" class="form-control form-input" id="loan_period" name="loan_period" required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group col-md-6">
                  <label for="loan_date">Loan Date</label>
                  <input type="date" class="form-control form-input" id="loan_date" name="loan_date" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="payment_start">Payment Start</label>
                  <input type="date" class="form-control form-input" id="payment_start" name="payment_start" required>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-7" style="max-height: 400px;overflow:auto;">
              <div class="table-responsive">
                <table class="table table-bordered" id="tblLoanDetails" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th>Salary Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
              </div>
          </div>
        </div>
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
  var isEdit = false, table, form_loans = [];
  $(document).ready(function() {
    renderUser();
    renderSelectSuppliers();

    $('#tbl_supplier tbody').on('click', '.btn-update-data', function() {
        var data = table.row($(this).closest('tr')).data();
        editModal(data);
        // You can access and use the data as needed
    });
  });
  function renderSelectSuppliers(){
    $("#supplier_id").html("<option value=''> Please Select </option>");
    $.post("ajax/get_suppliers.php",{},function(data,status){
        var res = JSON.parse(data);
        console.log(res.data);
        for (let supplierIndex = 0; supplierIndex < res.data.length; supplierIndex++) {
          const supplier_row = res.data[supplierIndex];
          $("#supplier_id").append(`<option value='${supplier_row.supplier_id}'>${supplier_row.supplier_name}</option>`);
        }
    });
  }
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
    $.post("ajax/generate_loans.php", form_data, function(data, status) {
      var res = JSON.parse(data);
      console.log(res.data);
      form_loans = res.data;
      var ammortizations = res.data.ammortizations;
      var tbody_tr = "";
      for (let ammortIndex = 0; ammortIndex < ammortizations.length; ammortIndex++) {
          const ammortRow = ammortizations[ammortIndex];
          // participant_ids.push(ammortRow.participant_id);
          tbody_tr += `<tr>
              <td>${ammortIndex+1}</td>
              <td>${ammortRow.loan_detail_name}</td>
              <td>
                <input type='number' class='form-control' data-field='amount' data-index='${ammortIndex}' step='0.01' value='${ammortRow.amount.toFixed(2)}' onchange='changeLoanDetails(this)'>
              </td>
              <td>
                <input type='date' class='form-control' data-field='due_date' data-index='${ammortIndex}' value='${ammortRow.due_date}' onchange='changeLoanDetails(this)'>
              </td>
              <td>
                <input type='date' class='form-control' data-field='salary_date' data-index='${ammortIndex}' value='${ammortRow.salary_date}' onchange='changeLoanDetails(this)'>
              </td>
          </tr>`;
      }
      $("#tblLoanDetails tbody").html(tbody_tr);
      // $("#btn_submit").prop("disabled",false).html("<span class='fa fa-check-circle'></span> Submit");
    });
  });

  function changeLoanDetails(el){
    var column_name = el.getAttribute("data-field");
    var ammort_index = el.getAttribute("data-index");
    // console.log(form_loans.ammortizations[ammort_index][column_name]);
    form_loans.ammortizations[ammort_index][column_name] = $(el).val();
    // alert(column_name);
  }
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