<script lang="ts" setup>
    import { ref, computed, watch, watchEffect, onMounted } from 'vue';
    import type { Task, TaskQueryResult } from '@/types'; 
    import { TASKS_QUERY } from '@/graphql/task.queries';
    import { 
        CREATE_TASK_MUTATION, 
        DELETE_TASK_MUTATION, 
        DELETE_ALL_TASKS_MUTATION, 
        UPDATE_TASK_MUTATION 
    } from '@/graphql/task.mutations';

    const newTask = ref<string>('');
    const queryVariables = ref({ limit: 5 });

    const { result } = useQuery<TaskQueryResult>(TASKS_QUERY, { status: "todo" });
    const tasks = ref<Task[]>([]);

    watch(() => result.value?.tasks, (newTasks) => {
        if (newTasks) {
            tasks.value = newTasks.map(task => ({ ...task }));
        }
    }, { deep: true });

    onMounted(() => {
        tasks.value = [];
        if (result.value?.tasks) {
            tasks.value = result.value.tasks.map(task => ({ ...task }));
        }
    });

    const addTask = async () => {
        const trimmedTask = newTask.value.trim();
        if (trimmedTask) {
            try {
                const { mutate: createTask } = useMutation(CREATE_TASK_MUTATION);
                const result = await createTask({
                    description: trimmedTask,
                    status: 'todo'
                });
                newTask.value = '';
                tasks.value.push(result?.data.createTask);
                // console.log(data);
            } catch (e) {
                console.error('Error adding task:', e);
            }
        }
    };

    const doneTasksCount = computed(() => {
        return tasks.value?.filter(task => task.status === 'done').length;
    });

    // Watch for changes in task statuses
    watch(tasks, (newTasks, oldTasks) => {
        console.log('Tasks have been updated.');
        // You can perform additional actions here if needed
    });
    const deleteAllTasks = async() => { 
        alert("Deleting all task");
        try {

            const { mutate: deleteAllTasks } = useMutation(DELETE_ALL_TASKS_MUTATION);
            const result = await deleteAllTasks();
            console.log(result?.data?.deleteAllTasks);
            
            tasks.value = [];
        } catch (e) {
            console.error('Error deleting task:', e);
        }
    };

    const deleteTask = async (index: number) => {
        alert(`Deleting task at index: ${index}`);
        try {
            const { mutate: deleteTask } = useMutation(DELETE_TASK_MUTATION);
            const taskId = tasks.value[index].id;
            const result = await deleteTask({
                id: taskId,
            });
            if (result?.data?.deleteTask) {
                // Use the correct index and delete count for splice
                tasks.value.splice(index, 1);
            }
        } catch (e) {
            console.error('Error deleting task:', e);
        }
    };
    const removeDoneTasks = () => {
        tasks.value = tasks.value?.filter(task => task.status === 'todo');
    }
    const handleStatusChange = async (index: number) => {
        try {
            const { mutate: updateTask } = useMutation(UPDATE_TASK_MUTATION);
            const status = tasks.value[index].status === 'done' ? 'todo':'done';
            tasks.value[index].status = status;
            const taskId = tasks.value[index].id;
            const result = await updateTask({
                id: taskId,
                status: status,
            });
        } catch (e) {
            console.error('Error deleting task:', e);
        }
    }
</script>

<template>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="6">
            <v-card class="mx-auto my-6" outlined rounded="lg">
                <div class="d-flex justify-space-between">
                    <div>
                    </div>
                    <div>
                    <v-badge color="white" :content="tasks.length" class="ma-2">
                        <v-btn color="primary" rounded="xl">Tasks</v-btn>
                    </v-badge>
                    <v-badge color="white" :content="doneTasksCount" class="ma-2">
                        <v-btn color="primary" rounded="xl">Task Done</v-btn>
                    </v-badge>
                    <v-btn color="red" @click="removeDoneTasks" class="ma-2" v-if="doneTasksCount">
                        <v-icon>mdi-delete</v-icon>
                        Tasks Done
                    </v-btn>
                    <v-btn color="red" @click="deleteAllTasks" class="ma-2">
                        <v-icon>mdi-delete</v-icon>
                        Tasks
                    </v-btn>
                    </div>
                </div>
                
                <v-list>
                    <v-list-item
                        v-for="(task, index) in tasks"
                        :key="index"
                    >
                        <v-checkbox 
                            color="primary"
                            :label="task.description" 
                            :model-value="task.status === 'done'"
                            :class="{ 'text-decoration-line-through': task.status === 'done' }"
                            @change="handleStatusChange(index)"
                        />
                        <template v-slot:append>
                        <v-btn @click="deleteTask(index)"
                            color="red-lighten-1"
                            icon="mdi-delete"
                            variant="text"
                        ></v-btn>
                        </template>
                    </v-list-item>
                </v-list>
                <v-card-actions>
                <v-text-field
                    class="flex-grow-1"
                    placeholder="Add a task..."
                    v-model="newTask"
                    @keyup.enter="addTask"
                ></v-text-field>
                <v-btn icon @click="addTask">
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
</template>

