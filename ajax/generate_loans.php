<?php
include '../core/config.php';

$supplier_id    = (int) $_POST['supplier_id'];
$loan_amount    = (float) $_POST['loan_amount'];
$loan_date      = $_POST['loan_date'];
$frequency      = (int) $_POST['frequency'];
$loan_period    = (int) $_POST['loan_period'];
$interest_rate  = (float) $_POST['interest_rate'];

$loan_name = "GCash 20K";

$monthlyPayment = calculateMonthlyPayment($loan_amount, $interest_rate, $loan_period);
$monthlyPaymentNoInterest = $loan_amount / $loan_period;

$ammortizations = [];
$total_ammortization_periods = $loan_period * $frequency;
for ($i=1; $i <= $loan_period; $i++) {
    $amount_with_interest = ($monthlyPayment / $frequency);
    for ($j=1; $j <= $frequency; $j++) {
        $due_date = '';
        $salary_date = '';
        $ammort_no = $i * $j;
        $ammortizations[] = array(
            'loan_detail_name' => "$loan_name $ammort_no/$total_ammortization_periods",
            'amount' => $amount_with_interest,
            'due_date' => $due_date,
            'salary_date' => $salary_date,
        );
    }
}

$response['data'] = array(
    'supplier_id'       => $supplier_id,
    'loan_amount'       => $loan_amount,
    'loan_date'         => $loan_date,
    'frequency'         => $frequency,
    'loan_period'       => $loan_period,
    'interest_rate'     => $interest_rate,
    'monthly_payment'   => $monthlyPayment,
    'ammortizations'    => $ammortizations
);

echo json_encode($response);

function calculateMonthlyPayment($principal, $monthlyInterestRate, $loanTermInMonths) {
    $interest = $monthlyInterestRate / 100;
    $gross_mo = $principal / $loanTermInMonths;
    return ($gross_mo + ($principal * $interest));
}

// $amortizationSchedule = generateAmortizationSchedule($principalAmount, $annualInterestRate, $loanTermInMonths, $paymentFrequency);

// Output the results
// echo "Amortization Schedule:\n";
// echo "Payment # | Payment | Principal | Interest | Remaining Balance\n";
// foreach ($amortizationSchedule as $row) {
//     echo "{$row['PaymentNumber']} | {$row['Payment']} | {$row['Principal']} | {$row['Interest']} | {$row['Balance']}\n";
// }


