<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Notes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('notes.store')}}" method="POST">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="customer_id">
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Title:</label>
              <input type="text" value="Permanent Notes" class="form-control" id="notesTitle" name="notes_title">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Note</label>
              <textarea name="note" class="form-control" id="message-text"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Note</button>
        </div>
      </form>

      </div>
    </div>
  </div>

  