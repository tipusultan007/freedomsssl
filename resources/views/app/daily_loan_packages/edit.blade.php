<!-- Form for editing a DailyLoanPackage record -->
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="editModalLabel{{ $dailyLoanPackage->id }}">Edit Daily Loan Package</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form action="{{ route('daily-loan-packages.update', $dailyLoanPackage->id) }}" method="POST">
        @csrf
        @method('PUT')
       <div class="form-group">
         <label for="months" class="form-label">Months:</label>
         <input type="text" name="months" class="form-control" value="{{ $dailyLoanPackage->months }}">
       </div>
       <div class="form-group">
         <label for="interest" class="form-label">Interest:</label>
         <input type="text" name="interest" class="form-control" value="{{ $dailyLoanPackage->interest }}">
       </div>
        <button type="submit" class="btn btn-primary mt-2">Update</button>
      </form>
    </div>
  </div>
</div>
