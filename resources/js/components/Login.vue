<script setup>
import {AuthStore} from "@/stores/modules/auth";
let auth_store = AuthStore();

let form_data = {
    email: null,
    password: null,
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <form action="" class="bg-white p-6 rounded-xl shadow-md w-full max-w-xs space-y-4" @submit.prevent="auth_store.login(form_data)">
            <h2 class="text-xl font-bold text-center text-gray-800">Login</h2>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="you@example.com"
                    required
                    v-model="form_data.email"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="••••••••"
                    required
                    v-model="form_data.password"
                >
            </div>

            <span v-if="auth_store.msg" class="text-red-500 text-sm mt-2 block" v-text="auth_store.msg"></span>

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 rounded-md transition duration-200"
            >
                Login
            </button>
        </form>
    </div>
</template>
