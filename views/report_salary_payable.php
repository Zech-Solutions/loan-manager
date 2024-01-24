<div class="row">
    <div class="card shadow mt-4 col border-left-success">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 d-sm-flex align-items-center justify-content-between mb-4">
                    <select name="judge_name" id="salary_date_select" class="form-control" onchange="renderLoanBySalaryData()">
                        <option value="0"> — Please Select Salary Date — </option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tblLoanDetails" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Loan</th>
                            <th>Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>Due Date</th>
                            <th>Salary Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
  $(document).ready(function() {
    renderSelectSalaryDate();
  });

  function renderSelectSalaryDate(){
    $("#salary_date_select").html("<option value=''> Please Select </option>");
    $.post("ajax/get_salary_dates.php",{},function(data,status){
        var res = JSON.parse(data);
        console.log(res.data);
        for (let index = 0; index < res.data.length; index++) {
          const row = res.data[index];
          $("#salary_date_select").append(`<option value='${row.salary_date}'>${row.salary_date_format}</option>`);
        }
    });
  }

  function renderLoanBySalaryData(){
    var salary_date = $("#salary_date_select").val();
    var params = `WHERE salary_date = '${salary_date}' ORDER BY due_date ASC`;
    var tbody_tr = '', total_amount = 0, total_paid_amount = 0;
    $.post("ajax/get_loan_details.php",{
        params:params
    },function(data,status){
        var res = JSON.parse(data);
        for (let index = 0; index < res.data.length; index++) {
            const row = res.data[index];
            total_amount += row.amount * 1;
            total_paid_amount += row.paid_amount * 1;

            if(row.status == 1){
                var status_btn = '<span style="color:green">Paid</span>';
            }else{
                var status_btn = `<button class="btn btn-info btn-sm" onclick="payLoan(${row.loan_detail_id})"><span class="fa fa-check"></span> Pay</button>`;
            }
            tbody_tr += `<tr>
                <td>${row.count}</td>
                <td>${row.loan_detail_name}</td>
                <td>${row.amount}</td>
                <td>${row.paid_amount}</td>
                <td>${row.amount - row.paid_amount}</td>
                <td>${row.due_date}</td>
                <td>${row.salary_date}</td>
                <td>${status_btn}</td>
            </tr>`;
        }
        $("#tblLoanDetails tbody").html(tbody_tr);
        $("#tblLoanDetails tfoot").html(`<tr>
            <th colspan='2'></th>
            <th>${total_amount}</th>
            <th>${total_paid_amount}</th>
            <th>${total_amount-total_paid_amount}</th>
        </tr>`);
    });
  }

  function payLoan(loan_detail_id){
    var conf = confirm("Are you sure?");
    if(conf){
        $.post("ajax/add_loan_payment.php",{
            loan_detail_id:loan_detail_id
        },function(data,status){
            renderLoanBySalaryData();
            success_add();
        });
    }
  }
</script>