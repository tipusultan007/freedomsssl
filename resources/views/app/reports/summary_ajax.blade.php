<div class="row">
  <div class="col-md-3">
    <div class="card">
      <table class="table table-sm table-bordered">
        <caption style="caption-side: top" class="text-center fw-bolder text-dark">দৈনিক সঞ্চয়</caption>
        <tr><th class="fw-bolder text-danger py-2">ঋণ প্রদান</th><td class="fw-bolder text-end"> {{ $dailyLoans->sum('loan_amount') }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">ঋণ আদায়</th><td class="fw-bolder text-end"> {{ $dailyLoanCollections->sum('loan_installment') }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">সঞ্চয় জমা</th><td class="fw-bolder text-end"> {{ $savingsCollections->where('type','deposit')->sum('saving_amount') }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">সঞ্চয় উত্তোলন</th><td class="fw-bolder text-end"> {{ $savingsCollections->where('type','withdraw')->sum('saving_amount') + $dailySavingsCompletes->sum('withdraw') }} </td></tr>
        <tr><th class="fw-bolder text-danger py-2">সঞ্চয়ের মুনাফা উত্তোলন</th><td class="fw-bolder text-end"> {{ $dailySavingsCompletes->sum('profit') }}</td></tr>

        <tr><th class="fw-bolder py-2">বিলম্ব ফি</th><td class="fw-bolder text-end"> {{ $savingsCollections->sum('late_fee') }}</td></tr>
        <tr><th class="fw-bolder py-2">অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $savingsCollections->sum('other_fee') }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণের বিলম্ব ফি</th><td class="fw-bolder text-end"> {{ $dailyLoanCollections->sum('loan_other_fee') }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণের অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $dailyLoanCollections->sum('loan_other_fee') }}</td></tr>
      </table>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card">
      <table class="table table-sm table-bordered">
        <caption style="caption-side: top" class="text-center fw-bolder text-dark">মাসিক সঞ্চয় (DPS)</caption>
        <tr><th class="fw-bolder text-danger py-2">ঋণ প্রদান</th><td class="fw-bolder text-end"> {{ $dpsLoans->sum('loan_amount') }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">ঋণ ফেরত</th><td class="fw-bolder text-end"> {{ $installments->sum('loan_installment') }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">ঋণের লভ্যাংশ</th><td class="fw-bolder text-end"> {{ $installments->sum('interest') }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">সঞ্চয় জমা</th><td class="fw-bolder text-end"> {{ $installments->sum('dps_amount') }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">সঞ্চয় উত্তোলন</th><td class="fw-bolder text-end"> {{ $dpsCompletes->sum('withdraw') }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">সঞ্চয় মুনাফা উত্তোলন</th><td class="fw-bolder text-end"> {{ $dpsCompletes->sum('profit') }}</td></tr>

        <tr><th class="fw-bolder py-2">মেয়াদ অতিরিক্ত ফি</th><td class="fw-bolder text-end"> {{ $installments->sum('late_fee') }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণ মেয়াদ অতিরিক্ত ফি</th><td class="fw-bolder text-end"> {{ $installments->sum('loan_late_fee') }}</td></tr>
        <tr><th class="fw-bolder py-2">অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $installments->sum('other_fee') }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণের অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $installments->sum('loan_other_fee') }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণ গ্রেস</th><td class="fw-bolder text-end"> {{ $installments->sum('loan_grace') }}</td></tr>
        <tr><th class="fw-bolder py-2">অগ্রগতি</th><td class="fw-bolder text-end"> {{ $installments->sum('advance') }}</td></tr>
        <tr><th class="fw-bolder py-2">বকেয়া</th><td class="fw-bolder text-end"> {{ $installments->sum('due') }}</td></tr>
        <tr><th class="fw-bolder py-2">বকেয়া ফেরত</th><td class="fw-bolder text-end"> {{ $installments->sum('due_return') }}</td></tr>
        <tr><th class="fw-bolder py-2">বকেয়া সুদ</th><td class="fw-bolder text-end"> {{ $installments->sum('due_interest') }}</td></tr>
        <tr><th class="fw-bolder py-2">অগ্রগতি ফেরত</th><td class="fw-bolder text-end"> {{ $installments->sum('advance_return') }}</td></tr>
      </table>
    </div>
  </div>


  <div class="col-md-3">
    <div class="card">
      <table class="table table-sm table-bordered">
        <caption style="caption-side: top" class="text-center fw-bolder text-dark">বিশেষ সঞ্চয় (DPS)/ঋণ আদায়</caption>
        <tr><th class="fw-bolder text-danger py-2">ঋণ প্রদান</th><td class="fw-bolder text-end"> {{ $specialDpsLoans->sum('loan_amount') }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">ঋণ ফেরত</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('loan_installment') }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">ঋণের লভ্যাংশ</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('interest') }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">সঞ্চয় জমা</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('dps_amount') }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">সঞ্চয় উত্তোলন</th><td class="fw-bolder text-end"> {{ $specialDpsCompletes->sum('withdraw') }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">সঞ্চয় মুনাফা উত্তোলন</th><td class="fw-bolder text-end"> {{ $specialDpsCompletes->sum('profit') }}</td></tr>

        <tr><th class="fw-bolder py-2">মেয়াদ অতিরিক্ত ফি</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('late_fee') }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণ মেয়াদ অতিরিক্ত ফি</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('loan_late_fee') }}</td></tr>
        <tr><th class="fw-bolder py-2">অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('other_fee') }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণের অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('loan_other_fee') }}</td></tr>
        <tr><th class="fw-bolder py-2">ঋণ গ্রেস</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('loan_grace') }}</td></tr>
        <tr><th class="fw-bolder py-2">অগ্রগতি</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('advance') }}</td></tr>
        <tr><th class="fw-bolder py-2">বকেয়া</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('due') }}</td></tr>
        <tr><th class="fw-bolder py-2">বকেয়া ফেরত</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('due_return') }}</td></tr>
        <tr><th class="fw-bolder py-2">বকেয়া সুদ</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('due_interest') }}</td></tr>
        <tr><th class="fw-bolder py-2">অগ্রগতি ফেরত</th><td class="fw-bolder text-end"> {{ $specialInstallments->sum('advance_return') }}</td></tr>
      </table>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card">
      <table class="table table-sm table-bordered">
        <caption style="caption-side: top" class="text-center fw-bolder text-dark">স্থায়ী সঞ্চয় (FDR)</caption>
        <tr><th class="fw-bolder text-success py-2">FDR জমা</th><td class="fw-bolder text-end"> {{ $fdrDeposits->sum('amount') }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">FDR উত্তোলন</th><td class="fw-bolder text-end"> {{ $fdrWithdraws->sum('amount') }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">FDR মুনাফা উত্তোলন</th><td class="fw-bolder text-end"> {{ $fdrProfits->sum('profit') }}</td></tr>
        <tr><th class="fw-bolder text-danger py-2">গ্রেস</th><td class="fw-bolder text-end"> {{ $fdrProfits->sum('grace') }}</td></tr>
        <tr><th class="fw-bolder text-success py-2">অন্যান্য ফি</th><td class="fw-bolder text-end"> {{ $fdrProfits->sum('other_fee') }}</td></tr>

      </table>
    </div>
  </div>
</div>
