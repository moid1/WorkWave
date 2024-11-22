@extends('layouts.app')

@section('content')

    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row justify-content-between">
                @if (count($notes) > 0)
                    <h4 class="font-bold">All Notes ({{ $notes[0]->customer->business_name }})</h4>
                @endif
                <div onclick="hurra({{ $customer->id }})" class="btn btn-primary">Create Note</div>
            </div>
            @if (count($notes) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-20">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">All Notes</h4>

                                <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Created By</th>
                                            <th>Note</th>
                                            <th>Estimated Tires</th>
                                            <th>Spoke With</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($notes as $note)
                                            <tr>
                                                <td>{{ $note->id }}</td>
                                                <td>{{ $note->user->name }}</td>
                                                <td>{{ $note->note }}</td>
                                                <td>{{ $note->estimated_tires ?? 'N/A' }}</td>
                                                <td>{{ $note->spoke_with ?? 'N/A' }}</td>
                                                <td>{{ $note->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-warning btn-sm"
                                                        onclick="editNote({{ $note->id }})">Edit</button>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this note?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

<!-- Modal for Create and Edit Note -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('notes.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="customer_id" value="">
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea class="form-control" name="note" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="estimated_tires">Estimated Tires</label>
                        <input type="text" class="form-control" name="estimated_tires">
                    </div>
                    <div class="form-group">
                        <label for="spoke_with">Spoke With</label>
                        <input type="text" class="form-control" name="spoke_with">
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

<!-- Modal for Edit Note (Same Modal, different form action) -->
<div class="modal fade" id="editNoteModal" tabindex="-1" role="dialog" aria-labelledby="editNoteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" >
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="customer_id" value="">
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea class="form-control" name="note" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="estimated_tires">Estimated Tires</label>
                        <input type="text" class="form-control" name="estimated_tires">
                    </div>
                    <div class="form-group">
                        <label for="spoke_with">Spoke With</label>
                        <input type="text" class="form-control" name="spoke_with">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Create Note Modal
    function hurra(id) {
        $('input[name=customer_id]').val(id);
        $("#exampleModal").modal();
    }

    // Edit Note Modal
    function editNote(id) {
        $.get('/notes/' + id + '/edit', function(note) {
            // Populate the fields in the modal with the current note data
            $('#editNoteModal input[name="note"]').val(note.note);
            $('#editNoteModal input[name="estimated_tires"]').val(note.estimated_tires);
            $('#editNoteModal input[name="spoke_with"]').val(note.spoke_with);
            $('#editNoteModal form').attr('action', '/update-notes/' + note.id);
            $("#editNoteModal").modal();
        });
    }
</script>
