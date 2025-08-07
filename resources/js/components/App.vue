<template>
    <div class="min-h-screen bg-gray-100 p-6">
        <h1 class="text-3xl font-bold text-center mb-6">My Todo App</h1>
        <AddTask @task-added="fetchTasks" />
        <TaskTable :tasks="tasks" @task-completed = "fetchTasks" @task-deleted = "fetchTasks"/>
    </div>
</template>

<script>
import TaskTable from './TaskTable.vue'
import AddTask from './AddTask.vue'
import axios from 'axios'

export default {
    components: {
        TaskTable,
        AddTask
    },

    data() {
        return {
            tasks: []
        }
    },

    methods: {
        async fetchTasks() {
            try {
                const response = await axios.get('api/tasks')
                this.tasks = response.data;
            }
            catch (error) {
                console.error('Failed to load tasks', error);
            }
        }
    },

    mounted() {
        this.fetchTasks();
    }
}

</script>
