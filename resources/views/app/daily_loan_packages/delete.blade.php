<!-- Delete Confirmation Modal -->
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="deleteModalLabel{{ $dailyLoanPackage->id }}">Confirm Deletion</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to delete this record?</p>
    </div>
    <div class="modal-footer">
      <form action="{{ route('daily-loan-packages.destroy', $dailyLoanPackage->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Delete</button>
      </form>
    </div>
  </div>
</div>
