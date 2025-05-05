import {TodoStore} from "@/stores/modules/todo";
import Todo from "../../../services/Todo";

export default {
    resetTask() {
        TodoStore().task = {
            task_name: null,
            description: null,
        };
    },
    todoLists() {
        Todo.get("/todo-list")
            .then((response) => {
                TodoStore().todos = response.data.todos;
            })
    },

    saveTask(){
        let todo_store = TodoStore();

        Todo.save("/todo-list", todo_store.task)
            .then((response) => {
                this.todoLists();
                this.resetTask();
                todo_store.msg.info = response.data.message;
            })
            .catch((error) => {
                todo_store.msg.errors = error.response.data.errors
            });
    },

    completeTask(data){
        Todo.save("/complete-todo-list", data)
            .then((response) => {
                this.todoLists();
                TodoStore().msg.info = response.data.message;
            })
    },

    editTask(todo_id){
        Todo.edit("/todo-list", todo_id)
            .then((response) => {
                TodoStore().task = {
                    task_id: response.data.id,
                    task_name: response.data.name,
                    description: response.data.description,
                };
            })
    },

    updateTask(){
        let todo_store = TodoStore();

        Todo.update("/todo-list", todo_store.task)
            .then((response) => {
                this.todoLists();
                this.resetTask();
                todo_store.msg.info = response.data.message;
            })
            .catch((error) => {
                todo_store.msg.errors = error.response.data.errors
            });
    },

    deleteTask(todo_id){
        Todo.delete("/todo-list", todo_id)
            .then((response) => {
                this.todoLists();
                TodoStore().msg.info = response.data.message;
            })
    },
};
