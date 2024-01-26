<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Loans</h1>
</div>

<div class="card shadow mb-4 border-left-primary">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tblLoanDetails" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Loan Date</th>
                      <th>Principal</th>
                      <th>Total Amount</th>
                      <th>Paid Amount</th>
                      <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr style="background-color:#B9F6CA;color:#424242;font-size:12px;">
                        <td colspan="5" style="text-align:right;">Total:</td>
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
  var isEdit = false, table, form_loans = [];
  $(document).ready(function() {
    renderLoans();
  });
  
  function renderLoans(){
    var params = `ORDER BY loan_date ASC`;
    var tbody_tr = '', total_loan_amount = 0, total_paid_amount = 0, total_balance = 0 ,total_amount_with_interest = 0;
    $.post("ajax/get_loans.php",{
        params:params
    },function(data,status){
        var res = JSON.parse(data);
        for (let index = 0; index < res.data.length; index++) {
            const row = res.data[index];
            total_loan_amount += row.loan_amount * 1;
            total_paid_amount += row.paid_amount * 1;
            total_balance += row.balance * 1;
            total_amount_with_interest += row.total_amount * 1;
            tbody_tr += `<tr>
                <td>${row.count}</td>
                <td>${row.loan_name}</td>
                <td>${row.loan_date}</td>
                <td class="text-right">${numberFormat(row.loan_amount)}</td>
                <td class="text-right">${numberFormat(row.total_amount)}</td>
                <td class="text-right">${numberFormat(row.paid_amount)}</td>
                <td class="text-right">${numberFormat(row.balance)}</td>
            </tr>`;
        }
        $("#tblLoanDetails tbody").html(tbody_tr);
        $("#tblLoanDetails tfoot").html(`<tr style="background-color:#B9F6CA;color:#424242;font-size:12px;">
            <th colspan='3'></th>
            <th class="text-right">${numberFormat(total_loan_amount)}</th>
            <th class="text-right">${numberFormat(total_amount_with_interest)}</th>
            <th class="text-right">${numberFormat(total_paid_amount)}</th>
            <th class="text-right">${numberFormat(total_balance)}</th>
        </tr>`);
    });
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