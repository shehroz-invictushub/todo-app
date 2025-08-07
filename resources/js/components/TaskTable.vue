<template>
    <div class="p-6 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold mb-4">Task List</h2>
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-center text-gray-600">ID</th>
                    <th class="py-2 px-4 text-center text-gray-600">Name</th>
                    <th class="py-2 px-4 text-center text-gray-600">Status</th>
                    <th class="py-2 px-4 text-center text-gray-600">Completed At</th>
                    <th class="py-2 px-4 text-center text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody v-if="tasks.length">
                <tr v-for="task in tasks" :key="task.id" class="border-b hover:bg-gray-50">
                    <td class="py-2 text-center px-4">{{ task.id }}</td>
                    <td class="py-2 text-center px-4">{{ task.name }}</td>
                    <td class="py-2 text-center px-4">
                        <span :class="task.status === 'completed'
                            ? 'text-green-600'
                            : 'text-yellow-600'
                            ">
                            {{ task.status }}
                        </span>
                    </td>
                    <td class="py-2 text-center px-4">
                        {{ this.formatDate(task.completed_at) }}
                    </td>
                    <td class="py-2 px-4 items-center justify-center flex gap-2">
                        <button @click="completeTask(task.id)" :disabled="task.status === 'completed'" :class="task.status === 'completed'
                            ? 'bg-gray-500 text-white px-3 py-1 rounded'
                            : 'bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded'
                            ">
                            <CheckIcon class="w-5 h-5" />
                        </button>
                        <button @click="deleteTask(task.id)"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                            <TrashIcon class="w-5 h-5" />
                        </button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr class="border-b hover:bg-gray-50">
                    <td colspan="5" class="text-center text-gray-500 py-4">
                        No Tasks Available
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { CheckIcon, TrashIcon } from '@heroicons/vue/24/solid'
export default {
    components: {
        CheckIcon,
        TrashIcon
    },
    props: {
        tasks: {
            type: Array,
            required: true,
        },
    },
    methods: {
        formatDate(dateString) {
            if (!dateString) {
                return "—";
            }
            const date = new Date(dateString);
            return date.toLocaleString();
        },
        async completeTask(id) {
            try {
                await axios.put('api/task/' + id);
                this.$emit('task-completed');
            } catch (error) {
                if (error.request) {
                    console.error('No response received:', error.request);
                } else {
                    console.error('Error setting up request:', error.message);
                }
            }
        },
        async deleteTask(id) {
            try {
                await axios.delete('api/task/' + id);
                this.$emit('task-deleted');
            } catch (error) {
                if (error.request) {
                    console.error('No response received:', error.request);
                } else {
                    console.error('Error setting up request:', error.message);
                }
            }
        }
    },
};
</script>
