<li id="todo-item-{{ $todo['id'] }}" class="list-group-item todo-item" style="padding-left: {{ $recursive + 1 }}rem">
    <div class="todo-item-parent" data-todo-id="{{ $todo['id'] }}">

    </div>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('app.switch', $todo['id']) }}"><strong class="todo-item-title @if($todo['completed']) completed @endif">{{ $todo['name'] }}</strong></a>
        <div style="overflow: hidden">
            <button
                data-item-id="{{ $todo['id'] }}"
                data-item-parent="{{ $todo['parent'] ?? '0' }}"
                class="edit-item-button badge bg-primary rounded-pill border-0"><i
                    class="bi bi-pencil-square fs-5"></i></button>
            <a
                href="{{ route('app.delete', ['id' => $todo['id']]) }}" onclick="return confirm('Are you sure you want to delete it?')"
                class="remove-item-button badge bg-danger rounded-pill"><i class="bi bi-trash3 fs-5"></i></a>
        </div>
    </div>
    @if(!empty($todo['description']))
        <span>    {{ $todo['description'] }}</span>
    @endif
</li>
    <form action="{{ route('app.update') }}" method="POST">
        @csrf
        <input name="id" value="{{ $todo['id'] }}" type="hidden"/>
        <input id="item-parent-input-{{ $todo['id'] }}" name="parent" class="item-name" value="{{ $todo['parent'] }}" type="hidden"/>
        <li class="list-group-item list-edit" id="item-edit-{{ $todo['id'] }}"
            style="background-image: linear-gradient(rgb(0 0 0/20%) 0 0); padding: 15px 20px; display: none"> {{-- p - 15px 20px, height = auto --}}
            <div class="row">
                <input type="text" class="form-control" name="name" placeholder="Title" value="{{ $todo['name'] }}"/>
            </div>
            <div class="row" style=" padding-top: 15px;">
                <textarea type="text" class="form-control" name="description" placeholder="Description">{{ $todo['description'] }}</textarea>
            </div>
            <div class="row d-flex justify-content-between btn-group" style=" padding-top: 15px;">
                <button class="btn btn-success col-11">Save</button>
                <button type="button" class="btn btn-outline-danger col-1 p-0 edit-item-button-cancel"><i class="bi bi-x-circle fs-5"></i></button>
            </div>
            <div class="row save-hint">
                <div class="col-11">
                    <span
                        class="form-text text-muted col-11">If you add new task now, it will be added as sub-task</span>
                </div>

            </div>
        </li>
    </form>

@if(!empty($todo['child']))
    @foreach($todo['child'] as $child)
        @include('layouts.todoes', ['todo' => $child, 'recursive' => $recursive + 1])
    @endforeach
@endif
