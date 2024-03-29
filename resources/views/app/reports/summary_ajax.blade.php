<div class="row">
  <div class="col-md-3">
    <div class="card">
      <table class="table table-sm table-bordered">
        <caption style="caption-side: top" class="text-center fw-bolder text-dark">দৈনিক সঞ্চয়</caption>
        <tr><th class="fw-bolder text-danger py-2">ঋণ প্রদান</th><td class="fw-bolder text-end"> {{ $dailyLoans->loan_amount }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">ঋণ আদায়</th><td class="fw-bolder text-end"> {{ $dailyLoanCollections->loan_installment }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">সঞ্চয় জমা</th><td class="fw-bolder text-end"> {{ $savingsCollections->deposit_amount }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">সঞ্চয় উত্তোলন</th><td class="fw-bolder text-end"> {{ $savingsCollections->saving_amount + $dailySavingsCompletes->withdraw }} </td></tr>
        <tr><th class="fw-bolder text-danger py-2">সঞ্চয়ের মুনাফা উত্তোলন</th><td class="fw-bolder text-end"> {{ $dailySavingsCompletes->profit }}</td></tr>

        <tr><th class="fw-bolder py-2">বিলম্ব ফি</th><td class="fw-bolder text-end"> {{ $savingsCollections->late_fee }}</td></tr>
        <tr><th class="fw-bolder py-2">অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $savingsCollections->other_fee }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণের বিলম্ব ফি</th><td class="fw-bolder text-end"> {{ $dailyLoanCollections->loan_other_fee }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণের অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $dailyLoanCollections->loan_other_fee }}</td></tr>
      </table>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card">
      <table class="table table-sm table-bordered">
        <caption style="caption-side: top" class="text-center fw-bolder text-dark">মাসিক সঞ্চয় (DPS)</caption>
        <tr><th class="fw-bolder text-danger py-2">ঋণ প্রদান</th><td class="fw-bolder text-end"> {{ $dpsLoans->loan_amount }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">ঋণ ফেরত</th><td class="fw-bolder text-end"> {{ $dpsInstallments->loan_installment }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">ঋণের লভ্যাংশ</th><td class="fw-bolder text-end"> {{ $dpsInstallments->interest }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">সঞ্চয় জমা</th><td class="fw-bolder text-end"> {{ $dpsInstallments->dps_amount }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">সঞ্চয় উত্তোলন</th><td class="fw-bolder text-end"> {{ $dpsCompletes->withdraw }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">সঞ্চয় মুনাফা উত্তোলন</th><td class="fw-bolder text-end"> {{ $dpsCompletes->profit }}</td></tr>

        <tr><th class="fw-bolder py-2">মেয়াদ অতিরিক্ত ফি</th><td class="fw-bolder text-end"> {{ $dpsInstallments->late_fee }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণ মেয়াদ অতিরিক্ত ফি</th><td class="fw-bolder text-end"> {{ $dpsInstallments->loan_late_fee }}</td></tr>
        <tr><th class="fw-bolder py-2">অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $dpsInstallments->other_fee }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণের অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $dpsInstallments->loan_other_fee }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণ গ্রেস</th><td class="fw-bolder text-end"> {{ $dpsInstallments->loan_grace }}</td></tr>
        <tr><th class="fw-bolder py-2">অগ্রগতি</th><td class="fw-bolder text-end"> {{ $dpsInstallments->advance }}</td></tr>
        <tr><th class="fw-bolder py-2">বকেয়া</th><td class="fw-bolder text-end"> {{ $dpsInstallments->due }}</td></tr>
        <tr><th class="fw-bolder py-2">বকেয়া ফেরত</th><td class="fw-bolder text-end"> {{ $dpsInstallments->due_return }}</td></tr>
        <tr><th class="fw-bolder py-2">বকেয়া সুদ</th><td class="fw-bolder text-end"> {{ $dpsInstallments->due_interest }}</td></tr>
        <tr><th class="fw-bolder py-2">অগ্রগতি ফেরত</th><td class="fw-bolder text-end"> {{ $dpsInstallments->advance_return }}</td></tr>
      </table>
    </div>
  </div>


  <div class="col-md-3">
    <div class="card">
      <table class="table table-sm table-bordered">
        <caption style="caption-side: top" class="text-center fw-bolder text-dark">বিশেষ সঞ্চয় (DPS)/ঋণ আদায়</caption>
        <tr><th class="fw-bolder text-danger py-2">ঋণ প্রদান</th><td class="fw-bolder text-end"> {{ $specialDpsLoans->loan_amount }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">ঋণ ফেরত</th><td class="fw-bolder text-end"> {{ $specialInstallments->loan_installment }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">ঋণের লভ্যাংশ</th><td class="fw-bolder text-end"> {{ $specialInstallments->interest }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">সঞ্চয় জমা</th><td class="fw-bolder text-end"> {{ $specialInstallments->dps_amount }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">সঞ্চয় উত্তোলন</th><td class="fw-bolder text-end"> {{ $specialDpsCompletes->withdraw }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">সঞ্চয় মুনাফা উত্তোলন</th><td class="fw-bolder text-end"> {{ $specialDpsCompletes->profit }}</td></tr>

        <tr><th class="fw-bolder py-2">মেয়াদ অতিরিক্ত ফি</th><td class="fw-bolder text-end"> {{ $specialInstallments->late_fee }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণ মেয়াদ অতিরিক্ত ফি</th><td class="fw-bolder text-end"> {{ $specialInstallments->loan_late_fee }}</td></tr>
        <tr><th class="fw-bolder py-2">অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $specialInstallments->other_fee }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণের অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $specialInstallments->loan_other_fee }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণ গ্রেস</th><td class="fw-bolder text-end"> {{ $specialInstallments->loan_grace }}</td></tr>
        <tr><th class="fw-bolder py-2">অগ্রগতি</th><td class="fw-bolder text-end"> {{ $specialInstallments->advance }}</td></tr>
        <tr><th class="fw-bolder py-2">বকেয়া</th><td class="fw-bolder text-end"> {{ $specialInstallments->due }}</td></tr>
        <tr><th class="fw-bolder py-2">বকেয়া ফেরত</th><td class="fw-bolder text-end"> {{ $specialInstallments->due_return }}</td></tr>
        <tr><th class="fw-bolder py-2">বকেয়া সুদ</th><td class="fw-bolder text-end"> {{ $specialInstallments->due_interest }}</td></tr>
        <tr><th class="fw-bolder py-2">অগ্রগতি ফেরত</th><td class="fw-bolder text-end"> {{ $specialInstallments->advance_return }}</td></tr>
      </table>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card">
      <table class="table table-sm table-bordered">
        <caption style="caption-side: top" class="text-center fw-bolder text-dark">স্থায়ী সঞ্চয় (FDR)</caption>
        <tr><th class="fw-bolder text-success py-2">FDR জমা</th><td class="fw-bolder text-end"> {{ $fdrDeposits->amount }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">FDR উত্তোলন</th><td class="fw-bolder text-end"> {{ $fdrWithdraws->amount }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">FDR মুনাফা উত্তোলন</th><td class="fw-bolder text-end"> {{ $fdrProfits->profit }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">গ্রেস</th><td class="fw-bolder text-end"> {{ $fdrProfits->grace }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $fdrProfits->other_fee }}</td></tr>

      </table>
    </div>
  </div>
</div>
