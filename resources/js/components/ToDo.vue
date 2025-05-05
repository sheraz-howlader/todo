<script setup>
import {onMounted, watch} from "vue";
import {AuthStore} from "@/stores/modules/auth";
import {TodoStore} from "@/stores/modules/todo";

let auth_store = AuthStore();
let todo_store = TodoStore();

onMounted(() => {
    todo_store.todoLists();
});

// disappear login message
watch(() => auth_store.msg, (newVal) => {
    if (auth_store.msg) {
        setTimeout(() => {
            auth_store.msg = null
        }, 3000)
    }
})

</script>

<template>
    <div class="min-h-screen bg-gray-100 py-10 px-4">
        <!-- Logout & Message -->
        <div class="max-w-6xl mx-auto mb-6 text-center">
            <button
                @click="auth_store.logout"
                class="w-full md:w-48 bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-2 rounded-md transition duration-200"
            >
                Log Out
            </button>

            <p v-if="auth_store.msg" class="text-green-600 mt-3 text-sm font-medium" v-text="auth_store.msg" ></p>
        </div>

        <div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-6">
            <!-- Task List - Left -->
            <div class="flex-1 bg-white border border-gray-200 rounded-xl shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Your Tasks</h3>

                <div
                        v-for="(todo, index) in todo_store.todos"
                        :key="index"
                        class="p-4 bg-gray-50 border border-gray-200 rounded-lg hover:shadow-sm transition"
                    >
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                :checked="todo.is_complete"
                                @click.prevent="todo_store.completeTask({status: !todo.is_complete, task_id: todo.id})"
                                class="mt-1 accent-blue-600"
                            />
                            <div>
                                <!-- Task Title -->
                                <p :class="['text-base', todo.is_complete ? 'text-gray-400 line-through' : 'text-gray-800 font-medium']" v-text="todo.name"></p>

                                <!-- Task Description -->
                                <p v-if="todo.description" :class="['text-sm mt-1', todo.is_complete ? 'text-gray-300 line-through' : 'text-gray-600']" v-text="todo.description"></p>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2 items-center">
                                <button
                                    @click.prevent="todo_store.editTask(todo.id)"
                                    class="text-blue-500 hover:text-blue-700 transition text-sm"
                                    title="Edit"
                                >
                                    ✏️
                                </button>
                                <button
                                    @click.prevent="todo_store.deleteTask(todo.id)"
                                    class="text-red-500 hover:text-red-700 transition text-sm"
                                    title="Delete"
                                >
                                    🗑️
                                </button>
                            </div>
                        </label>
                    </div>

                <p class="text-gray-500 text-sm italic" v-if="!todo_store.todos.length">No tasks yet. Add some!</p>
            </div>


            <!-- Add Task - Right -->
            <div class="w-full md:w-[400px] bg-white border border-gray-200 rounded-xl shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4"> {{ todo_store.task.task_id ? "Update Task" : "Add New Task"}}</h2>

                <div class="space-y-4">
                    <div>
                        <label for="task_name" class="block text-sm font-medium text-gray-700">Title</label>
                        <input
                            id="task_name"
                            type="text"
                            placeholder="Enter task title"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            v-model="todo_store.task.task_name"
                        />
                    </div>

                    <div>
                        <label for="task_desc" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea
                            id="task_desc"
                            rows="3"
                            placeholder="Enter task description"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                            v-model="todo_store.task.description"
                        ></textarea>
                    </div>

                    <button v-if="todo_store.task.task_id"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 rounded-md transition duration-200"
                        @click.prevent="todo_store.updateTask()"
                    >
                        Update Task
                    </button>

                    <button v-else
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 rounded-md transition duration-200"
                        @click.prevent="todo_store.saveTask()"
                    >
                        Save Task
                    </button>

                    <!-- Info Message -->
                    <p v-if="todo_store.msg?.info" class="text-green-600 mt-3 text-sm font-medium" v-text="todo_store.msg.info"></p>

                    <!-- Validation Errors -->
                    <div v-if="todo_store.msg?.errors" class="mt-3 space-y-1">
                        <p
                            v-for="(errors, field) in todo_store.msg.errors"
                            :key="field"
                            class="text-red-600 text-sm font-medium"
                        >
                            {{ errors[0] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
