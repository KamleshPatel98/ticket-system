<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ticket List') }}
            </h2>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Ticket
            </button>
        </div>
    </x-slot>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>SN.</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->subject }}</td>
                    <td>{{ $row->description }}</td>
                    <td>{{ $row->priority }}</td>
                    <td>{{ $row->status }}</td>
                    <td class="d-flex justify-content-center gap-2 align-items-center">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}">
                            Edit
                        </button>

                        <form action="{{ route('tickets.destroy', $row->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $records->links('pagination::bootstrap-5') }}
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tickets.store') }}" method="POST">
                @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Ticket</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Subject -->
                        <div>
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" maxlength="255" required>
                        </div>

                        <!-- Description -->
                        <div class="mt-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" required></textarea>
                        </div>

                        <!-- Priority -->
                        <div class="mt-3">
                            <label for="priority">Priority</label>
                            <select class="form-select" name="priority" id="priority" required>
                                <option value="">Select Priority</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="mt-3">
                            <label for="status">Status</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="">Select Status</option>
                                <option value="open">Open</option>
                                <option value="in_progress">In Progress</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($records as $ticket)
    <!-- Update Modal -->
    <div class="modal fade" id="editModal{{ $ticket->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $ticket->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                @csrf
                @method('PUT')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel{{ $ticket->id }}">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Subject -->
                        <div>
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" value="{{ $ticket->subject }}" maxlength="255" required>
                        </div>

                        <!-- Description -->
                        <div class="mt-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" required>{{ $ticket->description }}</textarea>
                        </div>

                        <!-- Priority -->
                        <div class="mt-3">
                            <label for="priority">Priority</label>
                            <select class="form-select" name="priority" id="priority" required>
                                <option value="">Select Priority</option>
                                <option value="low" @selected($ticket->priority == "low")>Low</option>
                                <option value="medium" @selected($ticket->priority == "medium")>Medium</option>
                                <option value="high" @selected($ticket->priority == "high")>High</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="mt-3">
                            <label for="status">Status</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="">Select Status</option>
                                <option value="open" @selected($ticket->status == "open")>Open</option>
                                <option value="in_progress" @selected($ticket->status == "in_progress")>In Progress</option>
                                <option value="closed" @selected($ticket->status == "closed")>Closed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>