<div class="topic-sidebars list-cats">
    @if(!empty($is_agent))
        <div class="widget mb-5">
            <div class="ticket-card-action">
                <div class="card-header text-center">
                    {{__('Ticket Status')}}
                </div>
                <form action="{{route('support.ticket.action',['id'=>$row->id])}}" method="post">
                    @csrf
                    <div class="card-body">
                        <label class="d-block">
                            <input
                                type="radio" value="open" id="status_new" name="status" @if($row->status == 'open') checked @endif>
                            {{__("Open")}}
                        </label>
                        <label class="d-block">
                            <input
                                type="radio" value="closed" id="status_closed" name="status" @if($row->status == 'closed') checked @endif>
                            {{__("Closed")}}
                        </label>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn-primary" name="action" value="status">{{__("Save Status")}}</button>
                    </div>
                </form>
            </div>
            <div class="ticket-card-action mt-4 mb-5">
                <div class="card-header  text-center">
                    {{__('User Notes')}}
                </div>
                <div class="card-body">
                    <form action="{{route('support.ticket.action',['id'=>$row->id])}}" method="post">
                        @csrf
                        <label for="">{{__("Add note")}}</label>
                        <textarea name="note_content" class="form-control" cols="30" rows="3"></textarea>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary" name="action" value="user_note">{{__("Add user note")}}</button>
                        </div>
                    </form>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($row->customer->notes as $note)
                        <li class="list-group-item">
                            <div class="note-content">
                                {!! nl2br($note->content) !!}
                            </div>
                            <small>
                                <i>{{display_datetime($note->created_at)}}</i>
                            </small>
                            <div class="d-flex justify-content-between mt-2">
                                <a data-toggle="modal" data-target="#edit_note_{{$note->id}}" href="#" class="doc_border_btn btn_small">Edit</a>
                                <form
                                    onsubmit="return confirm('Do you want to delete this note')"
                                    action="{{route('support.note.delete',['id'=>$note->id])}}"
                                    method="post"
                                > @csrf
                                    <button type="submit" class="btn btn-link btn-sm text-danger">{{__('Delete')}}</button>
                                </form>
                            </div>
                            <form action="{{route('support.note.update',['id'=>$note->id])}}" method="post">
                                @csrf
                                <div class="modal" tabindex="-1" id="edit_note_{{$note->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Note</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5>{{__("Old")}}</h5>
                                                <p>{!! nl2br($note->content) !!}</p>
                                                <h5>{{__("New")}}</h5>
                                                <textarea rows="5" class="form-control" name="content">{{$note->content}}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    @endif</div>
