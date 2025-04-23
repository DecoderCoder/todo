import './bootstrap';

let currentEdit = -1;

function editTask(id, parent) {
    currentEdit = id;

    let item = document.querySelector('#item-edit-' + id);
    item.style.display = '';
    document.querySelectorAll('.edit-item-button, .remove-item-button').forEach((button) => {
        button.setAttribute('disabled', '');
        button.classList.add('hidden');
    });
    document.querySelectorAll('#todo-item-' + id).forEach((item) => {
        item.classList.add('d-none');
    });
    // document.querySelectorAll('.item-name').forEach((item) => {
    //     item.value = id;
    // });

    document.querySelectorAll('.todo-item-parent').forEach((item) => {
        item.classList.add('showed');
    });
    if (parent > 0) {
        document.querySelector('#todo-item-' + parent + ' .todo-item-parent').classList.add('checked');
    }
}

function removeParentChecks() {
    document.querySelectorAll('.todo-item-parent').forEach((item) => {
        item.classList.remove('checked');
    });
}

function cancelEditTask() {
    currentEdit = -1;

    document.querySelectorAll('.edit-item-button, .remove-item-button').forEach((button) => {
        button.removeAttribute('disabled');
        button.classList.remove('hidden');
    });
    document.querySelectorAll('.todo-item').forEach((item) => {
        item.classList.remove('d-none');
    });
    document.querySelectorAll('.list-edit').forEach((item) => {
        item.style.display = 'none';
    });
    document.querySelectorAll('.item-name').forEach((item) => {
        item.value = 0;
    });
    document.querySelectorAll('.todo-item-parent').forEach((item) => {
        item.classList.remove('showed');
    });
    removeParentChecks();
}

window.addEventListener('load', (event) => {
    document.querySelectorAll('.edit-item-button').forEach((button) => {
        button.addEventListener('click', () => {
                editTask(button.dataset.itemId, button.dataset.itemParent);
            }
        )
    });

    document.querySelectorAll('.edit-item-button-cancel').forEach((button) => {
        button.addEventListener('click', () => {
                cancelEditTask();
            }
        )
    });

    document.querySelectorAll('.todo-item-parent').forEach((item) => {
        item.addEventListener('click', () => {
                removeParentChecks();

                let inputVal = document.querySelector('#item-parent-input-' + currentEdit);
                if (inputVal != null && inputVal.value == item.dataset.todoId)
                    document.querySelector('#item-parent-input-' + currentEdit).value = 0;
                else {
                    document.querySelector('#item-parent-input-' + currentEdit).value = item.dataset.todoId;
                    item.classList.add('checked');
                }
            }
        )
    });
});
