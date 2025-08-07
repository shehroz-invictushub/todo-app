<template>
    <div class="p-6 max-w-4xl mx-auto">
        <div>
            <button v-if="!showInput" @click="toggleInput"
                class="w-12 h-12 flex items-center justify-center bg-green-500 hover:bg-green-600 text-white text-2xl rounded-full shadow-md">
                <PlusIcon class="w-6 h-6" />
            </button>
            <div v-else class="flex flex-col gap-2 w-full">
                <div class="w-full">
                    <input v-model="newTask" type="text" placeholder="Enter task name"
                        class="border border-gray-300 px-3 py-2 rounded w-full" />
                    <p v-if="errors.name" class="text-red-500 text-sm mt-1">
                        {{ errors.name[0] }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <button @click="saveTask" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Add
                    </button>
                    <button @click="cancel" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { PlusIcon } from '@heroicons/vue/24/solid'
import axios from 'axios'
export default {
    components: {
        PlusIcon
    },
    data() {
        return {
            showInput: false,
            newTask: "",
            errors: {},
        };
    },
    methods: {
        toggleInput() {
            this.showInput = true;
        },
        async saveTask() {
            this.errors = {};

            try {
                await axios.post('api/task/store', {
                    name: this.newTask
                });
                this.$emit('task-added');
            } catch (error) {
                if (error.response) {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error('Server error:', error.response.data);
                    }
                } else if (error.request) {
                    console.error('No response received:', error.request);
                } else {
                    console.error('Error setting up request:', error.message);
                }
            }

            this.newTask = "";
            if (Object.keys(this.errors).length === 0) {
                this.showInput = false;
            }
        },
        cancel() {
            this.newTask = "";
            this.showInput = false;
            this.errors = {};
        }
    },
};
</script>
