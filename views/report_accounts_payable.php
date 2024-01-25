<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Loans</h1>
</div>

<div class="card shadow mb-4 border-left-success">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tbl_supplier" width="100%" cellspacing="0">
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
    renderUser();
  });
  function renderUser() {
    $("#tbl_supplier").DataTable().destroy();
    table = $("#tbl_supplier").DataTable({
      ajax: "ajax/get_loans.php",
      paging:false,
      scrollY:"400px",
      "footerCallback": function(row, data, start, end, display) {
            var api = this.api(),
                data;

            var intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            total = api.column(6).data().reduce(function(a, b) {return intVal(a) + intVal(b);}, 0);
            pageTotal = api.column(6, {page: 'current'}).data().reduce(function(a, b) {return intVal(a) + intVal(b);}, 0);

            $(api.column(6).footer()).html(
                "<strong><span>&#8369;</span> " + this.fnSettings().fnFormatNumber(parseFloat(parseFloat(pageTotal).toFixed(2))) + " (<span>&#8369;</span> " + this.fnSettings().fnFormatNumber(parseFloat(parseFloat(total).toFixed(2))) + " Total)</strong>"
            );
        },
      columns: [
        { data: 'count' },
        { data: 'loan_name' },
        { data: 'loan_date' },
        { data: 'loan_amount' },
        { data: 'total_amount' },
        { data: 'paid_amount' },
        { data: 'balance' }
      ]
    });
  }

  function getTotal(){
    let totalAmount = table.column('balance:name').data().reduce(function (a, b) {
        return a + b;
    }, 0);
    alert(totalAmount);
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