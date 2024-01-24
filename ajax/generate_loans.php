<?php
include '../core/config.php';

$supplier_id    = (int) $_POST['supplier_id'];
$loan_amount    = (float) $_POST['loan_amount'];
$loan_date      = $_POST['loan_date'];
$frequency      = (int) $_POST['frequency'];
$loan_period    = (int) $_POST['loan_period'];
$interest_rate  = (float) $_POST['interest_rate'];
$payment_start  = $_POST['payment_start'];
$loan_start_date = new DateTime($payment_start);

$loan_name = nameGenerator($supplier_id,$loan_amount);

$monthlyPayment = calculateMonthlyPayment($loan_amount, $interest_rate, $loan_period);
$monthlyPaymentNoInterest = $loan_amount / $loan_period;

$ammortizations = [];
$total_ammortization_periods = $loan_period * $frequency;
for ($i=1; $i <= $loan_period; $i++) {
    $amount_with_interest = ($monthlyPayment / $frequency);
    for ($j=1; $j <= $frequency; $j++) {

        $due_date = clone $loan_start_date;
        if($j == 1){
            $due_date->modify("+" . ($i-1) . " months");
        }

        if($j == 2){
            $due_date->modify("+" . (($i-1)*30+15) . " days");
        }

        // Set salary date to the 1st day of the month
        $salary_date = clone $due_date;
        $salary_date->modify("first day of this month");

        // Adjust salary date if it's beyond the 16th day of the month
        if ($due_date->format('d') > 16) {
            $salary_date->modify("+15 days");
        }
        
        $ammort_no = $i * $j;
        $ammortizations[] = array(
            'loan_detail_name' => "$loan_name $ammort_no/$total_ammortization_periods",
            'amount' => $amount_with_interest,
            'due_date' => $due_date->format('Y-m-d'),
            'salary_date' => $salary_date->format('Y-m-d'),
        );
    }
}

$response['data'] = array(
    'supplier_id'       => $supplier_id,
    'loan_amount'       => $loan_amount,
    'loan_name'         => $loan_name,
    'loan_date'         => $loan_date,
    'payment_start'     => $payment_start,
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

function nameGenerator($supplier_id,$amount){
    $amount_k = $amount > 0 ? number_format($amount / 1000,1,'.','') : 0;
    return getSupplierData($supplier_id) . " ". ((float)$amount_k) . "K";
}


// $amortizationSchedule = generateAmortizationSchedule($principalAmount, $annualInterestRate, $loanTermInMonths, $paymentFrequency);

// Output the results
// echo "Amortization Schedule:\n";
// echo "Payment # | Payment | Principal | Interest | Remaining Balance\n";
// foreach ($amortizationSchedule as $row) {
//     echo "{$row['PaymentNumber']} | {$row['Payment']} | {$row['Principal']} | {$row['Interest']} | {$row['Balance']}\n";
// }


